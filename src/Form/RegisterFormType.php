<?php

namespace App\Form;
use App\Entity\User;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class RegisterFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder 
        ->add('email',EmailType::class,[
            'label'=>'votre adresse mail',
            'attr'=>[
                'placeholder'=>'Merci de renseigner votre e-mail'
            ]
        ])
        ->add('password', RepeatedType::class,[
            'type'=>PasswordType::class,
            'invalid_message'=>'Le mot de passe et la confirmation doivent etre identiques',
            'required'=>true,
            'first_options'=>['label'=>'Votre mot de passe'],
            'second_options'=>['label'=>'Confirmez votre mot de passe']
        ])
        ->add('lastname',TextType::class,[
            'label'=>'Votre nom',
            'attr'=>[
                'placeholder'=>'Merci de saisir votre nom'
            ]
        ])
        ->add('firstname', TextType::class,[
            'label'=>'Votre prénom',
            'attr'=>[
                'placeholder'=>'Merci de saisir votre prénom'
            ]
        ])
        ->add('submit', SubmitType::class,[
            'label'=>'Envoyer',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
