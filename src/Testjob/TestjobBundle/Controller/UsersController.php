<?php

namespace Testjob\TestjobBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UsersController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('TestjobBundle:User')->findAll();

        return $this->render('TestjobBundle:Users:index.html.twig', ['users' => $users]);
    }

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('TestjobBundle:User')->find($id);

        if (!$user) {
            throw $this->createNotFoundException('Такого пользователя не существует');
        }

        return $this->render('TestjobBundle:Users:edit.html.twig', ['user' => $user]);
    }

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('TestjobBundle:User')->find($id);

        if (!$user) {
            throw $this->createNotFoundException('Такого пользователя не существует');
        }

        $em->remove($user);
        $em->flush();

        return $this->redirect(
            $this->generateUrl("testjob_users")
        );
    }

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Exception
     */
    public function confirmAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('TestjobBundle:User')->find($id);

        if (!$user) {
            throw $this->createNotFoundException('Такого пользователя не существует');
        }

        $user->setConfirmed(true);
        $user->setRegistred(new \DateTime());
        $em->flush();

        //послать почту
        $message = \Swift_Message::newInstance()
            ->setSubject('Подтверждение регистрации на testjob')
            ->setFrom('testjob1717@gmail.com')
            ->setTo($user->getEmail())
            ->setBody($this->renderView('TestjobBundle:Security:confirm_mail.html.twig', ['name' => $user->getUsername()]));

        $this->get('mailer')->send($message);

        return $this->redirect(
            $this->generateUrl("testjob_users")
        );
    }

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function banAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('TestjobBundle:User')->find($id);

        if (!$user) {
            throw $this->createNotFoundException('Такого пользователя не существует');
        }

        if($user->getBanned()){
            $user->setBanned(false);
        }else{
            $user->setBanned(true);
        }

        $em->flush();

        return $this->redirect(
            $this->generateUrl("testjob_users")
        );
    }
}
