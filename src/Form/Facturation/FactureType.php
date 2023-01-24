<?php

namespace App\Form\Facturation;

use App\Entity\Facturation\Facture;
use App\Entity\Hospitalization\Care;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FactureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('cares', EntityType::class, [
                'class' => Care::class,
                'choice_label'  => function(Care $care) {
                    return $care->getTypeCare()->getLabel();
                },
                'multiple'  => true,
                'required' => true,
                'placeholder' => 'Choisir les soins à facturer',
                'label' => 'Choisir un soin pour la facturation'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Facture::class,
        ]);
    }
}
