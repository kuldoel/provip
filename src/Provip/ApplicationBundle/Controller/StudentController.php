<?php

namespace Provip\ApplicationBundle\Controller;

use Provip\EventsBundle\Entity\ActivityUpdateEvent;
use Provip\EventsBundle\Entity\ApplicationEvent;
use Provip\EventsBundle\Entity\Notification;
use Provip\EventsBundle\Entity\Picture;
use Provip\ProvipBundle\Entity\Internship;
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
        if($this->getUser()->getEnrollment()->getApproved() == false)
        {
            $this->get('session')->getFlashBag()->add('danger', 'Your enrollment is not yet approved');
            return $this->redirect($this->generateUrl('provip_application_student_settings'));
        }


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


    /**
     * @Route("/student/internships/mark-complete/{publicId}", options={"expose"=true})
     */
    public function markCompleteAction(Internship $internship)
    {
        $em = $this->getDoctrine()->getManager();

        $internship->setCompleted(true);
        $em->persist($internship);

        $event = new ApplicationEvent($this->getUser(), ' marked his internship as completed', $internship->getPublicId(), 'privacy.internship', $internship->getApplication());

        foreach($event->getRecipients() as $r) {
           $notification = new Notification($r, $event, $internship->getPublicId());
            $em->persist($notification);
        }

        $em->flush();

        return new Response('Succesfully marked this internship as complete', 200);

    }


    /**
     * @Route("/student/internships/update/{id}/remove", options={"expose"=true})
     */
    public function removeUpdateAction(ActivityUpdateEvent $event)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($event);
        $em->flush();

        return new Response('Update Removed', 200);

    }
}
