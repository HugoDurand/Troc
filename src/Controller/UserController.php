<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Entity\User;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    /**
     * @Route("/account", name="account")
     */
    public function index(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {

        $form = $this->createForm(UserType::class, $this->getUser());

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $password = $passwordEncoder->encodePassword($this->getUser(), $this->getUser()->getPassword());
            $this->getUser()->setPassword($password);

            $this->getUser()->setRoles(['ROLE_USER']);

            $em = $this->getDoctrine()->getManager();
            $em->persist($this->getUser());
            $em->flush();

        }

        return $this->render('user/index.html.twig', [
            'users' => $this->getUser(),
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/account/annonces", name="account_annonces")
     */
    public function annonces()
    {

        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $annonces = $em->getRepository(Annonce::class)->findBy(['id_user' => $user->getId()]);

        return $this->render('user/annonce.html.twig', [
            'annonces'=> $annonces,
        ]);
    }
}
