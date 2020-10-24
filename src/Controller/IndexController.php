<?php

namespace App\Controller;

use App\Entity\Membre;
use App\Entity\Projet;
use App\Entity\Historique;
use App\Entity\Presentation;
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
            3 // nombre d'élement à afficher


         );

        return $this->render('users/users_membre.html.twig', [
            'users' => $membre,
        ]);
    }


    /**
     * @Route("/{id}/affiche", name="afficher_user_membre", methods={"GET"})
     */
    public function show(Membre $membre): Response
    {
        return $this->render('users/show_membre.html.twig', [
            'membre' => $membre,
        ]);
    }

     /** 
    *@Route("/presentationgeneral", name="user_presentation")
    */ 
    public function presentation():Response
    {

        $presentation = new Presentation();

        $presentation =$this->getDoctrine()->getRepository(Presentation::class)->findAll();

        return $this->render('users/presentation.html.twig',[
            'presentations' => $presentation,
        ]);
        

    } 


         /**
     * @Route("/projets", name="users_projet")
     */
    public function getProjet(Request $request, PaginatorInterface $paginatorInterface)
    {
        $projet = new Projet();
        $donnees = $this->getDoctrine()->getRepository(Projet::class)->findAll();
        
         $projet = $paginatorInterface->paginate(

            $donnees, // les données de l'annonce
            $request->query->getInt('page',1), // la page par defaut 1 
            3 // nombre d'élement à afficher


         );

        return $this->render('users/projet.html.twig', [
            'user_projet' => $projet,
        ]);
    }


}
