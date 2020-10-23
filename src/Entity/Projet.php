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
}
