<?php

namespace App\Entity;

use App\Repository\VilleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VilleRepository::class)]
class Ville
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Nom = null;

    #[ORM\Column(length: 255)]
    private ?string $CodePostale = null;

    #[ORM\Column(length: 255)]
    private ?string $NomDepartement = null;

    #[ORM\Column(length: 255)]
    private ?string $NumeroDepartement = null;

    #[ORM\Column(length: 255)]
    private ?string $NomRegion = null;

    #[ORM\OneToMany(mappedBy: 'Ville', targetEntity: Etablissement::class)]
    private Collection $etablissements;

    public function __construct()
    {
        $this->etablissements = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->Nom;
    }

    public function setNom(string $Nom): self
    {
        $this->Nom = $Nom;

        return $this;
    }

    public function getCodePostale(): ?string
    {
        return $this->CodePostale;
    }

    public function setCodePostale(string $CodePostale): self
    {
        $this->CodePostale = $CodePostale;

        return $this;
    }

    public function getNomDepartement(): ?string
    {
        return $this->NomDepartement;
    }

    public function setNomDepartement(string $NomDepartement): self
    {
        $this->NomDepartement = $NomDepartement;

        return $this;
    }

    public function getNumeroDepartement(): ?string
    {
        return $this->NumeroDepartement;
    }

    public function setNumeroDepartement(string $NumeroDepartement): self
    {
        $this->NumeroDepartement = $NumeroDepartement;

        return $this;
    }

    public function getNomRegion(): ?string
    {
        return $this->NomRegion;
    }

    public function setNomRegion(string $NomRegion): self
    {
        $this->NomRegion = $NomRegion;

        return $this;
    }

    /**
     * @return Collection<int, Etablissement>
     */
    public function getEtablissements(): Collection
    {
        return $this->etablissements;
    }

    public function addEtablissement(Etablissement $etablissement): self
    {
        if (!$this->etablissements->contains($etablissement)) {
            $this->etablissements->add($etablissement);
            $etablissement->setVille($this);
        }

        return $this;
    }

    public function removeEtablissement(Etablissement $etablissement): self
    {
        if ($this->etablissements->removeElement($etablissement)) {
            // set the owning side to null (unless already changed)
            if ($etablissement->getVille() === $this) {
                $etablissement->setVille(null);
            }
        }

        return $this;
    }
}
