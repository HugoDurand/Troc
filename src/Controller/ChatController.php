<?php

namespace App\Controller;

use App\Entity\Message;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ChatController extends AbstractController
{
    /**
     * @Route("/chat/{id_receiver}/{id_annonce}", name="chat")
     */
    public function index(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)->findOneById($request->get('id_receiver'));
        $messages = $em->getRepository(Message::class)->findBy(['receiver'=> $request->get('id_receiver'),'annonce_id' => $request->get('id_annonce')], ['date' =>'asc']);


        return $this->render('chat/index.html.twig', [
            'user' => $user,
            'messages' => $messages
        ]);
    }
}
