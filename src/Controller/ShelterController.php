<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PropertyAccess\PropertyAccess;
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
     * @Route("/shelter", name="shelter")
     */
    public function index(): Response
    {
        return $this->render('shelter/home.html.twig', [
            'controller_name' => 'ShelterController',
        ]);
    }
}
