<?php

namespace Provip\ApplicationBundle\Controller;

use Provip\EventsBundle\Entity\Picture;
use Provip\ProvipBundle\Entity\Opportunity;
use Provip\ProvipBundle\Form\Type\CompanyProfileType;
use Provip\ProvipBundle\Form\Type\OpportunityEditType;
use Provip\ProvipBundle\Form\Type\OpportunityNewType;
use Provip\UserBundle\Entity\User;
use Provip\UserBundle\Form\Type\CompanyStaffProfileType;
use Provip\UserBundle\Form\Type\NewStaffType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
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
        if(!$opportunity->getCompany() == $this->getUser()->getCompany())
        {
            return new Response('Not owner of this opportunity',403);
        }

        $form = $this->createForm(new OpportunityEditType($this->getUser()->getCompany()), $opportunity);

        return $this->render('ProvipApplicationBundle:Company:opportunity_detail.html.twig', array('opportunity' => $opportunity, 'form' => $form->createView()));

    }


}
