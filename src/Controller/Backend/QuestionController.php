<?php

namespace App\Controller\Backend;

use App\Entity\Question;
use App\Form\QuestionType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class QuestionController
 *
 * @package App\Controller\Backend
 *
 * @Route("/admin/question",
 *     name="admin_question_")
 */
class QuestionController extends AbstractController
{
    /**
     * @Route("/{questionId}/toggle",
     *     name="toggle",
     *     requirements={"questionId": "\d+"},
     *     methods={"GET"})
     * @ParamConverter("question", options={"id" = "questionId"})
     * @IsGranted("ROLE_MODERATOR")
     *
     * @param Question               $question
     * @param EntityManagerInterface $manager
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function toggle(Question $question, EntityManagerInterface $manager)
    {
        $question->toggle();
        $manager->flush();

        $this->addFlash(
            'success',
            'The question has been successfully ' . ($question->getIsEnable() ? 'enabled': 'disabled')
        );

        return $this->redirectToRoute('question_show', [
            'questionId' => $question->getId(),
        ]);
    }

    /**
     * @Route("/{questionId}",
     *     name="delete",
     *     requirements={"questionId": "\d+"},
     *     methods={"DELETE"})
     * @ParamConverter("question", options={"id": "questionId"})
     * @IsGranted("QA_EDIT", subject="question")
     *
     * @param Question               $question
     * @param EntityManagerInterface $manager
     * @param Request                $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function delete(Question $question, EntityManagerInterface $manager, Request $request)
    {
        $token = $request->request->get('token');

        if ($this->isCsrfTokenValid('question-delete', $token)) {
            $manager->remove($question);
            $manager->flush();

            $this->addFlash(
                'success',
                'The question has been successfully deleted'
            );
        }

        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/new",
     *     name="new",
     *     methods={"GET", "POST"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function new(Request $request)
    {
        $newQuestion = new Question();
        $newQuestionForm = $this->createForm(QuestionType::class, $newQuestion);
        $newQuestionForm->handleRequest($request);

        if ($newQuestionForm->isSubmitted() && $newQuestionForm->isValid()) {

            // TODO: handle form submit
        }

        return $this->render('backend/admin/question/new.html.twig', [
            'newQuestionForm' => $newQuestionForm->createView(),
        ]);
    }
}
