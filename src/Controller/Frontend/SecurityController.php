<?php

namespace App\Controller\Frontend;

use App\Entity\User;
use App\Form\RegisterType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login",
     *     name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('home');
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('frontend/security/login.html.twig', [
            'last_username' => $lastUsername,
            'error'         => $error
        ]);
    }

    /**
     * @Route("/register",
     *     name="app_register",
     *     methods={"GET", "POST"})
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function register(Request $request)
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('home');
        }

        $newUser = new User();
        $registerForm = $this->createForm(RegisterType::class, $newUser);
        $registerForm->handleRequest($request);

        if ($registerForm->isSubmitted() && $registerForm->isValid())
        {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($newUser);
            $manager->flush();

            $this->addFlash(
                'success',
                'Your account has been successfully created!'
            );

            return $this->redirectToRoute('app_login');
        }

        return $this->render('frontend/security/register.html.twig', [
            'registerForm' => $registerForm->createView(),
        ]);
    }

    /**
     * @Route("/logout",
     *     name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
