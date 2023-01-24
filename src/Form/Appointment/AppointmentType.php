<?php

namespace App\Form\Appointment;

use App\Entity\Appointment\Appointment;
use App\Entity\Appointment\Medecin;
use App\Entity\Appointment\Patient;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AppointmentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('patient', EntityType::class, [
                'class' => Patient::class,
                'choice_label' => 'nom',
                'label' => false,
                'required' => true,
                'placeholder' => 'Choisir le patient',
            ])
            ->add('medecin', EntityType::class, [
                'class' => Medecin::class,
                'choice_label' => 'name',
                'label' => false,
                'required' => true,
                'placeholder' => 'Choisir le medecin',
            ])
            ->add('appointmentAt', DateTimeType::class)

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Appointment::class,
        ]);
    }
}
