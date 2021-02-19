<?php

namespace App\Controller;

use App\Entity\Users;
use App\Form\RegistrationFormType;
use App\Form\RegistrationFormTypeSecond;
use App\Service\NavbarHelper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AuthenticateController extends AbstractController
{
    /**
     * @Route("/access/{method}", name="access")
     * @param NavbarHelper $navbarHelper
     * @param AuthenticationUtils $authenticationUtils
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return Response
     */
    public function myAccess(NavbarHelper $navbarHelper, AuthenticationUtils $authenticationUtils
        , Request $request, UserPasswordEncoderInterface $passwordEncoder, $method): Response
    {

        if ($this->getUser()) {
            //The user isn't logged in
            $this->addFlash('error', 'You are already signed in.');
            return $this->redirectToRoute('pets');
        } else {

            $navbar = $navbarHelper->retrieveLoggedOutNav();


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
            } else if ($form->isSubmitted() && !$form->isValid()) {
                $method = "register";
                return $this->render('authenticator/access.html.twig', [
                    'controller_name' => 'BakeryController', 'navbar' => $navbar, 'registrationForm' => $form->createView(),
                    'last_username' => null, 'error' => null, 'method' => $method
                ]);
            }


            $error = $authenticationUtils->getLastAuthenticationError();
            if($error != null) $method = "login";
            // last username entered by the user
            $lastUsername = $authenticationUtils->getLastUsername();


            return $this->render('authenticator/access.html.twig', [
                'controller_name' => 'BakeryController', 'navbar' => $navbar, 'registrationForm' => $form->createView(),
                'last_username' => $lastUsername, 'error' => $error, 'method' => $method
            ]);
        }
    }
}
