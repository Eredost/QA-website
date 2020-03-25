<?php

namespace App\Controller;

use App\Entity\Answer;
use App\Repository\QuestionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
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
     * @param QuestionRepository $questionRepository
     * @param Request            $request
     * @param int                $questionId
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function show(QuestionRepository $questionRepository, Request $request, int $questionId)
    {
        $currentPage = $request->query->get('page', 1);
        $question = $questionRepository->findQuestionById($questionId);

        if (is_null($question) || !preg_match('/\d+/', $currentPage)) {

            throw new NotFoundHttpException('The page you are looking for, didn\'t exist');
        }

        $answers = $this->getDoctrine()
            ->getRepository(Answer::class)
            ->findAllAnswersByQuestionId($question, $currentPage, 7)
        ;

        if ($currentPage > $answers->lastPage) {

            throw new NotFoundHttpException('The page you are looking for, didn\'t exist');
        }

        return $this->render('frontend/question/show.html.twig', [
            'question' => $question,
            'answers'  => $answers,
        ]);
    }
}
