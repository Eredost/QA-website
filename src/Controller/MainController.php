<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/",
     *     methods={"GET"},
     *     name="home")
     */
    public function home()
    {
        return $this->render('frontend/main/index.html.twig');
    }
}
