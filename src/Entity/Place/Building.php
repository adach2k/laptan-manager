<?php

namespace App\Entity\Place;

use App\Repository\Place\BuildingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BuildingRepository::class)
 */
class Building
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
    private $libelle;

    /**
     * @ORM\OneToMany(targetEntity=Bedroom::class, mappedBy="building")
     */
    private $bedrooms;

    public function __construct()
    {
        $this->bedrooms = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * @return Collection|Bedroom[]
     */
    public function getBedrooms(): Collection
    {
        return $this->bedrooms;
    }

    public function addBedroom(Bedroom $bedroom): self
    {
        if (!$this->bedrooms->contains($bedroom)) {
            $this->bedrooms[] = $bedroom;
            $bedroom->setBuilding($this);
        }

        return $this;
    }

    public function removeBedroom(Bedroom $bedroom): self
    {
        if ($this->bedrooms->contains($bedroom)) {
            $this->bedrooms->removeElement($bedroom);
            // set the owning side to null (unless already changed)
            if ($bedroom->getBuilding() === $this) {
                $bedroom->setBuilding(null);
            }
        }

        return $this;
    }
}
