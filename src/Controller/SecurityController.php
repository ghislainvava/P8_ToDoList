<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
  
    #[Route('/login', name:"login", methods: ['GET', 'POST'])] 
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastusername();
        if ($this->getUser()) {
            return $this->redirectToRoute(route: 'home');
        }
        return $this->render('security/login.html.twig', [
            'last_username'=> $lastUsername,
            'error'        => $error,
        ]);
    }

    #[Route("/login_check", name:"login_check")]
    public function loginCheck()
    {
        // This code is never executed.
    }

    #[Route("/logout", name:"logout")]
    public function logoutCheck()
    {
        // This code is never executed.
    }
}
