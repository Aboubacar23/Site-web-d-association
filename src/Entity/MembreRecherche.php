<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;;


class MembreRecherche
{
    
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $Nom): self
    {
        $this->nom = $Nom;

        return $this;
    }
    
 
}
