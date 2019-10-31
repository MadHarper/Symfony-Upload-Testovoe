<?php

namespace Testjob\TestjobBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Testjob\TestjobBundle\Entity\Image;
use Testjob\TestjobBundle\Form\ImageForm;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('TestjobBundle:Default:index.html.twig');
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function galleryAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $images = $em->getRepository('TestjobBundle:Image')->findAll();

        $paginator = $this->get('knp_paginator');
        $result = $paginator->paginate(
            $images,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 2)
        );

        return $this->render('TestjobBundle:Default:gallery.html.twig', ['images' => $result]);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function addAction(Request $request)
    {
        $image = new Image();
        $form = $this->createForm(ImageForm::class, $image);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $file = $image->getImage();
            $fileName = md5(uniqid()). '.' .$file->guessExtension();

            $file->move(
                $this->getParameter('gallery_directory'),
                $fileName
            );

            $image->setImage($fileName);

            $em = $this->getDoctrine()->getManager();
            $image->setAuthor($this->getUser());
            $em->persist($image);
            $em->flush();

            return $this->redirect($this->generateUrl('testjob_gallery'));
        }

        return $this->render('TestjobBundle:Default:add.html.twig', ['form' => $form->createView(),]);
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function deleteAction($id, Request $request){

        if($request->isXmlHttpRequest()){
            $em = $this->getDoctrine()->getManager();
            $image = $em->getRepository('TestjobBundle:Image')->find($id);

            if (!$image) {
                return $this->json(['success' => 0]);
            }

            $em->remove($image);
            $em->flush();

            return $this->json(['success' => 1]);
        }
    }
}
