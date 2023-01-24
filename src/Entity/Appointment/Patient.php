<?php

namespace App\Entity\Appointment;

use App\Entity\Hospitalization\Hospitalization;
use App\Repository\Appointment\PatientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=PatientRepository::class)
 */
class Patient
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $code;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Ce champs doit être rempli")
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Ce champs doit être rempli")
     */
    private $prenom;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message="Ce champs doit être rempli")
     * @Assert\Positive(message="Age doit être positif")
     */
    private $age;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Ce champs doit être rempli")
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Ce champs doit être rempli")
     * @Assert\Regex(pattern="/^7[0-9]*$/", message="Le numéro doit être composé de nombre")
     * @Assert\Length(min="6", minMessage="Un numéro de doit contenir 6 nombres minimum")
     */
    private $tel;

    /**
     * @ORM\OneToMany(targetEntity=Appointment::class, mappedBy="patient")
     */
    private $appointments;

    /**
     * @ORM\OneToMany(targetEntity=Hospitalization::class, mappedBy="patient")
     */
    private $hospitalizations;

    public function __construct()
    {
        $this->appointments = new ArrayCollection();
        $this->hospitalizations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(int $age): self
    {
        $this->age = $age;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getTel(): ?string
    {
        return $this->tel;
    }

    public function setTel(string $tel): self
    {
        $this->tel = $tel;

        return $this;
    }

    /**
     * @return Collection|Appointment[]
     */
    public function getAppointments(): Collection
    {
        return $this->appointments;
    }

    public function addAppointment(Appointment $appointment): self
    {
        if (!$this->appointments->contains($appointment)) {
            $this->appointments[] = $appointment;
            $appointment->setPatient($this);
        }

        return $this;
    }

    public function removeAppointment(Appointment $appointment): self
    {
        if ($this->appointments->contains($appointment)) {
            $this->appointments->removeElement($appointment);
            // set the owning side to null (unless already changed)
            if ($appointment->getPatient() === $this) {
                $appointment->setPatient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Hospitalization[]
     */
    public function getHospitalizations(): Collection
    {
        return $this->hospitalizations;
    }

    public function addHospitalization(Hospitalization $hospitalization): self
    {
        if (!$this->hospitalizations->contains($hospitalization)) {
            $this->hospitalizations[] = $hospitalization;
            $hospitalization->setPatient($this);
        }

        return $this;
    }

    public function removeHospitalization(Hospitalization $hospitalization): self
    {
        if ($this->hospitalizations->contains($hospitalization)) {
            $this->hospitalizations->removeElement($hospitalization);
            // set the owning side to null (unless already changed)
            if ($hospitalization->getPatient() === $this) {
                $hospitalization->setPatient(null);
            }
        }

        return $this;
    }
}
