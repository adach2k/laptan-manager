<?php

namespace App\Entity\Hospitalization;

use App\Entity\Appointment\Medecin;
use App\Entity\Facturation\Facture;
use App\Repository\Hospitalization\CareRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CareRepository::class)
 */
class Care
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Hospitalization::class, inversedBy="cares")
     * @ORM\JoinColumn(nullable=false)
     */
    private $hospitalization;

    /**
     * @ORM\ManyToOne(targetEntity=TypeCare::class, inversedBy="cares")
     * @ORM\JoinColumn(nullable=false)
     */
    private $typeCare;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank
     * @Assert\Positive(message="Le montant doit être positif")
     * @Assert\Regex(pattern="/^[1-9]+0*$/", message="Le montant ne doit pas commencer par 0")
     * @Assert\Length(min="3", minMessage="La somme doit être au moins égale à 500")
     */
    private $montant;

    /**
     * @ORM\ManyToOne(targetEntity=Facture::class, inversedBy="cares")
     * @ORM\JoinColumn(nullable=true)
     */
    private $facture;

    /**
     * @ORM\ManyToOne(targetEntity=Medecin::class, inversedBy="cares")
     */
    private $medecin;

    public function __construct()
    {
        $this->type = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHospitalization(): ?Hospitalization
    {
        return $this->hospitalization;
    }

    public function setHospitalization(?Hospitalization $hospitalization): self
    {
        $this->hospitalization = $hospitalization;

        return $this;
    }

    public function getTypeCare(): ?TypeCare
    {
        return $this->typeCare;
    }

    public function setTypeCare(?TypeCare $typeCare): self
    {
        $this->typeCare = $typeCare;

        return $this;
    }

    public function getMontant(): ?int
    {
        return $this->montant;
    }

    public function setMontant(int $montant): self
    {
        $this->montant = $montant;

        return $this;
    }

    public function getFacture(): ?Facture
    {
        return $this->facture;
    }

    public function setFacture(?Facture $facture): self
    {
        $this->facture = $facture;

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
