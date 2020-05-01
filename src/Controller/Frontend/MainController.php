<?php

namespace App\Controller\Frontend;

use App\Form\ContactType;
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
        $questions = $questionRepository->findAllQuestionsWithTags($request);

        if ($request->query->get('page') > $questions->lastPage) {

            throw new NotFoundHttpException('The page you are looking for, didn\'t exist');
        }

        return $this->render('frontend/main/index.html.twig', [
            'questions' => $questions,
        ]);
    }

    /**
     * @Route("/legal-mentions",
     *     name="legalMentions",
     *     methods={"GET"})
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function legalMentions()
    {
        return $this->render('frontend/main/legalMentions.html.twig');
    }

    /**
     * @Route("/about",
     *     name="about",
     *     methods={"GET"})
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function about()
    {
        return $this->render('frontend/main/about.html.twig');
    }

    /**
     * @Route("/contact-us",
     *     name="contactUs",
     *     methods={"GET", "POST"})
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function contactUs(Request $request)
    {
        $contactForm = $this->createForm(ContactType::class);
        $contactForm->handleRequest($request);

        if ($contactForm->isSubmitted() && $contactForm->isValid()) {
            // TODO: implement form submit
            die;
        }

        return $this->render('frontend/main/contactUs.html.twig', [
            'contactForm' => $contactForm->createView(),
        ]);
    }
}
