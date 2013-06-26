<?php

namespace Provip\ApplicationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        return $this->render('ProvipApplicationBundle:Default:index.html.twig');
    }

    /**
     * @Route("/student")
     */
    public function studentDashboardAction()
    {
        return $this->render('ProvipApplicationBundle:Student:index.html.twig');
    }

    /**
     * @Route("/company")
     */
    public function companyDashboardAction()
    {
        return $this->render('ProvipApplicationBundle:Company:index.html.twig');
    }
}
