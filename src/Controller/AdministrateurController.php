<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdministrateurController extends AbstractController
{
    /**
     * @Route("/administrateur", name="administrateur")
     */
    public function index()
    {
        return $this->render('administrateur/admin.html.twig', [
            'controller_name' => 'AdministrateurController',
        ]);
    }
}
