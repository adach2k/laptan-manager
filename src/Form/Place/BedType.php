<?php

namespace App\Form\Place;

use App\Entity\Place\Bed;
use App\Entity\Place\Bedroom;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BedType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('numero')
            ->add('bedroom', EntityType::class, [
                'class'         =>  Bedroom::class,
                'choice_label'  =>  'numero',
                'label'         =>  'Chambre',
                'placeholder'   =>  'Choisir la chambre'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Bed::class,
        ]);
    }
}
