<?php

namespace App\Controller;

use App\Entity\Categorie;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Asset\Context\RequestStackContext;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{



    /**
     * @Route("/", name="home")
     */
    public function index(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository(Categorie::class)->findAll();


        $defaultData = array('search' => '');
        $form = $this->createFormBuilder($defaultData)
            ->add('search', TextType::class, array(
                'label' => false,
                'attr' => array(
                    'placeholder' => 'Rechercher un article',
                    'class'=>'search'
                )
            ))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            return $this->redirect($this->generateUrl('annonce', array('type'=> 'search', 'data' => $data['search'])));
        }


        return $this->render('home/index.html.twig', [
            'categories'=>$categories,
            'form' => $form->createView(),
        ]);
    }
}
