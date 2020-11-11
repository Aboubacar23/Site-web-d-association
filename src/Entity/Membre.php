<?php

namespace App\Entity;

use App\Entity\Niveau;
use App\Entity\Universite;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\MembreRepository;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=MembreRepository::class)
 */
class Membre
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Prenom;

    /**
     * @ORM\Column(type="date")
     */
    private $Date_anniversaire;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Pays;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Poste;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Cv;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Photo;

    /**
     * @ORM\ManyToOne(targetEntity=Niveau::class)
     */
    private $Niveau;

    /**
     * @ORM\Column(type="text",length=11777215)
     */
    private $Profil;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 8,
     *      max = 20
     * )
     */
    private $Telephone;

    /**
     * @ORM\ManyToOne(targetEntity=Universite::class)
     */
    private $Universite;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Specialite;

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

    public function getPrenom(): ?string
    {
        return $this->Prenom;
    }

    public function setPrenom(string $Prenom): self
    {
        $this->Prenom = $Prenom;

        return $this;
    }

    public function getDateAnniversaire(): ?\DateTimeInterface
    {
        return $this->Date_anniversaire;
    }

    public function setDateAnniversaire(\DateTimeInterface $Date_anniversaire): self
    {
        $this->Date_anniversaire = $Date_anniversaire;

        return $this;
    }

    public function getPays(): ?string
    {
        return $this->Pays;
    }

    public function setPays(string $Pays): self
    {
        $this->Pays = $Pays;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->Email;
    }

    public function setEmail(string $Email): self
    {
        $this->Email = $Email;

        return $this;
    }

    public function getPoste(): ?string
    {
        return $this->Poste;
    }

    public function setPoste(string $Poste): self
    {
        $this->Poste = $Poste;

        return $this;
    }

    public function getCv(): ?string
    {
        return $this->Cv;
    }

    public function setCv(string $Cv): self
    {
        $this->Cv = $Cv;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->Photo;
    }

    public function setPhoto(string $Photo): self
    {
        $this->Photo = $Photo;

        return $this;
    }

    public function getNiveau(): ?Niveau
    {
        return $this->Niveau;
    }

    public function setNiveau(?Niveau $Niveau): self
    {
        $this->Niveau = $Niveau;

        return $this;
    }

    public function getProfil(): ?string
    {
        return $this->Profil;
    }

    public function setProfil(string $Profil): self
    {
        $this->Profil = $Profil;

        return $this;
    }

    public function getTelephone(): ?int
    {
        return $this->Telephone;
    }

    public function setTelephone(int $Telephone): self
    {
        $this->Telephone = $Telephone;

        return $this;
    }

    public function getUniversite(): ?Universite
    {
        return $this->Universite;
    }

    public function setUniversite(?Universite $Universite): self
    {
        $this->Universite = $Universite;

        return $this;
    }

    public function getSpecialite(): ?string
    {
        return $this->Specialite;
    }

    public function setSpecialite(string $Specialite): self
    {
        $this->Specialite = $Specialite;

        return $this;
    }
}
