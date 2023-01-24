<?php

namespace App\Entity\Appointment;

use App\Repository\Appointment\AppointmentRepository;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AppointmentRepository::class)
 * @UniqueEntity("appointmentAt", message="Il y a un rendez-vous à cette date")
 */
class Appointment
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="appointment_at", type="datetime", unique=true)
     * @Assert\GreaterThan("today", message="La date du rendez-vous doit être supérieur à la date du jour")
     */
    private $appointmentAt;

    /**
     * @ORM\ManyToOne(targetEntity=Patient::class, inversedBy="appointments")
     */
    private $patient;

    /**
     * @ORM\ManyToOne(targetEntity=Medecin::class, inversedBy="appointments")
     */
    private $medecin;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAppointmentAt(): ?\DateTimeInterface
    {
        return $this->appointmentAt;
    }

    public function setAppointmentAt(\DateTimeInterface $appointmentAt): self
    {
        $this->appointmentAt = $appointmentAt;

        return $this;
    }

    public function getPatient(): ?Patient
    {
        return $this->patient;
    }

    public function setPatient(?Patient $patient): self
    {
        $this->patient = $patient;

        return $this;
    }

    public function getMedecin(): ?Medecin
    {
        return $this->medecin;
    }

    public function setMedecin(?Medecin $medecin): self
    {
        $this->medecin = $medecin;

        return $this;
    }
}
