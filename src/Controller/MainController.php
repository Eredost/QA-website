<?php

namespace App\Controller;

use App\Repository\QuestionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/",
     *     methods={"GET"},
     *     name="home")
     *
     * @param QuestionRepository $questionRepository
     * @param Request            $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function home(QuestionRepository $questionRepository, Request $request)
    {
        $currentPage = $request->query->get('page', 1);
        if (!preg_match('/\d+/', $currentPage)
            || $currentPage < 1) {
            $currentPage = 1;
        }

        $questions = $questionRepository->findAllQuestionsWithTags($currentPage, 10);
        $questions->lastPage = intval(ceil($questions->count() / 10));
        $questions->currentPage = intval($currentPage);

        if ($currentPage > $questions->lastPage) {

            throw new NotFoundHttpException('The page you are looking for, didn\'t exist');
        }

        return $this->render('frontend/main/index.html.twig', [
            'questions' => $questions,
        ]);
    }
}
