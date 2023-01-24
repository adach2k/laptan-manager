<?php

namespace App\Form\Hospitalization;

use App\Entity\Appointment\Medecin;
use App\Entity\Facturation\Facture;
use Doctrine\ORM\EntityRepository;
use App\Entity\Hospitalization\Care;
use Symfony\Component\Form\AbstractType;
use App\Entity\Hospitalization\Hospitalization;
use App\Entity\Hospitalization\TypeCare;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CareType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('hospitalization', EntityType::class, [
                'class'         =>  Hospitalization::class,
                'choice_label'  =>  function(Hospitalization $hospitalization) { return $hospitalization->getPatient()->getNom();},
                'placeholder'   =>  'Choisir le patient à soigner',
                'label'         =>  'Patient hospitalisé',
            ])
            ->add('typeCare', EntityType::class, [
                'class'         =>  TypeCare::class,
                'choice_label'  =>  'label',
                'placeholder'   =>  'Choisir le type de soin',
                'label'         =>  'Type soin',
            ])
            ->add('medecin', EntityType::class, [
                'class'         =>  Medecin::class,
                'choice_label'  =>  'Name',
                'placeholder'   =>  'Choisir le medecin traitant',
                'label'         =>  'Medecin traitant',
            ])
            ->add('facture', EntityType::class, [
                'class'         =>  Facture::class,
                'choice_label'  =>  'numero',
                'placeholder'   =>  'Choisir la facture pour ce soin',
                'label'         =>  'Numéro Facture',
            ])
            ->add('montant')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Care::class,
        ]);
    }
}
