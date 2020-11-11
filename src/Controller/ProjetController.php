<?php

namespace App\Controller;

use App\Entity\Projet;
use App\Form\ProjetType;
use App\Repository\ProjetRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/projet")
 * 
 * @IsGranted("ROLE_ADMIN")
 */
class ProjetController extends AbstractController
{
    /**
     * @Route("/", name="projet_index", methods={"GET"})
     */
    public function index(ProjetRepository $projetRepository,Request $request, PaginatorInterface $paginatorInterface): Response
    {
        $projet = new Projet();
        $donnees = $projetRepository->findBy([],['id'=>'desc']);
        
         $projet = $paginatorInterface->paginate(

            $donnees, // les données de l'annonce
            $request->query->getInt('page',1), // la page par defaut 1 
            5 // nombre d'élement à afficher


         );
        return $this->render('projet/index.html.twig', [
            'projets' => $projet,
        ]);
    } 

    /**
     * @Route("/new", name="projet_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $projet = new Projet();
        $form = $this->createForm(ProjetType::class, $projet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $document = $form->get('Document')->getData();
            $photo = $form->get('Photo')->getData();
            

            //uploader un fichier pdf
             if($document)
             {
                 $originalDocument =pathinfo($document->getClientOriginalName(),PATHINFO_FILENAME);
                 $documentName = $originalDocument;
                 $newDocument = $documentName.'.'.uniqid().'.'.$document->guessExtension();
                 try {
                     $document->move(
                         $this->getParameter('document_projet_directory'),
                         $newDocument
                     );
                 } catch (\Throwable $th) {
                     //throw $th;
                 }
             }

             if($photo)
             {
                 $originalPhoto =pathinfo($photo->getClientOriginalName(),PATHINFO_FILENAME);
                 $phototName = $originalPhoto;
                 $newPhoto = $phototName.'.'.uniqid().'.'.$photo->guessExtension();
                 try {
                     $photo->move(
                         $this->getParameter('photo_projet_directory'),
                         $newPhoto
                     );
                 } catch (\Throwable $th) {
                     //throw $th;
                 }
             }
             $projet->setDocument($newDocument);
             $projet->setPhoto($newPhoto);
             $this->addFlash('success', 'le projet à été ajouter avec succes');
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($projet);
            $entityManager->flush();

            return $this->redirectToRoute('projet_index');
        }

        return $this->render('projet/new.html.twig', [
            'projet' => $projet,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="projet_show", methods={"GET"})
     */
    public function show(Projet $projet): Response
    {
        return $this->render('projet/show.html.twig', [
            'projet' => $projet,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="projet_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Projet $projet): Response
    {
        $form = $this->createForm(ProjetType::class, $projet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('projet_index');
        }

        return $this->render('projet/edit.html.twig', [
            'projet' => $projet,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="projet_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Projet $projet): Response
    {
        if ($this->isCsrfTokenValid('delete'.$projet->getId(), $request->request->get('_token'))) {
           
            $document = $projet->getDocument();
            unlink($this->getparameter('document_projet_directory').'/'.$document);
        
           
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($projet);
            $entityManager->flush();
        }

        return $this->redirectToRoute('projet_index');
    }
}
