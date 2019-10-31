<?php

namespace Testjob\TestjobBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Testjob\TestjobBundle\Form\LoginForm;
use Testjob\TestjobBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Testjob\TestjobBundle\Form\UserRegistrationForm;

class SecurityController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function loginAction()
    {
        $authenticationUtils = $this->get('security.authentication_utils');
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        $form = $this->createForm(LoginForm::class, [
            '_username' => $lastUsername,
        ]);

        return $this->render(
            'TestjobBundle:Security:login.html.twig',
            [
                'form' => $form->createView(),
                'error' => $error,
            ]
        );
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function registrAction(Request $request)
    {
        $form = $this->createForm(UserRegistrationForm::class);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $user = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $user_role = $em->getRepository('TestjobBundle:Roles')->findOneBy(['role_name' => User::ROLE_USER]);
            $user->addRoles($user_role);
            $user->setCreated(new \DateTime());
            $user->setConfirmed(false);
            $user->setBanned(false);
            $em->persist($user);
            $em->flush();

            return $this->render('TestjobBundle:Security:access.html.twig');
        }

        return $this->render('TestjobBundle:Security:registr.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @throws \Exception
     */
    public function logoutAction()
    {
        throw new \Exception('this should not be reached!');
    }
}
