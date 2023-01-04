<?php

namespace App\Entity;

use App\Repository\EtablissementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EtablissementRepository::class)]
class Etablissement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Nom = null;

    #[ORM\Column(length: 255)]
    private ?string $Slug = null;

    #[ORM\Column(length: 255)]
    private ?string $NumeroTelephone = null;

    #[ORM\Column(length: 255)]
    private ?string $AdressePostale = null;

    #[ORM\ManyToOne(inversedBy: 'etablissements')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Ville $Ville = null;

    #[ORM\Column(length: 255)]
    private ?string $AdresseMail = null;

    #[ORM\Column(length: 255)]
    private ?string $Image = null;

    #[ORM\Column]
    private ?bool $Actif = null;

    #[ORM\Column]
    private ?bool $Accueil = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $CreateAd = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $UpdatedAT = null;

    #[ORM\ManyToMany(targetEntity: Categorie::class, inversedBy: 'etablissements')]
    private Collection $Categorie;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $Description = null;

    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'favoris')]
    private Collection $users;

    public function __construct()
    {
        $this->Categorie = new ArrayCollection();
        $this->users = new ArrayCollection();
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

    public function getSlug(): ?string
    {
        return $this->Slug;
    }

    public function setSlug(string $Slug): self
    {
        $this->Slug = $Slug;

        return $this;
    }

    public function getNumeroTelephone(): ?string
    {
        return $this->NumeroTelephone;
    }

    public function setNumeroTelephone(string $NumeroTelephone): self
    {
        $this->NumeroTelephone = $NumeroTelephone;

        return $this;
    }

    public function getAdressePostale(): ?string
    {
        return $this->AdressePostale;
    }

    public function setAdressePostale(string $AdressePostale): self
    {
        $this->AdressePostale = $AdressePostale;

        return $this;
    }

    public function getVille(): ?Ville
    {
        return $this->Ville;
    }

    public function setVille(?Ville $Ville): self
    {
        $this->Ville = $Ville;

        return $this;
    }

    public function getAdresseMail(): ?string
    {
        return $this->AdresseMail;
    }

    public function setAdresseMail(string $AdresseMail): self
    {
        $this->AdresseMail = $AdresseMail;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->Image;
    }

    public function setImage(string $Image): self
    {
        $this->Image = $Image;

        return $this;
    }

    public function isActif(): ?bool
    {
        return $this->Actif;
    }

    public function setActif(bool $Actif): self
    {
        $this->Actif = $Actif;

        return $this;
    }

    public function isAccueil(): ?bool
    {
        return $this->Accueil;
    }

    public function setAccueil(bool $Accueil): self
    {
        $this->Accueil = $Accueil;

        return $this;
    }

    public function getCreateAd(): ?\DateTimeInterface
    {
        return $this->CreateAd;
    }

    public function setCreateAd(\DateTimeInterface $CreateAd): self
    {
        $this->CreateAd = $CreateAd;

        return $this;
    }

    public function getUpdatedAT(): ?\DateTimeInterface
    {
        return $this->UpdatedAT;
    }

    public function setUpdatedAT(\DateTimeInterface $UpdatedAT): self
    {
        $this->UpdatedAT = $UpdatedAT;

        return $this;
    }

    /**
     * @return Collection<int, Categorie>
     */
    public function getCategorie(): Collection
    {
        return $this->Categorie;
    }

    public function addCategorie(Categorie $categorie): self
    {
        if (!$this->Categorie->contains($categorie)) {
            $this->Categorie->add($categorie);
        }

        return $this;
    }

    public function removeCategorie(Categorie $categorie): self
    {
        $this->Categorie->removeElement($categorie);

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): self
    {
        $this->Description = $Description;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->addFavori($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            $user->removeFavori($this);
        }

        return $this;
    }
}
