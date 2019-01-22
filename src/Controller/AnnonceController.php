<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Entity\User;
use App\Form\AnnonceType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use Algolia\SearchBundle\IndexManagerInterface;

class AnnonceController extends AbstractController
{


    protected $indexManager;

    public function __construct(IndexManagerInterface $indexingManager)
    {
        $this->indexManager = $indexingManager;
    }


    /**
     * @Route("/annonce/{type}/{data}", name="annonce", defaults={"type"=null, "data"=null})
     */
    public function index(Request $request)
    {

        $em = $this->getDoctrine()->getManager();


        if($request->get('type') == NULL){

            $annonces = $em->getRepository(Annonce::class)->findAll();

        }elseif($request->get('type') == 'search'){

            $em = $this->getDoctrine()->getManagerForClass(Annonce::class);
            $annonces = $this->indexManager->search($request->get('data'), Annonce::class, $em);

        }elseif($request->get('type')== 'categorie'){

            $annonces = $em->getRepository(Annonce::class)->findBy(['categorie'=>$request->get('data')]);

        }


        return $this->render('annonce/index.html.twig', [
            'annonces' => $annonces,

        ]);
    }




    /**
     * @Route("/show/{id}", name="show_annonce")
     */
    public function show(Request $request)
    {
        $em = $this->getDoctrine()->getManager();


        $annonce = $em->getRepository(Annonce::class)->findOneById($request->get('id'));
        $user = $em->getRepository(User::class)->findOneById($annonce->getIdUser());


        return $this->render('annonce/show.html.twig', [
            'annonce' => $annonce,
            'user' => $user,
        ]);
    }



    /**
     * @Route("/new", name="new_annonce")
     */
    public function add(Request $request)
    {

        $user = $this->get('security.token_storage')->getToken()->getUser();

        $annonce = new Annonce();
        $form = $this->createForm(AnnonceType::class, $annonce);

        $form->add('iduser', HiddenType::class, array(
            'data' => $user->getId(),
        ));

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($annonce);
            $em->flush();

            return $this->redirect($this->generateUrl('show_annonce', array('id' => $annonce->getId())));
        }

        return $this->render('annonce/new.html.twig', [
            'form' => $form->createView(),
        ]);


    }
}
