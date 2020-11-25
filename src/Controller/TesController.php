<?php

namespace App\Controller;

use App\Entity\Membre;
use App\Repository\MembreRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TesController extends AbstractController
{
    /**
     * @Route("/tes", name="tes")
     */
    public function index(MembreRepository $repo)
    {
        $membre = new Membre();
        
        $var = $membre->getNom();
        
         if ( $var = "conde")
         {
            return $this->render('tes/index.html.twig', [
                'controller_name' => 'TesController',
            ]);
         }
      
    }
}
