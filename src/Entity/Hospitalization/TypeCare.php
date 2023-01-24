<?php

namespace App\Entity\Hospitalization;

use App\Repository\Hospitalization\TypeCareRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TypeCareRepository::class)
 * @UniqueEntity("label", message="Ce nom existe déjà")
 */
class TypeCare
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
    private $label;

    /**
     * @ORM\OneToMany(targetEntity=Care::class, mappedBy="typeCare")
     */
    private $cares;

    public function __construct()
    {
        $this->cares = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

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
            $care->setTypeCare($this);
        }

        return $this;
    }

    public function removeCare(Care $care): self
    {
        if ($this->cares->contains($care)) {
            $this->cares->removeElement($care);
            // set the owning side to null (unless already changed)
            if ($care->getTypeCare() === $this) {
                $care->setTypeCare(null);
            }
        }

        return $this;
    }
}
