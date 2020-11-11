<?php

namespace App\Entity;

use App\Repository\ProjetRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProjetRepository::class)
 */
class Projet
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
     * @ORM\Column(type="text", length=11777215)
     */
    private $Description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Document;

    /**
     * @ORM\ManyToOne(targetEntity=Genre::class)
     */
    private $Type;

    /**
     * @ORM\Column(type="date")
     */
    private $DateAjout;

    /**
     * @ORM\Column(type="date")
     */
    private $DateCreation;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Photo;

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

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): self
    {
        $this->Description = $Description;

        return $this;
    }

    public function getDocument(): ?string
    {
        return $this->Document;
    }

    public function setDocument(string $Document): self
    {
        $this->Document = $Document;

        return $this;
    }

    public function getType(): ?Genre
    {
        return $this->Type;
    }

    public function setType(?Genre $Type): self
    {
        $this->Type = $Type;

        return $this;
    }

    public function getDateAjout(): ?\DateTimeInterface
    {
        return $this->DateAjout;
    }

    public function setDateAjout(\DateTimeInterface $DateAjout): self
    {
        $this->DateAjout = $DateAjout;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->DateCreation;
    }

    public function setDateCreation(\DateTimeInterface $DateCreation): self
    {
        $this->DateCreation = $DateCreation;

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
}
