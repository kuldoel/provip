<?php

namespace Provip\ApplicationBundle\Controller;

use Provip\EventsBundle\Entity\Picture;
use Provip\ProvipBundle\Form\Type\CompanyProfileType;
use Provip\UserBundle\Entity\User;
use Provip\UserBundle\Form\Type\CompanyStaffProfileType;
use Provip\UserBundle\Form\Type\NewStaffType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CompanyController extends Controller
{
    /**
     * @Route("/company")
     */
    public function dashboardAction()
    {
        return $this->render('ProvipApplicationBundle:Company:index.html.twig');
    }

   /**
    * @Route("/company/account-settings")
    */
    public function settingsAction(Request $request)
    {


        $user = $this->getUser();
        $form = $this->createForm(new CompanyStaffProfileType(), $user);

        if ($request->isMethod('POST'))
        {
            $form->handleRequest($request);

            if($form->isValid())
            {

                $em = $this->getDoctrine()->getManager();

                $user->setProfileComplete(true);

                $em->persist($user);
                $em->flush();

                $this->get('session')->getFlashBag()->add('success', 'Your changes were succesfully saved!');
                return $this->redirect($this->generateUrl('provip_application_company_settings'));

            }

        }


        return $this->render('ProvipApplicationBundle:Company:settings.html.twig', array('form' => $form->createView()));
    }

    /**
     * @Route("/company/company-settings")
     */
    public function infoAction(Request $request)
    {

        $company = $this->getUser()->getCompany();
        $form = $this->createForm(new CompanyProfileType(), $company);

        if ($request->isMethod('POST'))
        {
            $form->handleRequest($request);

            if($form->isValid())
            {

                $em = $this->getDoctrine()->getManager();

                $company->setProfileComplete(true);

                $em->persist($company);
                $em->flush();

                $this->get('session')->getFlashBag()->add('success', 'Your changes were succesfully saved!');
                return $this->redirect($this->generateUrl('provip_application_company_companyinfo'));

            }

        }


        return $this->render('ProvipApplicationBundle:Company:company_settings.html.twig', array('company' => $company, 'form' => $form->createView()));
    }

    /**
     * @Route("/company/account-settings/delete-picture")
     */
    public function deletePictureAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $user = $this->getUser();
        $picture = $user->getPicture();

        if($picture instanceof Picture)

        {
            $user->setPicture(NULL);

            $em->persist($user);
            $em->flush();
        }

        $this->get('session')->getFlashBag()->add('success', 'Your profile picture was succesfully deleted.');
        return $this->redirect($this->generateUrl('provip_application_company_settings'));

    }

    /**
     * @Route("/company/staff")
     */
    public function staffAction(Request $request)
    {
        $staff = $this->getUser()->getCompany()->getStaff();

        $user = new User();
        $form = $this->createForm(new NewStaffType(), $user);

        return $this->render('ProvipApplicationBundle:Company:company_staff.html.twig', array('form' => $form->createView(), 'staff' => $staff));

    }
}
