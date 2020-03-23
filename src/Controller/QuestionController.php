<?php

namespace App\Controller;

use App\Repository\AnswerRepository;
use App\Repository\QuestionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/question",
 *     name="question_")
 *
 * Class QuestionController
 *
 * @package App\Controller
 */
class QuestionController extends AbstractController
{
    /**
     * @Route("/{questionId}",
     *     name="show",
     *     requirements={"questionId"="\d+"})
     *
     * @param Question $question
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function show(QuestionRepository $questionRepository, AnswerRepository $answerRepository, $questionId)
    {
        $question = $questionRepository->findQuestionById($questionId);

        if (is_null($question)) {

            throw new NotFoundHttpException('The page you are looking for, didn\'t exist');
        }

        $answers = $answerRepository->findAllAnswersByQuestionId($question);

        return $this->render('frontend/question/show.html.twig', [
            'question' => $question,
            'answers'  => $answers,
        ]);
    }
}
