<?php

namespace App\Controller;

use App\Repository\QuestionRepository;
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
    public function home(QuestionRepository $questionRepository)
    {
        $questions = $questionRepository->findAll();

        return $this->render('frontend/main/index.html.twig', [
            'questions' => $questions,
        ]);
    }
}
