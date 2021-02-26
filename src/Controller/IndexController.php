<?php

namespace App\Controller;

use App\Entity\Bureau;
use App\Entity\Membre;
use App\Entity\Projet;
use App\Entity\Reunion;
use App\Entity\Admin;
use App\Entity\Historique;
use App\Entity\Presentation;
use App\Repository\BureauRepository;
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
    public function index(Request $request, PaginatorInterface $paginatorInterface)
    {
        $reunion = new Reunion();
         $donnees = $this->getDoctrine()->getRepository(Reunion::class)->findBy([],['id'=>'desc']);
         
          $reunion = $paginatorInterface->paginate(
 
             $donnees, // les données de l'annonce
             $request->query->getInt('page',1), // la page par defaut 1 
             3 // nombre d'élement à afficher
 
 
          );

        return $this->render('index/index.html.twig', [
            'user_reunion' => $reunion,
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
            9 // nombre d'élement à afficher


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
        $donnees = $this->getDoctrine()->getRepository(Projet::class)->findBy([],['id'=>'desc']);
        
         $projet = $paginatorInterface->paginate(

            $donnees, // les données de l'annonce
            $request->query->getInt('page',1), // la page par defaut 1 
            4 // nombre d'élement à afficher


         );

        return $this->render('users/projet.html.twig', [
            'user_projet' => $projet,
        ]);
    }

     /**
     * @Route("/{id}/voir", name="voir_projet", methods={"GET"})
     */
    public function getProjetFindby(Projet $projet): Response
    {
        return $this->render('users/show_projet.html.twig', [
            'projet' => $projet,
        ]);
    }

 
    /**
     * @Route("/user/membre/bureau", name="liste_membre_bureau")
    */
    public function getMembreBureau(BureauRepository $bureauRepository, Request $request, PaginatorInterface $paginatorInterface)
    {
        $donnees = $bureauRepository->findAll();

        $bureau = $paginatorInterface->paginate(
            $donnees,
            $request->query->getInt("page",1),
            9
        );
        return $this->render('users/membre_bureau.html.twig',[
            'bureaux' => $bureau,
        ]);
 
    }


     /**
     * @Route("/{id}/afficher", name="get_membre_bureau", methods={"GET"})
     */
    public function showBureau(Bureau $bureau): Response
    {
        return $this->render('users/show_bureau.html.twig', [
            'bureau' => $bureau,
        ]);
    }


    //afficher la liste par details des reunions

      /**
     * @Route("/{id}/voir", name="voir_reunion", methods={"GET"})
     */
     public function getReunionFindby(Reunion $reunion): Response
     {
         return $this->render('users/show_reunion.html.twig', [
             'reunion' => $reunion,
         ]);
     }
 

     //afficher profil

      /**
     * @Route("/{id}/profil", name="profil", methods={"GET"})
     */
     public function getReunion(Admin $admin): Response{

        return $this->render('profil/index.html.twig', [
            'profil'=>$admin,
        ]);
     }
}
 