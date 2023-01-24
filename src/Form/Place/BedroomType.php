<?php

namespace App\Form\Place;

use App\Entity\Place\Bedroom;
use App\Entity\Place\Building;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BedroomType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('numero')
            ->add('building', EntityType::class, [
                'class'         =>  Building::class,
                'choice_label'  =>  'libelle',
                'label'         =>  'Bâtiment',
                'placeholder'   =>  'Choisir le bâtiment',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Bedroom::class,
        ]);
    }
}
