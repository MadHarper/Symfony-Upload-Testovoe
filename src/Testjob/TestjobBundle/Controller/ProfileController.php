<?php

namespace Testjob\TestjobBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Testjob\TestjobBundle\Form\ProfileForm;

class ProfileController extends Controller
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request){

        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $form = $this->createForm(ProfileForm::class, $user);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em->flush();
        }

        return $this->render('TestjobBundle:Profile:index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
