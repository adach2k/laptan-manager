<?php

namespace App\Entity\Hospitalization;

use App\Entity\Appointment\Patient;
use App\Entity\Place\Bed;
use App\Repository\Hospitalization\HospitalizationRepository;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=HospitalizationRepository::class)
 * @UniqueEntity("bed", message="Cette place n'est pas disponible")
 */
class Hospitalization
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Patient::class, inversedBy="hospitalizations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $patient;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\GreaterThan("+1 hours", message="Date non valide")
     */
    private $dateEntree;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\GreaterThan("+1 hours", message="Date de sortie doit dépasser la date d'entrer")
     */
    private $dateSortie;

    /**
     * @ORM\OneToMany(targetEntity=Care::class, mappedBy="hospitalization")
     */
    private $cares;

    /**
     * @ORM\ManyToOne(targetEntity=Bed::class, inversedBy="hospitalizations")
     */
    private $bed;

    public function __construct()
    {
        $this->cares = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDateEntree(): ?\DateTimeInterface
    {
        return $this->dateEntree;
    }

    public function setDateEntree(\DateTimeInterface $dateEntree): self
    {
        $this->dateEntree = $dateEntree;

        return $this;
    }

    public function getDateSortie(): ?\DateTimeInterface
    {
        return $this->dateSortie;
    }

    public function setDateSortie(\DateTimeInterface $dateSortie): self
    {
        $this->dateSortie = $dateSortie;

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
            $care->setHospitalization($this);
        }

        return $this;
    }

    public function removeCare(Care $care): self
    {
        if ($this->cares->contains($care)) {
            $this->cares->removeElement($care);
            // set the owning side to null (unless already changed)
            if ($care->getHospitalization() === $this) {
                $care->setHospitalization(null);
            }
        }

        return $this;
    }

    public function getBed(): ?Bed
    {
        return $this->bed;
    }

    public function setBed(?Bed $bed): self
    {
        $this->bed = $bed;

        return $this;
    }
}
