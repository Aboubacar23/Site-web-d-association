<?php

namespace App\Controller;

use App\Entity\NewsLetter;
use App\Form\NewsLetterType;
use App\Repository\NewsLetterRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/news/letter")
 */
class NewsLetterController extends AbstractController
{
    /**
     * @Route("/", name="news_letter_index", methods={"GET"})
     */
    public function index(NewsLetterRepository $newsLetterRepository): Response
    {
        return $this->render('news_letter/index.html.twig', [
            'news_letters' => $newsLetterRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="news_letter_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $newsLetter = new NewsLetter();
        $form = $this->createForm(NewsLetterType::class, $newsLetter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($newsLetter);
            $entityManager->flush();
 
            return $this->redirectToRoute('news_letter_index');
        }

        return $this->render('news_letter/new.html.twig', [
            'news_letter' => $newsLetter,
            'form' => $form->createView(),
        ]); 
    }

    /**
     * @Route("/{id}", name="news_letter_show", methods={"GET"})
     */
    public function show(NewsLetter $newsLetter): Response
    {
        return $this->render('news_letter/show.html.twig', [
            'news_letter' => $newsLetter,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="news_letter_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, NewsLetter $newsLetter): Response
    {
        $form = $this->createForm(NewsLetterType::class, $newsLetter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('news_letter_index');
        }

        return $this->render('news_letter/edit.html.twig', [
            'news_letter' => $newsLetter,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="news_letter_delete", methods={"DELETE"})
     */
    public function delete(Request $request, NewsLetter $newsLetter): Response
    {
        if ($this->isCsrfTokenValid('delete'.$newsLetter->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($newsLetter);
            $entityManager->flush();
        }

        return $this->redirectToRoute('news_letter_index');
    }
}
