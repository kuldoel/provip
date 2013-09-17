<?php


namespace Provip\EventsBundle\Controller;

use Provip\EventsBundle\Entity\ActivityUpdateEvent;
use Provip\EventsBundle\Entity\BroadcastCompany;
use Provip\EventsBundle\Entity\BroadcastHei;
use Provip\EventsBundle\Entity\FeedbackEvent;
use Provip\EventsBundle\Entity\Notification;
use Provip\EventsBundle\Form\BroadcastCompanyType;
use Provip\EventsBundle\Form\BroadcastHeiType;
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

                    $now = new \DateTime('now');

                    if($activity->getState() == 'Completed' && $now->getTimestamp() > $activity->getDeadline()->getTimestamp() ) {
                        $activity->setComments('Completed past deadline on ' . $now->format('d-m-Y'));
                    }

                    $em->persist($activity);

                }

                $activityUpdateEvent->setAuthor($this->getUser());

                $em->persist($activityUpdateEvent);



                $recipients = $activityUpdateEvent->getRecipients();

                foreach($recipients as $r) {
                    $notification = new Notification($r, $activityUpdateEvent, 'No Action');
                    $em->persist($notification);
                }

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
     * @Route("/company/status/new", options={"expose"=true})
     */
    public function newCompanyStatusAction(Request $request)
    {
        $broadcastCompany = new BroadcastCompany($this->getUser(), '', '', 'privacy.company.only');

        $form = $this->createForm(new BroadcastCompanyType(), $broadcastCompany);

        if ('POST' === $request->getMethod()) {

            $form->handleRequest($request);

            if ($form->isValid()) {

                $em = $this->getDoctrine()->getManager();
                $recipients = $broadcastCompany->getRecipients();

                foreach($recipients as $r) {
                    $notification = new Notification($r, $broadcastCompany, 'No Action');
                    $em->persist($notification);
                }

                $em->flush();

                return new Response($this->renderView('ProvipApplicationBundle:Widgets:companyupdateevent_new.html.twig', array('e' => $broadcastCompany)), 200);

            }
            else
            {
                return new Response($this->renderView('ProvipApplicationBundle:Widgets:form_errors.html.twig', array('errors' => $form->getErrors())), 400);

            }
        }

        return new Response($this->renderView('ProvipApplicationBundle:Widgets:companyupdateevent.html.twig', array('form' => $form->createView())), 200);

    }

    /**
     * @Route("/hei/status/new", options={"expose"=true})
     */
    public function newHeiStatusAction(Request $request)
    {
        $broadcastHei = new BroadcastHei($this->getUser(), '', '', 'privacy.company.only');

        $form = $this->createForm(new BroadcastHeiType(), $broadcastHei);

        if ('POST' === $request->getMethod()) {

            $form->handleRequest($request);

            if ($form->isValid()) {

                $em = $this->getDoctrine()->getManager();
                $recipients = $broadcastHei->getRecipients();

                foreach($recipients as $r) {
                    $notification = new Notification($r, $broadcastHei, 'No Action');
                    $em->persist($notification);
                }

                $em->flush();

                return new Response($this->renderView('ProvipApplicationBundle:Widgets:companyupdateevent_new.html.twig', array('e' => $broadcastHei)), 200);

            }
            else
            {
                return new Response($this->renderView('ProvipApplicationBundle:Widgets:form_errors.html.twig', array('errors' => $form->getErrors())), 400);

            }
        }

        return new Response($this->renderView('ProvipApplicationBundle:Widgets:companyupdateevent.html.twig', array('form' => $form->createView())), 200);

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

                $recipients = $feedbackEvent->getRecipients();

                foreach($recipients as $r) {
                    $notification = new Notification($r, $feedbackEvent, 'No Action');
                    $em->persist($notification);
                }



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

                $recipients = $feedbackEvent->getRecipients();

                foreach($recipients as $r) {
                    $notification = new Notification($r, $feedbackEvent, 'No Action');
                    $em->persist($notification);
                }

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
