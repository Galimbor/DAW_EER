<?php


namespace App\Service;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class NavbarHelper extends AbstractController
{

    //Pets

    public function retrieveLoggedInNav(): array
    {
        $navbar = array();
        $navbar['menu1'] = "Dogs";
        $navbar['menu1link'] = 'href="' . $this->generateUrl('pets', array('id' => 1)). '"';

        $navbar['menu2'] = "Cats";
        $navbar['menu2link'] = 'href="' . $this->generateUrl('pets', array('id'=> 2)). '"';

        $navbar['menu3'] = "My adoptions";
        $navbar['menu3link'] = ' href="' . $this->generateUrl('myAdoptions'). '"';

        $navbar['menu4'] = "Logout";
        $navbar['menu4link'] = 'href="' . $this->generateUrl('app_logout'). '"';

        $navbar['menu5'] = "";
        $navbar['menu5link'] = '';

        return $navbar;
    }


    public function retrieveLoggedOutNav(): array
    {
        $navbar = array();

        $navbar['menu1'] = "Dogs";
        $navbar['menu1link'] = 'href="' . $this->generateUrl('pets', array('id' => 1)). '"';

        $navbar['menu2'] = "Cats";
        $navbar['menu2link'] = 'href="' . $this->generateUrl('pets', array('id'=>2)). '"';


        $navbar['menu3'] = "Login";
        $navbar['menu3link'] = 'href="' . $this->generateUrl('access'). '"';

        $navbar['menu4'] = "Register";
        $navbar['menu4link'] = 'href="' . $this->generateUrl('access'). '"';

        $navbar['menu5'] = "";
        $navbar['menu5link'] = '';


        return $navbar;
    }



}