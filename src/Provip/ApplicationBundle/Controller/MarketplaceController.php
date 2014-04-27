<?php

namespace Provip\ApplicationBundle\Controller;

use Provip\EventsBundle\Entity\Picture;
use Provip\ProvipBundle\Entity\Application;
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
     * @Route("/company/marketplace/detail/{slug}")
     */
    public function companyMarketplaceDetailAction(User $student)
    {
        return $this->render('ProvipApplicationBundle:Marketplace:student_full_details.html.twig',array('student' => $student));
    }

    /**
     * @Route("/student/marketplace")
     */
    public function studentMarketplaceAction()
    {
        if($this->getUser()->getEnrollment()->getApproved() == false)
        {
            $this->get('session')->getFlashBag()->add('danger', 'Your enrollment is not yet approved');
            return $this->redirect($this->generateUrl('provip_application_student_settings'));
        }

        $opportunities = $this->getDoctrine()->getRepository('ProvipProvipBundle:Opportunity')->findBy(array('published' => 1));

        return $this->render('ProvipApplicationBundle:Marketplace:student.html.twig', array('opportunities' => $opportunities));
    }


    /**
     * @Route("/student/marketplace/internship/{slug}", options={"expose"=true})
     */
    public function detailAction(Opportunity $opportunity)
    {

        $application = $this->getUser()->getApplicationForOpportunity($opportunity);


        if($opportunity->getPublished())
        {
            return $this->render('ProvipApplicationBundle:Marketplace:opportunity_detail.html.twig', array('opportunity' => $opportunity, 'application' => $application));
        }
        else
        {
            return new Response("",404);
        }


    }


    /**
     * @Route("/hei/marketplace/internship/{slug}", options={"expose"=true})
     */
    public function detailHeiAction(Opportunity $opportunity)
    {


        if($opportunity->getPublished())
        {
            return $this->render('ProvipApplicationBundle:Marketplace:opportunity_hei_detail.html.twig', array('opportunity' => $opportunity));
        }
        else
        {
            return new Response("",404);
        }


    }

}
