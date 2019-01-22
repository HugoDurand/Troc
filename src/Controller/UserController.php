<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/account", name="account")
     */
    public function index()
    {

        $em = $this->getDoctrine()->getManager();
        $id_user = 4;
        $users = $em->getRepository(User::class)->findOneBy(['id' => $id_user]);
        $annonces = $em->getRepository(User::class)->findOneBy(['id' => $id_user]);

        return $this->render('user/index.html.twig', [
            'users' => $users,
            'annonces'=> $annonces,
        ]);
    }
}
