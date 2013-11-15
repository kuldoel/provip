<?php

namespace Provip\ApplicationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Provip\ProvipBundle\Entity\Document;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DocumentController extends Controller
{
    /**
     * @Route("/document/{id}/crocodoc_session", options={"expose"=true})
     */
    public function getCrocodocSessionAction($id, Request $request)
    {
        $document = $this->getDoctrine()->getRepository('ProvipProvipBundle:Document')->findOneById($id);

        if(! $document){
            return new Response('Document not found', 404);
        }

        try{
            return new Response($this->get('provip_crocodoc_service')->createSession($this->getUser(), $document), 200);
        }
        catch(\LogicException $e){
            return new Response('Unauthorized access', 401);
        }
    }

    /**
     * @Route("/document/{id}/view", options={"expose"=true})
     */
    public function getDocumentViewAction($id, Request $request)
    {
        $document = $this->getDoctrine()->getRepository('ProvipProvipBundle:Document')->findOneById($id);

        if(! $document){
            return new Response('Document not found', 404);
        }

        try{
            return new RedirectResponse('https://crocodoc.com/view/' . $this->get('provip_crocodoc_service')->createSession($this->getUser(), $document));
        }
        catch(\LogicException $e){
            return new Response('Unauthorized access', 401);
        }
    }

}
