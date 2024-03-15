<?php

// On déclare le namespace de la classe
namespace App\Controller;

// On inclut les classes dont on a besoin
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

// On declare la classe HomepageController
class HomepageController extends AbstractController
{
    // On declare la fonction index
    // le # sert a dire qu'il n'y a pas de params : c'est l'attribut name de la route
    #[Route('/', name: 'app_home',methods:['GET'])]
    public function index(): Response
    {
        session_start();
        $_SESSION['cookie'] = true;
        return $this->render('homepage/index.html.twig', [
                                                            'controller_name' => 'HomepageController',
                                                            'cookie' => $_SESSION['cookie']
                                                        ]);
    }
    #[Route('/home', name: 'app_homepage_alt',methods:['GET'])]
    #[Route('/homepage', name: 'app_homepage',methods:['GET'])]
    public function homepage(): RedirectResponse
    {
        return $this->redirectToRoute('app_home');
    }
}
