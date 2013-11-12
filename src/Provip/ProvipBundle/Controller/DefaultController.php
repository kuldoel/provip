<?php

namespace Provip\ProvipBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Provip\ProvipBundle\Entity\Document;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/upload", options={"expose"=true})
     * @Template()
     */
    public function uploadAction(Request $request)
    {
        $document = new Document();

        $form = $this->createFormBuilder($document)
            ->add('name')
            ->add('file')
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($document);
            $em->flush();

            // TODO: upload to Crocodoc
            $this->get('provip_crocodoc_service')->uploadDocument($document);

            return new Response('', 201);
        }

        return array('form' => $form->createView());
    }

    /**
     * @Route("/document/{id}/crocodoc_session", options={"expose"=true})
     * TODO: restrict access to ROLE_USER
     */
    public function getCrocodocSessionAction($id, Request $request)
    {
        $document = $this->getDoctrine()->getRepository('ProvipProvipBundle:Document')->findOneById($id);

        if(! $document){
            return new Response('Document not found', 404);
        }

        return $this->get('provip_crocodoc_service')->createSession($this->getUser(), $document);
    }

}
