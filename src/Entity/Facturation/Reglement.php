<?php

namespace App\Entity\Facturation;

use App\Repository\Facturation\ReglementRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ReglementRepository::class)
 */
class Reglement
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
     * @ORM\Column(type="integer")
     * @Assert\NotBlank
     * @Assert\Positive(message="Le montant doit être positif")
     * @Assert\Regex(pattern="/^[1-9]+0*$/", message="Le montant ne doit pas commencer par 0")
     * @Assert\Length(min="3", minMessage="La somme doit être au moins égale à 500")
     */
    private $montantPaye;

    /**
     * @ORM\Column(type="integer")
     */
    private $montantRestant;

    /**
     * @ORM\Column(type="boolean")
     */
    private $etat;

    /**
     * @ORM\ManyToOne(targetEntity=Facture::class, inversedBy="reglements")
     * @ORM\JoinColumn(nullable=false)
     */
    private $facture;

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

    public function getMontantPaye(): ?int
    {
        return $this->montantPaye;
    }

    public function setMontantPaye(int $montantPaye): self
    {
        $this->montantPaye = $montantPaye;

        return $this;
    }

    public function getMontantRestant(): ?int
    {
        return $this->montantRestant;
    }

    public function setMontantRestant(int $montantRestant): self
    {
        $this->montantRestant = $montantRestant;

        return $this;
    }

    public function getEtat(): ?bool
    {
        return $this->etat;
    }

    public function setEtat(bool $etat): self
    {
        $this->etat = $etat;

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
}
