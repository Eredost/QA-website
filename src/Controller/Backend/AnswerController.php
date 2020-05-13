<?php

namespace App\Controller\Backend;

use App\Entity\Answer;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AnswerController
 *
 * @package App\Controller\Backend
 *
 * @Route("/admin/answer",
 *     name="admin_answer_")
 */
class AnswerController extends AbstractController
{
    /**
     * @Route("/{answerId}/toggle",
     *     name="toggle",
     *     requirements={"answerId": "\d+"},
     *     methods={"GET"})
     * @ParamConverter("answer", options={"id": "answerId"})
     * @IsGranted("ROLE_MODERATOR")
     *
     * @param Answer                 $answer
     * @param EntityManagerInterface $manager
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function toggle(Answer $answer, EntityManagerInterface $manager)
    {
        $answer->toggle();
        $manager->flush();

        return $this->redirectToRoute('question_show', [
            'questionId' => $answer->getQuestion()->getId(),
        ]);
    }

    /**
     * @Route("/{answerId}",
     *     name="delete",
     *     requirements={"answerId": "\d+"},
     *     methods={"DELETE"})
     * @ParamConverter("answer", options={"id": "answerId"})
     * @IsGranted("QA_EDIT", subject="answer")
     *
     * @param Answer                 $answer
     * @param EntityManagerInterface $manager
     * @param Request                $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function delete(Answer $answer, EntityManagerInterface $manager, Request $request)
    {
        $token = $request->request->get('token');

        if ($this->isCsrfTokenValid('answer-delete', $token)) {
            $manager->remove($answer);
            $manager->flush();
        }

        return $this->redirectToRoute('question_show', [
            'questionId' => $answer->getQuestion()->getId(),
        ]);
    }
}
