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

            return new Response('', 201);
        }

        return array('form' => $form->createView());
    }

    /**
     * @Rest\View(statusCode=200)
     * @QueryParam(name="id", default="")
     */
    public function crocodocSessionAction(ParamFetcher $paramFetcher) {
    }

}
