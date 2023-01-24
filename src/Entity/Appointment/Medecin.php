<?php

namespace App\Entity\Appointment;

use App\Entity\Hospitalization\Care;
use App\Repository\Appointment\MedecinRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=MedecinRepository::class)
 */
class Medecin
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Ce champs ne doit pas être vide")
     * @Assert\Length(min="2", minMessage="Le nom doit contenir deux caracteres minimum")
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=Appointment::class, mappedBy="medecin")
     */
    private $appointments;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Ce champs ne doit pas être vide")
     * @Assert\Length(min="2", minMessage="Le prénom doit contenir deux caracteres minimum")
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Veuillez remplir ce champs")
     */
    private $contact;

    /**
     * @ORM\ManyToOne(targetEntity=Speciality::class, inversedBy="medecins")
     * @Assert\NotBlank
     */
    private $speciality;

    /**
     * @ORM\OneToMany(targetEntity=Care::class, mappedBy="medecin")
     */
    private $cares;

    public function __construct()
    {
        $this->appointments = new ArrayCollection();
        $this->cares = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

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
            $appointment->setMedecin($this);
        }

        return $this;
    }

    public function removeAppointment(Appointment $appointment): self
    {
        if ($this->appointments->contains($appointment)) {
            $this->appointments->removeElement($appointment);
            // set the owning side to null (unless already changed)
            if ($appointment->getMedecin() === $this) {
                $appointment->setMedecin(null);
            }
        }

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

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

    public function getContact(): ?string
    {
        return $this->contact;
    }

    public function setContact(string $contact): self
    {
        $this->contact = $contact;

        return $this;
    }

    public function getSpeciality(): ?Speciality
    {
        return $this->speciality;
    }

    public function setSpeciality(?Speciality $speciality): self
    {
        $this->speciality = $speciality;

        return $this;
    }

    /**
     * @return Collection|Care[]
     */
    public function getCares(): Collection
    {
        return $this->cares;
    }

    public function addCare(Care $care): self
    {
        if (!$this->cares->contains($care)) {
            $this->cares[] = $care;
            $care->setMedecin($this);
        }

        return $this;
    }

    public function removeCare(Care $care): self
    {
        if ($this->cares->contains($care)) {
            $this->cares->removeElement($care);
            // set the owning side to null (unless already changed)
            if ($care->getMedecin() === $this) {
                $care->setMedecin(null);
            }
        }

        return $this;
    }
}
