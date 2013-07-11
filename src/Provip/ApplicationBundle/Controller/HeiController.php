<?php

namespace Provip\ApplicationBundle\Controller;

use Provip\EventsBundle\Entity\Picture;
use Provip\ProvipBundle\Entity\Deliverable;
use Provip\ProvipBundle\Entity\Enrollment;
use Provip\ProvipBundle\Entity\Skill;
use Provip\ProvipBundle\Form\Type\CompanyProfileType;
use Provip\ProvipBundle\Form\Type\DeliverableType;
use Provip\ProvipBundle\Form\Type\HeiProfileType;
use Provip\ProvipBundle\Form\Type\SkillType;
use Provip\ProvipBundle\Form\Type\StudyProgramProfileType;
use Provip\ProvipBundle\Form\Type\StudyProgramType;
use Provip\UserBundle\Entity\User;
use Provip\UserBundle\Form\Type\HeiStaffProfileType;
use Provip\UserBundle\Form\Type\NewStaffType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\UserBundle\Mailer\MailerInterface;
use FOS\UserBundle\Util\TokenGeneratorInterface;

class HeiController extends Controller
{

    protected $mailer;
    protected $tokenGenerator;


    /**
     * @Route("/hei")
     */
    public function dashboardAction()
    {
        return $this->render('ProvipApplicationBundle:Hei:index.html.twig');
    }

   /**
    * @Route("/hei/account-settings")
    */
    public function settingsAction(Request $request)
    {

        $user = $this->getUser();
        $form = $this->createForm(new HeiStaffProfileType(), $user);

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
                return $this->redirect($this->generateUrl('provip_application_hei_settings'));

            }

        }


        return $this->render('ProvipApplicationBundle:Hei:settings.html.twig', array(
            'form' => $form->createView()));
    }

    /**
     * @Route("/hei/hei-settings", options={"expose"=true})
     */
    public function infoAction(Request $request)
    {

        $studyProgram = $this->getUser()->getAdminOf();

        $learningGoal = new Deliverable();
        $skill        = new Skill();

        $formGoal           = $this->createForm(new DeliverableType(), $learningGoal);
        $formSkill          = $this->createForm(new SkillType(), $skill);
        $formStudyProgram   = $this->createForm(new StudyProgramProfileType(), $studyProgram);


        if ($request->isMethod('POST'))
        {
            $em = $this->getDoctrine()->getManager();

            if($request->request->has('provip_provipbundle_studyprogramprofiletype'))
            {
                $formStudyProgram->handleRequest($request);

                if ($formStudyProgram->isValid()) {

                    $em->persist($studyProgram);

                    $em->flush();

                    return new Response("SAVED", 200);

                }
                else
                {
                    return new Response($this->renderView('ProvipApplicationBundle:Widgets:form_errors.html.twig', array(
                            'errors' => $formSkill->getErrors())
                    ), 400);

                }
            }

            if($request->request->has('provip_provipbundle_skilltype'))
            {
                $formSkill->handleRequest($request);

                if ($formSkill->isValid()) {

                    $studyProgram->addSkill($skill);
                    $skill->addStudyProgram($studyProgram);

                    $em->persist($studyProgram);
                    $em->persist($skill);

                    $em->flush();

                    return new Response($this->renderView('ProvipApplicationBundle:Widgets:skill.html.twig', array('skill' => $skill, 'status' => 'new')), 201);

                }
                else
                {
                    return new Response($this->renderView('ProvipApplicationBundle:Widgets:form_errors.html.twig', array(
                        'errors' => $formSkill->getErrors())
                    ), 400);

                }
            }

            if($request->request->has('provip_provipbundle_deliverabletype'))
            {
                $formGoal->handleRequest($request);

                if ($formGoal->isValid()) {

                    $learningGoal->setStudyProgram($studyProgram);

                    foreach($learningGoal->getTasks() as $task)
                    {
                        $task->setDeliverable($learningGoal);
                        $em->persist($task);
                    }


                    $em->persist($learningGoal);
                    $em->flush();

                    return new Response($this->renderView('ProvipApplicationBundle:Widgets:learningGoal.html.twig', array('learninggoal' => $learningGoal, 'status' => 'new')), 201);

                }
                else
                {
                    return new Response($this->renderView('ProvipApplicationBundle:Widgets:form_errors.html.twig', array(
                            'errors' => $formSkill->getErrors())
                    ), 400);

                }
            }

        }


        return $this->render('ProvipApplicationBundle:Hei:hei_settings.html.twig', array(
            'studyProgram' => $studyProgram,
            'formSkill' => $formSkill->createView(),
            'formStudyProgram' => $formStudyProgram->createView(),
            'formGoal' => $formGoal->createView()));
    }

    /**
     * @Route("/hei/account-settings/delete-picture")
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
        return $this->redirect($this->generateUrl('provip_application_hei_settings'));

    }


    /**
     * @Route("/hei/staff", options={"expose"=true})
     */
    public function staffAction(Request $request)
    {
        $staff = $this->getUser()->getAdminOf()->getStaff();

        $user = new User();
        $form = $this->createForm(new NewStaffType(), $user);

        if ('POST' === $request->getMethod()) {

            $form->handleRequest($request);

            $user->setPlainPassword(md5(crypt(rand(0, 50000).time())));

            if ($form->isValid()) {

                $this->mailer = $this->get('fos_user.mailer');
                $this->tokenGenerator = $this->get('fos_user.util.token_generator');

                $userManager = $this->get('fos_user.user_manager');

                $user->addRole('ROLE_HEI_STAFF');
                $user->setTeachesAt($this->getUser()->getAdminOf());

                $userManager->updateUser($user);

                if (null === $user->getConfirmationToken()) {
                    /** @var $tokenGenerator \FOS\UserBundle\Util\TokenGeneratorInterface */
                    $user->setConfirmationToken($this->tokenGenerator->generateToken());
                }

                $this->mailer->sendResettingEmailMessage($user);
                $user->setPasswordRequestedAt(new \DateTime());
                $userManager->updateUser($user);

                return new Response($this->renderView('ProvipApplicationBundle:Widgets:staff_member.html.twig', array(
                    'user' => $user, 'status' => 'new')
                ), 201);

            }
            else
            {
                return new Response($this->renderView('ProvipApplicationBundle:Widgets:form_errors.html.twig', array(
                    'errors' => $form->getErrors())
                ), 400);

            }
        }

        return $this->render('ProvipApplicationBundle:Hei:hei_staff.html.twig', array(
            'form' => $form->createView(),
            'staff' => $staff)
        );

    }


    /**
     * @Route("/hei/staff/search/{q}", defaults={"q" = ""}, options={"expose"=true})
     */
    public function searchAction($q)
    {

        $studyProgram = $this->getUser()->getAdminOf();

        $staff = $this->getDoctrine()->getRepository('ProvipUserBundle:User')->getHeiStaffByPartial($q, $studyProgram);

        return $this->render('ProvipApplicationBundle:Widgets:company_staff_search.html.twig',array('staff' => $staff, 'status' => ''));


    }

    /**
     * @Route("/hei/students")
     */
    public function studentsAction(Request $request)
    {
        $enrollments = $this->getUser()->getAdminOf()->getEnrollments();

        return $this->render('ProvipApplicationBundle:Hei:hei_students.html.twig', array(
                'enrollments' => $enrollments)
        );

    }

    /**
     * @Route("/hei/enrollments/{id}/toggle", options={"expose"=true})
     */
    public function approveAction(Enrollment $enrollment)
    {

        $enrollment->setApproved(true);

        $em = $this->getDoctrine()->getManager();
        $em->persist($enrollment);
        $em->flush();

        return new Response("complete", 200);
    }
}
