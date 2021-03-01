<?php

namespace App\Controller;

use App\Entity\Admin;
use App\Form\ResetPasswordType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ProfilController extends AbstractController
{
    /**
     * @Route("/profil", name="profil")
     */
    public function index()
    {
        return $this->render('profil/index.html.twig', [
            'controller_name' => 'ProfilController',
        ]);
    }

      //afficher profil

      /**
     * @Route("/{id}/profil", name="profil", methods={"GET"})
     */
     public function getprofil($id){

        $admin = new Admin();

        $admin = $this->getDoctrine()->getRepository(Admin::class)->find($id);

        return $this->render('profil/index.html.twig', [
            'profil'=>$admin,
        ]);
     }

}
