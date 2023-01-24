<?php

namespace App\Entity\Place;

use App\Repository\Place\BedroomRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BedroomRepository::class)
 * @UniqueEntity("numero", message="Il y a déjà une chambre avec ce numéro")
 */
class Bedroom
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $numero;

    /**
     * @ORM\ManyToOne(targetEntity=Building::class, inversedBy="bedrooms")
     * @ORM\JoinColumn(nullable=false)
     */
    private $building;

    /**
     * @ORM\OneToMany(targetEntity=Bed::class, mappedBy="bedroom")
     */
    private $beds;

    public function __construct()
    {
        $this->beds = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumero(): ?string
    {
        return $this->numero;
    }

    public function setNumero(string $numero): self
    {
        $this->numero = $numero;

        return $this;
    }

    public function getBuilding(): ?Building
    {
        return $this->building;
    }

    public function setBuilding(?Building $building): self
    {
        $this->building = $building;

        return $this;
    }

    /**
     * @return Collection|Bed[]
     */
    public function getBeds(): Collection
    {
        return $this->beds;
    }

    public function addBed(Bed $bed): self
    {
        if (!$this->beds->contains($bed)) {
            $this->beds[] = $bed;
            $bed->setBedroom($this);
        }

        return $this;
    }

    public function removeBed(Bed $bed): self
    {
        if ($this->beds->contains($bed)) {
            $this->beds->removeElement($bed);
            // set the owning side to null (unless already changed)
            if ($bed->getBedroom() === $this) {
                $bed->setBedroom(null);
            }
        }

        return $this;
    }
}
