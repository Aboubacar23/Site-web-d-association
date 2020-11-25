<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;;


class BureauRecherche
{
    /**
     * @ORM\Column(type="String", length=225)
    */
    private $nom;


    public function getNom():?string
    {
        return $this->nom;
    }

    public function setNom(string $nom):self
    {
        $this->nom = $nom;
         
        return $this;
    }

}