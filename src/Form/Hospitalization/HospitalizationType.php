<?php

namespace App\Form\Hospitalization;

use App\Entity\Appointment\Patient;
use App\Entity\Hospitalization\Hospitalization;
use App\Entity\Place\Bed;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HospitalizationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateEntree')
            ->add('dateSortie')
            ->add('patient', EntityType::class, [
                'class'         =>  Patient::class,
                'choice_label'  =>  'nom',
                'placeholder'   =>  'Choisir un patient',
            ])
            ->add('bed', EntityType::class, [
                'class'         =>  Bed::class,
                'choice_label'  =>  'numero',
                'placeholder'   =>  'Choisir une place',
                'label'         =>  'Place',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Hospitalization::class,
        ]);
    }
}
