<?php

namespace Provip\ApplicationBundle\Controller;

use Provip\ProvipBundle\Entity\DocumentState;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Provip\ProvipBundle\Entity\Document;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class DocumentController extends Controller
{
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
            return new Response($e->getMessage(), 401);
        }
        catch(\CrocodocException $e){
            return new Response('Something went wrong', 500);
        }
    }

    /**
     * @Route("/document/crocodoc_notification", options={"expose"=true})
     * @Method({"POST"})
     */
    public function crocodocNotificationAction(Request $request)
    {
        $requestData = $request->request->all();
        $events = json_decode($requestData['payload'], true);

        if(! $events){
            // wrong API format
            return new Response('Invalid formatting', 400);
        }

        $em = $this->getDoctrine()->getManager();

        // find the latest document status event
        foreach ($events as $event) {
            if($event['event'] == 'document.status'){

                // find document
                $document = $this->getDoctrine()->getRepository('ProvipProvipBundle:Document')->findOneByCrocodocId($event['uuid']);

                if($document){
                    $document->setState(strtolower($event['status']));
                    $document->setViewable($event['viewable']);
                    $em->persist($document);
                }
            }
        }

        $em->flush();

        // find next to upload using FIFO strategy
        $unprocessedDocuments = $this->getDoctrine()->getRepository('ProvipProvipBundle:Document')->findBy(array('state' => DocumentState::STATE_AWAITING_CROCODOC_UPLOAD), array('id' => 'ASC'));

        if(sizeof($unprocessedDocuments)){
            $this->get('provip_crocodoc_service')->uploadDocument($unprocessedDocuments[0]);
        }

        return new Response('', 200);
    }

}
