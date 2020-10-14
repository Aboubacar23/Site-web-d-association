<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class VisionController extends AbstractController
{
    /**
     * @Route("/vision", name="vision")
     */
    public function index()
    {
        return $this->render('vision/index.html.twig', [
            'controller_name' => 'VisionController',
        ]);
    }
}
