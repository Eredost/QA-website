<?php

namespace App\Controller;

use App\Entity\Answer;
use App\Form\AnswerType;
use App\Repository\QuestionRepository;
use App\Repository\UserRepository;
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
     *     requirements={"questionId"="\d+"},
     *     methods={"GET", "POST"})
     *
     * @param QuestionRepository $questionRepository
     * @param Request            $request
     * @param int                $questionId
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function show(UserRepository $userRepository, QuestionRepository $questionRepository, Request $request, int $questionId)
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

        if ($currentPage > $answers->lastPage && 0 != $answers->lastPage) {

            throw new NotFoundHttpException('The page you are looking for, didn\'t exist');
        }

        // FIXME: delete $user after implementing connection feature
        $newAnswer = new Answer();
        $user = $userRepository->findAll();
        $newAnswer->setUser($user[0]);
        $newAnswer->setQuestion($question);
        $answerForm = $this->createForm(AnswerType::class, $newAnswer);
        $answerForm->handleRequest($request);

        if ($answerForm->isSubmitted() && $answerForm->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($newAnswer);
            $entityManager->flush();

            return $this->redirectToRoute('question_show', [
                'questionId' => $question->getId(),
            ]);
        }

        return $this->render('frontend/question/show.html.twig', [
            'question'   => $question,
            'answers'    => $answers,
            'answerForm' => $answerForm->createView(),
        ]);
    }
}
