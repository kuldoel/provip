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
        $securityContext = $this->container->get('security.context');

        if($securityContext->isGranted('ROLE_STUDENT'))
        {
            return $this->redirect($this->generateUrl('provip_application_student_dashboard'));
        }
        elseif($securityContext->isGranted('ROLE_COMPANY_STAFF'))
        {
            return $this->redirect($this->generateUrl('provip_application_company_dashboard'));
        }
        elseif($securityContext->isGranted('ROLE_HEI_STAFF'))
        {
            return $this->redirect($this->generateUrl('provip_application_hei_dashboard'));
        }
        else
        {
            return $this->render('ProvipApplicationBundle:Default:main.html.twig');
        }

    }

    /**
     * @Route("/profile", name="fos_user_profile_show")
     */
    public function profileRouting()
    {
        $securityContext = $this->container->get('security.context');

        if($securityContext->isGranted('ROLE_STUDENT'))
        {
            return $this->redirect($this->generateUrl('provip_application_student_settings'));
        }
        elseif($securityContext->isGranted('ROLE_COMPANY_STAFF'))
        {
            return $this->redirect($this->generateUrl('provip_application_company_settings'));
        }
        else
        {
            return $this->redirect($this->generateUrl('provip_application_hei_settings'));
        }
    }

}
