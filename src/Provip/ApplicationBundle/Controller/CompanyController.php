<?php

namespace Provip\ApplicationBundle\Controller;

use Provip\EventsBundle\Entity\Picture;
use Provip\ProvipBundle\Form\Type\CompanyProfileType;
use Provip\UserBundle\Entity\User;
use Provip\UserBundle\Form\Type\CompanyStaffProfileType;
use Provip\UserBundle\Form\Type\NewStaffType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
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
                return $this->redirect($this->generateUrl('provip_application_company_info'));

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
     * @Route("/company/staff", options={"expose"=true})
     */
    public function staffAction(Request $request)
    {
        $staff = $this->getUser()->getCompany()->getStaff();

        $user = new User();
        $form = $this->createForm(new NewStaffType(), $user);

        if ('POST' === $request->getMethod()) {

            $form->handleRequest($request);

            $user->setPlainPassword(md5(crypt(rand(0, 50000).time())));

            if ($form->isValid()) {

                $userManager = $this->get('fos_user.user_manager');

                $user->addRole('ROLE_COMPANY_STAFF');
                $user->setCompany($this->getUser()->getCompany());

                $userManager->updateUser($user);

                // @TODO
                // Send email to new staff member to reset password

                return new Response($this->renderView('ProvipApplicationBundle:Widgets:staff_member.html.twig', array('user' => $user, 'status' => 'new')), 201);

            }
            else
            {
                return new Response($this->renderView('ProvipApplicationBundle:Widgets:form_errors.html.twig', array('errors' => $form->getErrors())), 400);

            }
        }

        return $this->render('ProvipApplicationBundle:Company:company_staff.html.twig', array('form' => $form->createView(), 'staff' => $staff));

    }


    /**
     * @Route("/company/staff/search/{q}", defaults={"q" = ""}, options={"expose"=true})
     */
    public function searchAction($q)
    {
        $company = $this->getUser()->getCompany();

        $staff = $this->getDoctrine()->getRepository('ProvipUserBundle:User')->getStaffByPartial($q, $company);

        return $this->render('ProvipApplicationBundle:Widgets:company_staff_search.html.twig',array('staff' => $staff, 'status' => ''));

    }
}
