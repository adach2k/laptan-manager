<?php

namespace App\Form\Facturation;

use App\Entity\Facturation\Facture;
use App\Entity\Facturation\Reglement;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReglementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('facture', EntityType::class, [
                'class' => Facture::class,
                'choice_label' => 'numero',
                'placeholder'  => 'Choisir la facture',
            ])
            ->add('montantPaye')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Reglement::class,
        ]);
    }
}
