<?php

namespace Provip\ApplicationBundle\Controller;

use Provip\EventsBundle\Entity\Picture;
use Provip\UserBundle\Entity\User;
use Provip\UserBundle\Form\Type\StudentProfileType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class StudentController extends Controller
{
    /**
     * @Route("/student")
     */
    public function dashboardAction()
    {
        return $this->render('ProvipApplicationBundle:Student:index.html.twig');
    }

   /**
    * @Route("/student/account-settings")
    */
    public function settingsAction(Request $request)
    {
        $user = $this->getUser();
        $form       = $this->createForm(new StudentProfileType(), $user);

        if ($request->isMethod('POST'))
        {
            $form->handleRequest($request);

            if($form->isValid())
            {

                $em = $this->getDoctrine()->getManager();

                $user->setProfileComplete(true);

                $em->persist($user);
                $em->flush();

                $this->get('session')->getFlashBag()->add('success', 'Your changes were succesfully saved!');
                return $this->redirect($this->generateUrl('provip_application_student_settings'));

            }

        }


        return $this->render('ProvipApplicationBundle:Student:settings.html.twig', array('form' => $form->createView()));
    }

    /**
     * @Route("/student/account-settings/delete-picture")
     */
    public function deletePictureAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $user = $this->getUser();
        $picture = $user->getPicture();

        if($picture instanceof Picture)

        {
            $user->setPicture(NULL);

            $em->persist($user);
            $em->flush();
        }

        $this->get('session')->getFlashBag()->add('success', 'Your profile picture was succesfully deleted.');
        return $this->redirect($this->generateUrl('provip_application_student_settings'));

    }
}
