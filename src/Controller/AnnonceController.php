<?php

namespace App\Controller;

use App\Entity\Annonces;
use App\Repository\AnnoncesRepository;
use App\Repository\CategoriesRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AnnonceController extends AbstractController
{

    #[Route('/annonce/show/{id}', name: 'annonce')]
    public function annonce($id, AnnoncesRepository $annoncesRepository): Response
    {
        $annonce = $annoncesRepository->find($id);
        return $this->render('annonce/index.html.twig', [    /* essayer cette methode pour afficher les catégories*/
            'annonce' => $annonce   
        ]);
    }

    #[Route('/annonce/add', name: 'annonce_add')]
    public function addAnnonce(ManagerRegistry $doctrine)
    {
       $entityManager = $doctrine->getManager();
       $annonce = new Annonces();
       $annonce->setTitle("AirForce 250");
       $annonce->setContent("Une paire qui va bien vous tenir le pied");
       $annonce->setPrix(96);
       $annonce->setCreatedat(new \DateTimeImmutable());

       $entityManager->persist($annonce);
       $entityManager->flush();
       return new Response("Bravo");
    }

    #[Route('/annonce/delete/{id}', name: 'annonce_delete')]
    public function delete(ManagerRegistry $doctrine, $id)
    {
        $annonce = $doctrine->getRepository(Annonces::class)->find($id);
        $entityManager = $doctrine->getManager();
        $entityManager->remove($annonce);
        $entityManager->flush();

        return $this->redirectToRoute('accueil');
    }
}
    