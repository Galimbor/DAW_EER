<?php

namespace App\Controller;

use App\Entity\Users;
use App\Form\RegistrationFormType;
use App\Form\RegistrationFormTypeSecond;
use App\Repository\ProductsRepository;
use App\Service\Cart;
use App\Service\NavbarHelper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/register2", name="app_register2")
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param NavbarHelper $navbarHelper
     * @return Response
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, NavbarHelper $navbarHelper) : Response
    {
        if($this->getUser())
        {
            $this->addFlash('error', 'You are already signed in.');
            return $this->redirectToRoute('pets');
        }
        $user = new Users();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // encode the plain password
            $user->setPasswordDigest(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $user->setCreatedAt(date("Y-m-d H:i:s"));
            $user->setUpdatedAt(date("Y-m-d H:i:s"));
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email
            $this->addFlash('success', 'You have registered with success!');
            return $this->redirectToRoute('pets');
        }

        $navbar = $navbarHelper->retrieveLoggedOutNav();

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(), 'navbar' => $navbar
        ]);
    }
}
