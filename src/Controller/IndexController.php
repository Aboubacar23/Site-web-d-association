<?php

namespace App\Controller;

use App\Entity\Membre;
use App\Entity\Historique;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class IndexController extends AbstractController
{
    /**
     * @Route("/index", name="index")
     */
    public function index()
    {
        return $this->render('index/index.html.twig', [
            'controller_name' => 'IndexController',
        ]);
    }


    /** 
    *@Route("/history", name="user_history")
    */ 
    public function liste():Response
    {

        $history = new Historique();

        $history =$this->getDoctrine()->getRepository(Historique::class)->findAll();

        return $this->render('users/history.html.twig',[
            'historys' => $history,
        ]);
        

    } 

   
     /**
     * @Route("/users", name="users_membre")
     */
    public function getMembreUser(Request $request, PaginatorInterface $paginatorInterface)
    {
        $membre = new Membre();
        $donnees = $this->getDoctrine()->getRepository(Membre::class)->findAll();
        
         $membre = $paginatorInterface->paginate(

            $donnees, // les données de l'annonce
            $request->query->getInt('page',1), // la page par defaut 1 
            4 // nombre d'élement à afficher


         );

        return $this->render('users/users_membre.html.twig', [
            'users' => $membre,
        ]);
    }

}
