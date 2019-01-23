<?php

namespace App\Form;

use App\Entity\Annonce;
use App\Entity\Categorie;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\LocaleType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class AnnonceType extends AbstractType
{


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('libelle', TextType::class, array('label'=>'Libelle'))
                ->add('description',TextareaType::class, array('label'=>'Description'))
                ->add('photo', FileType::class, array('label'=>'photo'))
                ->add('localisation', TextType::class, array('label' => 'Localisation'))
                ->add('categorie', EntityType::class, array(
                    'label' => 'Catégorie',
                    'class'=> Categorie::class,
                    'choice_label' => 'libelle',
                ));
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Annonce::class,
        ));
    }

}
