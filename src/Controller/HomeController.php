<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */

    public function home (){
       // $this->denyAccessUnlessGranted ('Role_admin');
        return $this->render ('commons/home.html.twig');
    }
}