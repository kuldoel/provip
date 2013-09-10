<?php


namespace Provip\EventsBundle\Controller;

use Provip\EventsBundle\Entity\ActivityUpdateEvent;
use Provip\EventsBundle\Entity\FeedbackEvent;
use Provip\EventsBundle\Entity\Notification;
use Provip\EventsBundle\Form\Type\ActivityUpdateEventType;
use Provip\EventsBundle\Form\Type\FeedbackEventType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class StudentEventController extends Controller
{

    /**
     * @Route("/student/status/new", options={"expose"=true})
     */
    public function newStatusAction(Request $request)
    {
        $activityUpdateEvent = new ActivityUpdateEvent();

        $form = $this->createForm(new ActivityUpdateEventType($this->getUser()), $activityUpdateEvent);

        if ('POST' === $request->getMethod()) {

            $form->handleRequest($request);

            if ($form->isValid()) {

                $em = $this->getDoctrine()->getManager();

                $activity = $activityUpdateEvent->getActivity();

                if($activity) {

                    $activity = $activityUpdateEvent->getActivity();
                    $activity->setState($activityUpdateEvent->getState());
                    $em->persist($activity);

                    $currentInternship = $this->getUser()->getCurrentInternship();

                    if($activityUpdateEvent->getPrivacy() == 'privacy.company.only') {
                        $notification = new Notification(
                            $currentInternship->getApplication()->getOpportunity->getMentor(),
                            $activityUpdateEvent,
                            'has posted an activity update'
                        );
                        $em->persist($notification);
                    }
                    elseif($activityUpdateEvent->getPrivacy() == 'privacy.hei.only') {
                        $notification = new Notification(
                            $currentInternship->getApplication()->getCoach(),
                            $activityUpdateEvent,
                            'has posted an activity update'
                        );
                        $em->persist($notification);
                    }
                    else {
                        $notification = new Notification(
                            $currentInternship->getApplication()->getOpportunity->getMentor(),
                            $activityUpdateEvent,
                            'has posted an activity update'
                        );
                        $notification2 = new Notification(
                            $currentInternship->getApplication()->getCoach(),
                            $activityUpdateEvent,
                            'has posted an activity update'
                        );

                        $em->persist($notification);
                        $em->persist($notification2);
                    }

                }

                $activityUpdateEvent->setAuthor($this->getUser());

                $em->persist($activityUpdateEvent);

                $em->flush();

                return new Response($this->renderView('ProvipApplicationBundle:Widgets:activityupdateevent_new.html.twig', array('e' => $activityUpdateEvent)), 200);

            }
            else
            {
                return new Response($this->renderView('ProvipApplicationBundle:Widgets:form_errors.html.twig', array('errors' => $form->getErrors())), 400);

            }
        }

        return new Response($this->renderView('ProvipApplicationBundle:Widgets:activityupdateevent.html.twig', array('form' => $form->createView())), 200);

    }

    /**
     * @Route("/company/feedback/{id}", options={"expose"=true})
     */
    public function addFeedbackAction(ActivityUpdateEvent $activityUpdateEvent, Request $request)
    {
        $feedbackEvent = new FeedbackEvent($this->getUser());
        $form = $this->createForm(new FeedbackEventType(), $feedbackEvent);

        if ('POST' === $request->getMethod()) {

            $form->handleRequest($request);

            if ($form->isValid()) {

                $em = $this->getDoctrine()->getManager();

                $feedbackEvent->setActivityUpdateEvent($activityUpdateEvent);
                $feedbackEvent->setPrivacy('privacy.internship');

                $em->persist($feedbackEvent);
                $em->flush();

                return new Response($this->renderView('ProvipApplicationBundle:Widgets:feedback.html.twig', array('fb' => $feedbackEvent)), 200);

            }
            else
            {
                return new Response($this->renderView('ProvipApplicationBundle:Widgets:form_errors.html.twig', array('errors' => $form->getErrors())), 400);

            }
        }

        return $this->render('ProvipApplicationBundle:Internships:feedback_form.html.twig', array('form' => $form->createView()));


    }

    /**
     * @Route("/hei/feedback/{id}", options={"expose"=true})
     */
    public function addFeedbackHeiAction(ActivityUpdateEvent $activityUpdateEvent, Request $request)
    {
        $feedbackEvent = new FeedbackEvent($this->getUser());
        $form = $this->createForm(new FeedbackEventType(), $feedbackEvent);

        if ('POST' === $request->getMethod()) {

            $form->handleRequest($request);

            if ($form->isValid()) {

                $em = $this->getDoctrine()->getManager();

                $feedbackEvent->setActivityUpdateEvent($activityUpdateEvent);
                $feedbackEvent->setPrivacy('privacy.internship');

                $em->persist($feedbackEvent);
                $em->flush();

                return new Response($this->renderView('ProvipApplicationBundle:Widgets:feedback.html.twig', array('fb' => $feedbackEvent)), 200);

            }
            else
            {
                return new Response($this->renderView('ProvipApplicationBundle:Widgets:form_errors.html.twig', array('errors' => $form->getErrors())), 400);

            }
        }

        return $this->render('ProvipApplicationBundle:Internships:feedback_form.html.twig', array('form' => $form->createView()));


    }

}
