<?php

namespace App\Form\Admin;

use App\Entity\Admin\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName')
            ->add('lastName')
            ->add('username')
            ->add('email')
            ->add('roles', ChoiceType::class, [
                'choices'       =>  User::ROLES,
                'label'         =>  'Profil utilisateur',
                'multiple'      =>  true,
                'placeholder'   =>  'Choisir son role'
            ])
            ->add('tel', TextType::class, [
                'attr'  =>  [
                    'label'         =>  'Numéro de telephone',
                    'placeholder'   =>  'Entrer le numéro de téléphone',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
