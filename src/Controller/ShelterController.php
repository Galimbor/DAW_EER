<?php

namespace App\Controller;

use App\Entity\Adoptions;
use App\Entity\Users;
use App\Form\RegistrationFormTypeSecond;
use App\Repository\AdoptionsRepository;
use App\Repository\PetcategoriesRepository;
use App\Repository\PetsRepository;
use App\Service\NavbarHelper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use App\Controller\Shelter_modelController;

class ShelterController extends AbstractController
{
    
	private $session;
	private $shelter_model;
	private $validator;
	
	public function __construct(SessionInterface $session, Shelter_modelController $shelter_model, ValidatorInterface $validator)
    {
		$this->session = $session;
		$this->shelter_model = $shelter_model;
        $this->validator = $validator;
    }


    /**
     * @Route("/shelter", name="animalShelter")
     */
    public function index(): Response
    {
        return $this->render('shelter/index.html.twig', [
            'controller_name' => 'AnimalShelterController',
        ]);
    }

    /**
     * @Route("/animalShelter/pets{id?}", name="pets")
     */
    public function pets(PetsRepository $petsRepository, NavbarHelper $navbarHelper, $id, PetcategoriesRepository $petcategoriesRepository): Response
    {

        if (!$this->getUser()) {
            //The user isn't logged in
            $navbar = $navbarHelper->retrieveLoggedOutNav();
        } else {
            //The user is logged in
            $navbar = $navbarHelper->retrieveLoggedInNav();
        }

        if($id && $petcategoriesRepository->find($id) )
        {
            $pets = $petsRepository->findBy(array('cat' => $id, 'status' => 0));
            $title = $id == 1 ? "My Dogs" : "My Cats";
        }
        else if(!isset($id)){
            $pets = $petsRepository->findBy(array('status' => 0));
            $title = "My Pets";
        }
        else{
            $this->addFlash('error', 'Something went wrong! Please try again.');
            return $this->redirectToRoute('pets');
        }

        return $this->render('shelter/pets.html.twig', [
            'controller_name' => 'AnimalShelterController', 'pets' => $pets, 'navbar' => $navbar,
            'title' => $title
        ]);
    }



    /**
     * @Route("/adopt/{id?}", name="adopt")
     */
    public function adopt(NavbarHelper $navbarHelper, AdoptionsRepository $adoptionsRepository, $id, PetsRepository $petsRepository): Response
    {

        if (!$this->getUser()) {
            //The user isn't logged in
            $this->addFlash('error', 'You need to be signed in.');
            return $this->redirectToRoute('pets');
        }
        else if($adoptionsRepository->findBy(array('petlover' => $this->getUser()->getId(), 'pet' => $id))){
            $this->addFlash('error', 'You have already adopted this animal.');
            return $this->redirectToRoute('pets');
        }
        else if($adoptionsRepository->findBy(array('pet' => $id)) )
        {
            $this->addFlash('error', 'This animal was already adopted.');
            return $this->redirectToRoute('pets');
        }
        else {
            //The user is logged in
            if ($id and $petsRepository->find($id)) {
                $adoption = new Adoptions();
                $adoption->setPetlover($this->getUser());
                $adoption->setCreatedAt(new \DateTime('now'));
                $adoption->setPet($petsRepository->find($id));
                $petsRepository->find($id)->setStatus(1);
                //Inserting new Adoption in the database.
                $em = $this->getDoctrine()->getManager();
                $em->persist($adoption);
                $em->flush();

                $this->addFlash('success', 'Adoption successfully completed. Thank you.');
                return $this->redirectToRoute('pets');
            } else {
                $this->addFlash('error', 'Something went wrong!Please try again.');
                return $this->redirectToRoute('pets');
            }
        }
    }


    /**
     * @Route("/MyAdoptions", name="myAdoptions")
     */
    public function myEnrolls(NavbarHelper $navbarHelper, AdoptionsRepository  $adoptionsRepository): Response
    {

        if (!$this->getUser()) {
            //The user isn't logged in
            $this->addFlash('error', 'You need to be signed in.');
            return $this->redirectToRoute('pets');
        } else {

            $navbar = $navbarHelper->retrieveLoggedInNav();
            $adoptions = $adoptionsRepository->findBy(array('petlover' => $this->getUser()->getId()));

            return $this->render('shelter/mypets.html.twig', [
                'controller_name' => 'BakeryController', 'navbar' => $navbar, 'adoptions' => $adoptions
            ]);
        }
    }





}
