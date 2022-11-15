<?php

namespace App\Form;


use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', TextType::class, ['label' => "Nom d'utilisateur"])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Les deux mots de passe doivent correspondre.',
                'required' => true,
                'first_options'  => ['label' => 'Mot de passe'],
                'second_options' => ['label' => 'Tapez le mot de passe à nouveau'],
            ])
            ->add('email', EmailType::class, ['label' => 'Adresse email'])
            ->add('roles', ChoiceType::class,
                [
                    'choices' => [
                    'user' => 'ROLE_USER',
                    'admin' => 'ROLE_ADMIN',
                    ],
                    'multiple' => true,
                    'expanded' => true,
                ]
            )
        ;
        
    }
    // public function buildForm(FormBuilderInterface $builder, array $options): void
    // {
    //     $builder
    //         ->add('email', EmailType::class, [
    //             'attr' => [
    //                 'class' => 'form-control'
    //             ],
    //            'label' =>  'E-mail'
    //         ])
    //         ->add('username', TextType::class, [
    //             'attr' => [
    //                 'class' => 'form-control'
    //                 ],
    //              'label' => 'Nom'
    //         ])
    //         ->add('password', PasswordType::class, [
    //             'attr' => [
    //                 'class' => 'form-control'
    //                 ],
    //               'label' =>  'Mot de passe'
    //         ])
    //         // ->add('confirm_password', PasswordType::class, [
    //         //     'attr' => [
    //         //         'class' => 'form-control'
    //         //         ],
    //         //        'label' =>  'Mot de passe'
    //         // ])
    //     ;
    // }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
