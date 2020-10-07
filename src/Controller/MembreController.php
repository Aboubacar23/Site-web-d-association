<?php

namespace App\Controller;

use App\Entity\Membre;
use App\Form\MembreType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/membre")
 */
class MembreController extends AbstractController
{
    /**
     * @Route("/", name="membre_index", methods={"GET"})
     */
    public function index(Request $request,PaginatorInterface $paginatorInterface): Response
    {
        $membre = new Membre();
        $donnees = $this->getDoctrine()->getRepository(Membre::class)->findAll();
        
         $membre = $paginatorInterface->paginate(

            $donnees, // les données de l'annonce
            $request->query->getInt('page',1), // la page par defaut 1 
            3 // nombre d'élement à afficher


         );

        return $this->render('membre/index.html.twig', [
            'membres' => $membre,
        ]);
    }

    /**
     * @Route("/new", name="membre_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $membre = new Membre();
        $form = $this->createForm(MembreType::class, $membre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //declaration des variables photo et cv 
            $document = $form->get('Cv')->getData();
            $photo = $form->get('Photo')->getData();

            //uploader un fichier pdf
             if($document)
             {
                 $originalDocument =pathinfo($document->getClientOriginalName(),PATHINFO_FILENAME);
                 $documentName = $originalDocument;
                 $newDocument = $documentName.'.'.uniqid().'.'.$document->guessExtension();
                 try {
                     $document->move(
                         $this->getParameter('cv_directory'),
                         $newDocument
                     );
                 } catch (\Throwable $th) {
                     //throw $th;
                 }
             }

                //uploader un fichier image
             if($photo)
             {
                 $originalPhoto =pathinfo($photo->getClientOriginalName(),PATHINFO_FILENAME);
                 $phototName = $originalPhoto;
                 $newPhoto = $phototName.'.'.uniqid().'.'.$photo->guessExtension();
                 try {
                     $photo->move(
                         $this->getParameter('photo_directory'),
                         $newPhoto
                     );
                 } catch (\Throwable $th) {
                     //throw $th;
                 }
             }
             //injection des deux variables dans la table membre
            $this->addFlash('success', 'le membre à été ajouter avec succes');
            $membre->setCv($newDocument);
            $membre->setPhoto($newPhoto);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($membre);
            $entityManager->flush();

            return $this->redirectToRoute('membre_index');
        }

        return $this->render('membre/new.html.twig', [
            'membre' => $membre,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="membre_show", methods={"GET"})
     */
    public function show(Membre $membre): Response
    {
        return $this->render('membre/show.html.twig', [
            'membre' => $membre,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="membre_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Membre $membre): Response
    {
        $form = $this->createForm(MembreType::class, $membre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('membre_index');
        }

        return $this->render('membre/edit.html.twig', [
            'membre' => $membre,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="membre_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Membre $membre): Response
    {
        if ($this->isCsrfTokenValid('delete'.$membre->getId(), $request->request->get('_token'))) 
        {
            $document = $membre->getCv();
            $photo = $membre->getPhoto();
            unlink($this->getparameter('cv_directory').'/'.$document);
            unlink($this->getparameter('photo_directory').'/'.$photo);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($membre);
            $entityManager->flush();
        }
 
        return $this->redirectToRoute('membre_index');
    }
}
