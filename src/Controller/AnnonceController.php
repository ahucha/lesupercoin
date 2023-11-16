<?php

namespace App\Controller;

use App\Entity\Annonces;
use App\Repository\AnnoncesRepository;
use App\Repository\CategoriesRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\FormAnnonceType;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;

class AnnonceController extends AbstractController
{

    #[Route('/annonce/show/{id}', name: 'annonce')]
    public function annonce($id, AnnoncesRepository $annoncesRepository): Response
    {
        $annonce = $annoncesRepository->find($id);
        return $this->render('annonce/index.html.twig', [ 
            'annonce' => $annonce   
        ]);
    }

    #[Route('/annonce/add', name: 'formAnnonce')]
    public function addAnnonce(ManagerRegistry $doctrine ,Request $request)
    {
        $entityManager = $doctrine->getManager();
        $annonce = new Annonces();
        $annonce->setCreatedat(new \DateTimeImmutable());
        $formAnnonce = $this->createForm(FormAnnonceType::class, $annonce);
        $formAnnonce->handleRequest($request);

        if($formAnnonce->isSubmitted() && $formAnnonce->isValid())
        {
            $entityManager->persist($annonce);
            $entityManager->flush();

            return $this->redirectToRoute('accueil');
        }
       return $this->render('/annonce/formAnnonce.html.twig',[
        'formAnnonce' => $formAnnonce->createView()
       ]);
    }

    #[Route('/annonce/modif/{id}', name:'annonce_modif')]
    public function modifAnnonce(ManagerRegistry $doctrine, Request $request, $id)
    {
        $entityManager = $doctrine->getManager();
        $annonce = $doctrine->getRepository(Annonces::class)->find($id);
        $annonce->setUpdatedat(new \DateTimeImmutable());
        $formAnnonce = $this->createForm(FormAnnonceType::class, $annonce);
        
        $formAnnonce->handleRequest($request);
        if($formAnnonce->isSubmitted() && $formAnnonce->isValid())
        {
            $entityManager->flush();

            return $this->redirectToRoute('accueil');
        }
       return $this->render('/annonce/formModifAnnonce.html.twig',[
        'formAnnonce' => $formAnnonce->createView()
       ]);
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
    