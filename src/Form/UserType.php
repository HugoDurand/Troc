<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class, array('label' => 'FirstName', 'attr'=>array('placeholder' => 'FirstName', 'class' => 'input')))
            ->add('lastname', TextType::class, array('label' => 'LastName', 'attr'=>array('placeholder' => 'LastName', 'class' => 'input')))
            ->add('username', TextType::class, array('label' => 'Username', 'attr'=>array('placeholder' => 'Username', 'class' => 'input')))
            ->add('email', EmailType::class, array('label' => 'Email', 'attr'=>array('placeholder' => 'Email', 'class' => 'input')))
            ->add('phone', TextType::class, array('label' => 'Phone', 'attr'=>array('placeholder' => 'Phone', 'class' => 'input')))
            ->add('password', RepeatedType::class, array(
                'label'=> 'Password',
                'type' => PasswordType::class,
                'attr' => array('placeholder' => 'Password'),
                'first_options'  => array('label' => 'Password'),
                'second_options' => array('label' => 'Repeat Password'),
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => User::class,
        ));
    }
}