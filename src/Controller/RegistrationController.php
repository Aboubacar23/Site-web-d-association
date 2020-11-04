<?php

namespace App\Controller;

use App\Entity\Admin;
use App\Form\RegistrationFormType;
use App\Repository\AdminRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="app_register")
     * 
     * @IsGranted("ROLE_ADMIN")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = new Admin();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $photo = $form->get('Photo')->getData();

            if($photo)
            {
                $originalPhoto =pathinfo($photo->getClientOriginalName(),PATHINFO_FILENAME);
                $phototName = $originalPhoto;
                $newPhoto = $phototName.'.'.uniqid().'.'.$photo->guessExtension();
                try {
                    $photo->move(
                        $this->getParameter('photo_admin'),
                        $newPhoto
                    );
                } catch (\Throwable $th) {
                    //throw $th;
                }
            }
            $this->addFlash('success', 'le membre à été ajouter avec succes');
            $user->setPhoto($newPhoto);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $this->redirectToRoute('register_index');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    //afficher les admin

     /**
     * @Route("/register_index", name="register_index", methods={"GET"})
     * 
     */
    public function index(AdminRepository $adminRepository): Response
    {
        return $this->render('registration/index.html.twig', [
            'admins' => $adminRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id}", name="register_show", methods={"GET"})
     */
    public function show(Admin $admin): Response
    {
        return $this->render('registration/show.html.twig', [
            'admin' => $admin,
        ]);
    }

 
     /**
     * @Route("/{id}", name="register_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Admin $admin): Response
    {
        if ($this->isCsrfTokenValid('delete'.$admin->getId(), $request->request->get('_token'))) {      
           
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($admin);
            $entityManager->flush();
        }

        return $this->redirectToRoute('register_index');
    }
}
