<?php

namespace App\Controller;

use App\Repository\AnnoncesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'accueil')]
    public function index(AnnoncesRepository $annoncesRepository)
    {
        $liste_annonces = $annoncesRepository->findAll();
        return $this->render('home/index.html.twig', [
            'annonces' => $liste_annonces
        ]);
    }
    
}
