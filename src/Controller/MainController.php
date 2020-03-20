<?php

namespace App\Controller;

use App\Repository\QuestionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/",
     *     methods={"GET"},
     *     name="home")
     */
    public function home(QuestionRepository $questionRepository, Request $request)
    {
        $page = $request->query->get('page', 1);
        $questions = $questionRepository->findAllQuestionsWithTags($page, 10);

        return $this->render('frontend/main/index.html.twig', [
            'questions' => $questions,
        ]);
    }
}
