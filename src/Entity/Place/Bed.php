<?php

namespace App\Entity\Place;

use App\Entity\Hospitalization\Hospitalization;
use App\Repository\Place\BedRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BedRepository::class)
 * @UniqueEntity("numero", message="Il y a déjà un lit avec ce numéro")
 */
class Bed
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", unique=true)
     */
    private $numero;

    /**
     * @ORM\Column(type="boolean")
     */
    private $disponible;
    
    /**
     * @ORM\ManyToOne(targetEntity=Bedroom::class, inversedBy="beds")
     */
    private $bedroom;

    /**
     * @ORM\OneToMany(targetEntity=Hospitalization::class, mappedBy="bed")
     */
    private $hospitalizations;


    public function __construct()
    {
        $this->hospitalizations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumero(): ?int
    {
        return $this->numero;
    }

    public function setNumero(int $numero): self
    {
        $this->numero = $numero;

        return $this;
    }

    public function getDisponible(): ?bool
    {
        return $this->disponible;
    }

    public function setDisponible(bool $disponible): self
    {
        $this->disponible = $disponible;

        return $this;
    }

    public function getBedroom(): ?Bedroom
    {
        return $this->bedroom;
    }

    public function setBedroom(?Bedroom $bedroom): self
    {
        $this->bedroom = $bedroom;

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
            $hospitalization->setBed($this);
        }

        return $this;
    }

    public function removeHospitalization(Hospitalization $hospitalization): self
    {
        if ($this->hospitalizations->contains($hospitalization)) {
            $this->hospitalizations->removeElement($hospitalization);
            // set the owning side to null (unless already changed)
            if ($hospitalization->getBed() === $this) {
                $hospitalization->setBed(null);
            }
        }

        return $this;
    }

}
