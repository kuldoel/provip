<?php

namespace Provip\UserBundle\Controller;
use FOS\UserBundle\Controller\RegistrationController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ProVipRegistrationController extends RegistrationController
{
    /**
     * @Route("/student/register")
     */
    public function registerAsStudentAction()
    {
        return $this->render('ProvipUserBundle:Registration:student.html.twig');
    }

    /**
     * @Route("/company/register")
     */
    public function registerAsCompanyAction()
    {
        return $this->render('ProvipUserBundle:Registration:company.html.twig');
    }
}
