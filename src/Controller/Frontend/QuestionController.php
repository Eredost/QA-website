<?php

namespace App\Controller\Frontend;

use App\Entity\Answer;
use App\Form\AnswerType;
use App\Repository\QuestionRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class QuestionController
 *
 * @package App\Controller
 *
 * @Route("/question",
 *     name="question_")
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

        if ($currentPage > $answers->lastPage && 0 != $answers->lastPage) {

            throw new NotFoundHttpException('The page you are looking for, didn\'t exist');
        }

        $newAnswer = new Answer();
        $answerForm = $this->createForm(AnswerType::class, $newAnswer);
        $answerForm->handleRequest($request);

        if ($answerForm->isSubmitted() && $answerForm->isValid() && $this->isGranted('IS_AUTHENTICATED_FULLY')) {

            $newAnswer->setUser($this->getUser())
                ->setQuestion($question)
            ;

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($newAnswer);
            $entityManager->flush();

            $this->addFlash(
                'success',
                'Your answer has been successfully added'
            );

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
