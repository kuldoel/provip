<?php

namespace Provip\ApplicationBundle\Controller;

use Provip\EventsBundle\Entity\Picture;
use Provip\ProvipBundle\Entity\Opportunity;
use Provip\ProvipBundle\Form\Type\CompanyProfileType;
use Provip\UserBundle\Entity\User;
use Provip\UserBundle\Form\Type\CompanyStaffProfileType;
use Provip\UserBundle\Form\Type\NewStaffType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\UserBundle\Mailer\MailerInterface;
use FOS\UserBundle\Util\TokenGeneratorInterface;

class MarketplaceController extends Controller
{
    /**
     * @Route("/company/marketplace")
     */
    public function companyMarketplaceAction()
    {
        $students = $this->getDoctrine()->getRepository('ProvipUserBundle:User')->findByRole('ROLE_STUDENT');


        return $this->render('ProvipApplicationBundle:Marketplace:company.html.twig',array('students' => $students));
    }

    /**
     * @Route("/student/marketplace")
     */
    public function studentMarketplaceAction()
    {
        $opportunities = $this->getDoctrine()->getRepository('ProvipProvipBundle:Opportunity')->findBy(array('published' => 1));

        return $this->render('ProvipApplicationBundle:Marketplace:student.html.twig', array('opportunities' => $opportunities));
    }


    /**
     * @Route("/student/marketplace/internship/{slug}", options={"expose"=true})
     */
    public function detailAction(Opportunity $opportunity)
    {
        if($opportunity->getPublished())
        {
            return $this->render('ProvipApplicationBundle:Marketplace:opportunity_detail.html.twig', array('opportunity' => $opportunity));
        }
        else
        {
            return new Response("",404);
        }


    }

}
