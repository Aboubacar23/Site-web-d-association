<?php

namespace App\Controller;

use App\Entity\Bureau;
use App\Form\BureauType;
use App\Form\BureauRechercheType;
use App\Repository\BureauRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/bureau") 
 * @IsGranted("ROLE_USER")
 */
class BureauController extends AbstractController
{
    /**
     * @Route("/", name="bureau_index", methods={"GET"})
     */
    public function index(BureauRepository $bureauRepository, PaginatorInterface $paginatorInterface, Request $request): Response
    {
        $recherche = $this->createForm(BureauRechercheType::class);
        $recherche->handleRequest($request);
        $bureau = new Bureau();
        $donnees = $this->getDoctrine()->getRepository(Bureau::class)->findAll();

        if($recherche->isSubmitted() && $recherche->isvalid())
        {
            $nom = $recherche->getData()->getNom();
            $donnees = $bureauRepository->search($nom);

            if($donnees == null)
            {
                $this->addflash("erreur", "le nom que vous chercher  n'existe pas !");
            }
        }
       
        $bureau = $paginatorInterface->paginate(
            $donnees,
            $request->query->getInt('page',1),
            5
        );
        return $this->render('bureau/index.html.twig', [
            'bureaus' => $bureau,
            'form'=> $recherche->createView(),
        ]);
    }

    /**
     * @Route("/new", name="bureau_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $bureau = new Bureau();
        $form = $this->createForm(BureauType::class, $bureau);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //declaration des variables photo et cv
            $document = $form->get('Cv')->getData();
            $photo = $form->get('Photo')->getData();

            //uploader un fichier pdf
            if ($document) {
                $originalDocument =pathinfo($document->getClientOriginalName(), PATHINFO_FILENAME);
                $documentName = $originalDocument;
                $newDocument = $documentName.'.'.uniqid().'.'.$document->guessExtension();
                try {
                    $document->move(
                        $this->getParameter('cv_directory_bureau'),
                        $newDocument
                    );
                } catch (\Throwable $th) {
                    //throw $th;
                }
            }
 
            //uploader un fichier image
            if ($photo) {
                $originalPhoto =pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME);
                $phototName = $originalPhoto;
                $newPhoto = $phototName.'.'.uniqid().'.'.$photo->guessExtension();
                try {
                    $photo->move(
                        $this->getParameter('photo_directory_bureau'),
                        $newPhoto
                    );
                } catch (\Throwable $th) {
                    //throw $th;
                }
            }
            //injection des deux variables dans la table membre
            $this->addFlash('success', 'le membre du bureau à été ajouter avec succes');
            $bureau->setCv($newDocument);
            $bureau->setPhoto($newPhoto);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($bureau);
            $entityManager->flush();

            return $this->redirectToRoute('bureau_index');
        }
        return $this->render('bureau/new.html.twig', [
            'bureau' => $bureau,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="bureau_show", methods={"GET"})
     */
    public function show(Bureau $bureau): Response
    {
        return $this->render('bureau/show.html.twig', [
            'bureau' => $bureau,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="bureau_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Bureau $bureau): Response
    {
        $form = $this->createForm(BureauType::class, $bureau);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('bureau_index');
        }

        return $this->render('bureau/edit.html.twig', [
            'bureau' => $bureau,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="bureau_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Bureau $bureau): Response
    {
        if ($this->isCsrfTokenValid('delete'.$bureau->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($bureau);
            $entityManager->flush();
        }

        return $this->redirectToRoute('bureau_index');
    }
}
