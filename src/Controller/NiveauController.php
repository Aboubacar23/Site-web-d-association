<?php

namespace App\Controller;

use App\Entity\Niveau;
use App\Form\NiveauType;
use App\Repository\NiveauRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/niveau")
 * @IsGranted("ROLE_USER")
 */
class NiveauController extends AbstractController
{
    /**
     * @Route("/", name="niveau_index", methods={"GET"})
     */
    public function index(NiveauRepository $niveauRepository, Request $request, PaginatorInterface $paginatorInterface): Response
    {
        $donnes = $niveauRepository->findAll();

        $niveau = $paginatorInterface->paginate(
            $donnes,
            $request->query->getInt('page',1),
            5
        );
        return $this->render('niveau/index.html.twig', [
            'niveaux' => $niveau,
        ]);
    }

    /**
     * @Route("/new", name="niveau_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $niveau = new Niveau();
        $form = $this->createForm(NiveauType::class, $niveau);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->addFlash('success', 'le niveau à été ajouter avec succes');
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($niveau);
            $entityManager->flush();

            return $this->redirectToRoute('niveau_index');
        }

        return $this->render('niveau/new.html.twig', [
            'niveau' => $niveau,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="niveau_show", methods={"GET"})
     */
    public function show(Niveau $niveau): Response
    {
        return $this->render('niveau/show.html.twig', [
            'niveau' => $niveau,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="niveau_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Niveau $niveau): Response
    {
        $form = $this->createForm(NiveauType::class, $niveau);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('niveau_index');
        }

        return $this->render('niveau/edit.html.twig', [
            'niveau' => $niveau,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="niveau_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Niveau $niveau): Response
    {
        if ($this->isCsrfTokenValid('delete'.$niveau->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($niveau);
            $entityManager->flush();
        }

        return $this->redirectToRoute('niveau_index');
    }
}
