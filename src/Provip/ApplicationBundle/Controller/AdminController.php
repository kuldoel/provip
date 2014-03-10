<?php

namespace Provip\ApplicationBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use Provip\EventsBundle\Entity\Picture;
use Provip\ProvipBundle\Entity\Activity;
use Provip\ProvipBundle\Entity\Application;
use Provip\ProvipBundle\Entity\HigherEducationalInstitution;
use Provip\ProvipBundle\Entity\Internship;
use Provip\ProvipBundle\Entity\Opportunity;
use Provip\ProvipBundle\Entity\StudyProgram;
use Provip\ProvipBundle\Entity\Task;
use Provip\ProvipBundle\Form\Type\ActivityNewType;
use Provip\ProvipBundle\Form\Type\ApplicationRejectType;
use Provip\ProvipBundle\Form\Type\ApplicationType;
use Provip\ProvipBundle\Form\Type\CompanyProfileType;
use Provip\ProvipBundle\Form\Type\HigherEducationalInstitutionType;
use Provip\UserBundle\Entity\User;
use Provip\UserBundle\Form\Type\CompanyStaffProfileType;
use Provip\UserBundle\Form\Type\NewStaffType;
use Provip\UserBundle\Form\Type\StudyProgramAdminType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\UserBundle\Mailer\MailerInterface;
use FOS\UserBundle\Util\TokenGeneratorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Provip\EventsBundle\Entity\ApplicationEvent;
use Provip\EventsBundle\Entity\Notification;
use Provip\ProvipBundle\Form\Type\StudyProgramType;

class AdminController extends Controller
{
    /**
     * @Route("/admin", options={"expose"=true})
     */
    public function indexAction(Request $request)
    {
        $repo = $this
            ->getDoctrine()
            ->getRepository('ProvipProvipBundle:StudyProgram');

        $studyProgrammes = $repo->findAll();

        return $this->render(
            'ProvipApplicationBundle:Admin:index.html.twig' ,
            array(
                'studyProgrammes' => $studyProgrammes
                )
        );
    }


    /**
     * @Route("/admin/studyprogrammes/create", options={"expose"=true})
     */
    public function createAction(Request $request)
    {
        $studyProgram = new StudyProgram();
        $form = $this->createForm(new StudyProgramType(), $studyProgram);

        if ($request->getMethod() === 'POST') {

            $form->handleRequest($request);

            if ($form->isValid()) {

                $em = $this->getDoctrine()->getManager();
                $em->persist($studyProgram);
                $em->flush();


                $userManager = $this->get('fos_user.user_manager');
                $user = $userManager->findUserByEmail($studyProgram->getAdmin()->getEmail());
                $user->setPlainPassword($user->getPassword());
                $user->setEnabled(true);
                $user->addRole('ROLE_HEI_STAFF_ADMIN');
                $user->setAdminOf($studyProgram);
                $userManager->updateUser($user);
                $studyProgram->setAdmin($user);

                $em->persist($studyProgram);
                $em->flush();




                $this->get('session')->getFlashBag()->add('success', 'Study Programme has been created.');
                return $this->redirect($this->generateUrl('provip_application_admin_index'));

            }
            else
            {
                $this->get('session')->getFlashBag()->add('danger', 'There were some issues saving this form.');
            }
        }

        return $this->render(
            'ProvipApplicationBundle:Admin:create.html.twig' ,
            array(
                'form' => $form->createView()
            )
        );
    }


    /**
     * @Route("/admin/hei/create", options={"expose"=true})
     */
    public function createHeiAction(Request $request)
    {
        $hei = new HigherEducationalInstitution();
        $form = $this->createForm(new HigherEducationalInstitutionType(), $hei);

        if ($request->getMethod() === 'POST') {

            $form->handleRequest($request);

            if ($form->isValid()) {

                $em = $this->getDoctrine()->getManager();
                $em->persist($hei);
                $em->flush();

                $this->get('session')->getFlashBag()->add('success', 'Higher Educational Instituction has been created.');
                return $this->redirect($this->generateUrl('provip_application_admin_index'));

            }
            else
            {
                $this->get('session')->getFlashBag()->add('danger', 'There were some issues saving this form.');
            }
        }

        return $this->render(
            'ProvipApplicationBundle:Admin:create_hei.html.twig' ,
            array(
                'form' => $form->createView()
            )
        );
    }


    /**
     * @Route("/admin/listofstudents", options={"expose"=true})
     */
    public function listOfStudentsAction(Request $request)
    {
        $repo = $this
            ->getDoctrine()
            ->getRepository('ProvipProvipBundle:StudyProgram');

        $studyProgrammes = $repo->findAll();

        return $this->render(
            'ProvipApplicationBundle:Admin:students.html.twig' ,
            array(
                'studyProgrammes' => $studyProgrammes
            )
        );
    }

    /**
     * @Route("/admin/listofcompanies", options={"expose"=true})
     */
    public function listOfCompaniesAction(Request $request)
    {
        $repo = $this
            ->getDoctrine()
            ->getRepository('ProvipProvipBundle:Company');


        $companies = $repo->findAll();

        return $this->render(
            'ProvipApplicationBundle:Admin:companies.html.twig' ,
            array(
                'companies' => $companies
            )
        );
    }

    /**
     * @Route("/admin/listofopportunities", options={"expose"=true})
     */
    public function listOfOpportunitiesAction(Request $request)
    {
        $repo = $this
            ->getDoctrine()
            ->getRepository('ProvipProvipBundle:Opportunity');


        $opportunities = $repo->findAll();

        return $this->render(
            'ProvipApplicationBundle:Admin:opportunities.html.twig' ,
            array(
                'opportunities' => $opportunities
            )
        );
    }


}
