<?php

namespace Provip\ApplicationBundle\Controller;

use Provip\EventsBundle\Entity\Picture;
use Provip\ProvipBundle\Entity\Deliverable;
use Provip\ProvipBundle\Entity\Internship;
use Provip\ProvipBundle\Entity\Opportunity;
use Provip\ProvipBundle\Form\Type\CompanyProfileType;
use Provip\ProvipBundle\Form\Type\DeliverableCompanyType;
use Provip\ProvipBundle\Form\Type\DeliverableType;
use Provip\ProvipBundle\Form\Type\OpportunityEditType;
use Provip\ProvipBundle\Form\Type\OpportunityNewType;
use Provip\UserBundle\Entity\User;
use Provip\UserBundle\Form\Type\CompanyStaffProfileType;
use Provip\UserBundle\Form\Type\NewStaffType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class OpportunityController extends Controller
{
    /**
     * @Route("/company/opportunities", options={"expose"=true})
     */
    public function indexAction(Request $request)
    {

        $opportunities = $this->getUser()->getCompany()->getOpportunities();

        $opportunity = new Opportunity($this->getUser()->getCompany());
        $form = $this->createForm(new OpportunityNewType($this->getUser()->getCompany()), $opportunity);

        if ('POST' === $request->getMethod()) {

            $form->handleRequest($request);


            if ($form->isValid()) {


                $em = $this->getDoctrine()->getManager();
                $em->persist($opportunity);
                $em->flush();

                return new Response($this->renderView('ProvipApplicationBundle:Widgets:opportunity_row.html.twig', array('opportunity' => $opportunity, 'status' => 'new')), 201);

            }
            else
            {
                return new Response($this->renderView('ProvipApplicationBundle:Widgets:form_errors.html.twig', array('errors' => $form->getErrors())), 400);

            }
        }

        return $this->render('ProvipApplicationBundle:Company:opportunities.html.twig', array('opportunities' => $opportunities, 'form' => $form->createView()));
    }

    /**
     * @Route("/company/opportunities/{slug}", options={"expose"=true})
     */
    public function detailAction(Opportunity $opportunity, Request $request)
    {

        $deliverable = new Deliverable();

        if(!$opportunity->getCompany() == $this->getUser()->getCompany())
        {
            return new Response('Not an owner of this opportunity',403);
        }

        $form = $this->createForm(new OpportunityEditType($this->getUser()->getCompany()), $opportunity);
        $form2 = $this->createForm(new DeliverableCompanyType(), $deliverable);

        if ('POST' === $request->getMethod()) {

            if($request->request->has('provip_provipbundle_opportunityedittype'))

            {
                $form->handleRequest($request);

                if ($form->isValid()) {

                    $opportunity->setComplete(true);
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($opportunity);
                    $em->flush();

                    return new Response($opportunity->getSlug(), 201);

                }
                else
                {
                    return new Response($this->renderView('ProvipApplicationBundle:Widgets:form_errors.html.twig', array('errors' => $form->getErrors())), 400);

                }
            }

            if($request->request->has('provip_provipbundle_deliverabletype'))
            {

                $em = $this->getDoctrine()->getManager();

                $form2->handleRequest($request);

                if ($form2->isValid()) {

                    $deliverable->setOpportunity($opportunity);

                    foreach($deliverable->getTasks() as $task)
                    {
                        $task->setDeliverable($deliverable);
                        $em->persist($task);
                    }


                    $em->persist($deliverable);
                    $em->flush();

                    return new Response($this->renderView('ProvipApplicationBundle:Widgets:deliverable.html.twig', array('goal' => $deliverable, 'status' => 'new')), 201);


                }
                else
                {
                    return new Response($this->renderView('ProvipApplicationBundle:Widgets:form_errors.html.twig', array('errors' => $form2->getErrors())), 400);

                }
            }

        }

        return $this->render('ProvipApplicationBundle:Company:opportunity_detail.html.twig', array('opportunity' => $opportunity, 'form' => $form->createView(), 'form2' => $form2->createView()));

    }

    /**
     * @Route("/company/opportunities/{slug}/goals/{deliverable_id}", options={"expose"=true})
     * @ParamConverter("deliverable", class="ProvipProvipBundle:Deliverable", options={"id" = "deliverable_id"})
     */
    public function editGoalAction(Opportunity $opportunity, Deliverable $deliverable, Request $request)
    {

        if(!$opportunity->getCompany() == $this->getUser()->getCompany())
        {
            return new Response('Not an owner of this opportunity',403);
        }

        return $this->render('ProvipApplicationBundle:Widgets:deliverable_edit.html.twig', array('deliverable' => $deliverable));

    }

    /**
     * @Route("/company/opportunities/{slug}/goals/{deliverable_id}/delete", options={"expose"=true})
     * @ParamConverter("deliverable", class="ProvipProvipBundle:Deliverable", options={"id" = "deliverable_id"})
     */
    public function deleteGoalAction(Opportunity $opportunity, Deliverable $deliverable, Request $request)
    {

        if(!$opportunity->getCompany() == $this->getUser()->getCompany())
        {
            return new Response('Not an owner of this opportunity',403);
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($deliverable);
        $em->flush();

        return new Response("Object removed from database", 204);
    }

    /**
     * @Route("/company/opportunities/{slug}/toggle", options={"expose"=true})
     */
    public function toggleAction(Opportunity $opportunity)
    {

        if(!$opportunity->getCompany() == $this->getUser()->getCompany())
        {
            return new Response('Not an owner of this opportunity',403);
        }

        if($opportunity->getPublished())
        {
            $state = 'complete';
            $opportunity->setPublished(false);
        }
        else
        {
            $state = 'published';
            $opportunity->setPublished(true);
        }


        $em = $this->getDoctrine()->getManager();
        $em->persist($opportunity);
        $em->flush();

        return new Response($state, 200);
    }




    /**
     * @Route("/company/opportunities/delete/{slug}")
     */
    public function deleteAction(Opportunity $opportunity)
    {
        if(!$opportunity->getCompany() == $this->getUser()->getCompany())
        {
            return new Response('Not an owner of this opportunity',403);
        }



        $em = $this->getDoctrine()->getManager();

        foreach($opportunity->getApplications() as $app) {
            foreach($app->getInternship() as $internship) {

                if($internship instanceof Internship) {

                    $internship->setDocuments(null);
                    $em->persist($internship);
                }


            }
        }

        $em->flush();

        $em->remove($opportunity);
        $em->flush();


        $this->get('session')->getFlashBag()->add('success', 'This opportunity has been deleted.');
        return $this->redirect($this->generateUrl('provip_application_opportunity_index'));
    }


}
