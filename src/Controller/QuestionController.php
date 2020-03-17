<?php

namespace App\Controller;

use App\Entity\Question;
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
     * @Route("/{id}",
     *     name="show",
     *     requirements={"id"="\d+"})
     *
     * @param Question $question
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function show(Question $question)
    {
        return $this->render('frontend/question/index.html.twig', [
            'question' => $question,
        ]);
    }
}
