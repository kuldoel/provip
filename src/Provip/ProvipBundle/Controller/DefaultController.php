<?php

namespace Provip\ProvipBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/student")
     */
    public function indexAction()
    {
        return $this->render('ProvipProvipBundle:Default:index.html.twig');
    }
}
