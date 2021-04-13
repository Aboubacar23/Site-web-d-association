<?php

namespace App\Controller;

use App\Entity\Reunion;
use App\Form\ReunionType;
use App\Repository\ReunionRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/reunion")
 */
class ReunionController extends AbstractController
{
    /**
     * @Route("/", name="reunion_index", methods={"GET"})
     */
    public function index(ReunionRepository $reunionRepository, PaginatorInterface $paginatorInterface, Request $request): Response
    {
        $reunion = new Reunion();
        $donnees = $reunionRepository->findBy([],['id'=>'desc']);
        
         $reunion = $paginatorInterface->paginate( 

            $donnees, // les données de l'annonce
            $request->query->getInt('page',1), // la page par defaut 1 
            3 // nombre d'élement à afficher
 

         );

        return $this->render('reunion/index.html.twig', [
            'reunions' => $reunion,
        ]);
    }

    /**
     * @Route("/new", name="reunion_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $reunion = new Reunion();
        $form = $this->createForm(ReunionType::class, $reunion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $photo = $form->get('Photo')->getData();

            if($photo)
             {
                 $originalPhoto =pathinfo($photo->getClientOriginalName(),PATHINFO_FILENAME);
                 $phototName = $originalPhoto;
                 $newPhoto = $phototName.'.'.uniqid().'.'.$photo->guessExtension();
                 try {
                     $photo->move(
                         $this->getParameter('photo_directory_reunion'),
                         $newPhoto
                     );
                 } catch (\Throwable $th) {
                     //throw $th;
                 } 
             }
             //injection des deux variables dans la table membre
            $this->addFlash('success', 'le membre à été ajouter avec succes');
            $reunion->setPhoto($newPhoto);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($reunion);
            $entityManager->flush();

            return $this->redirectToRoute('reunion_index');
        }

        return $this->render('reunion/new.html.twig', [
            'reunion' => $reunion,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="reunion_show", methods={"GET"})
     */
    public function show(Reunion $reunion): Response
    {
        return $this->render('reunion/show.html.twig', [
            'reunion' => $reunion,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="reunion_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Reunion $reunion): Response
    {
        $form = $this->createForm(ReunionType::class, $reunion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('reunion_index');
        }

        return $this->render('reunion/edit.html.twig', [
            'reunion' => $reunion,
            'form' => $form->createView(),
        ]);
    }
 
    /**
     * @Route("/{id}", name="reunion_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Reunion $reunion): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reunion->getId(), $request->request->get('_token'))) {

        
            $photo = $reunion->getPhoto();
            unlink($this->getparameter('photo_directory_reunion').'/'.$photo);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($reunion);
            $entityManager->flush();
        }

        return $this->redirectToRoute('reunion_index');
    }
}
