<?php

namespace App\Controller;

use App\Entity\TypeProjet;
use App\Form\TypeProjetType;
use App\Repository\TypeProjetRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/type/projet")
 */
class TypeProjetController extends AbstractController
{
    /**
     * @Route("/", name="type_projet_index", methods={"GET"})
     */
    public function index(TypeProjetRepository $typeProjetRepository): Response
    {
        return $this->render('type_projet/index.html.twig', [
            'type_projets' => $typeProjetRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="type_projet_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $typeProjet = new TypeProjet();
        $form = $this->createForm(TypeProjetType::class, $typeProjet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($typeProjet);
            $entityManager->flush();

            return $this->redirectToRoute('type_projet_index');
        }

        return $this->render('type_projet/new.html.twig', [
            'type_projet' => $typeProjet,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="type_projet_show", methods={"GET"})
     */
    public function show(TypeProjet $typeProjet): Response
    {
        return $this->render('type_projet/show.html.twig', [
            'type_projet' => $typeProjet,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="type_projet_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, TypeProjet $typeProjet): Response
    {
        $form = $this->createForm(TypeProjetType::class, $typeProjet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('type_projet_index');
        }

        return $this->render('type_projet/edit.html.twig', [
            'type_projet' => $typeProjet,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="type_projet_delete", methods={"DELETE"})
     */
    public function delete(Request $request, TypeProjet $typeProjet): Response
    {
        if ($this->isCsrfTokenValid('delete'.$typeProjet->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($typeProjet);
            $entityManager->flush();
        }

        return $this->redirectToRoute('type_projet_index');
    }
}
