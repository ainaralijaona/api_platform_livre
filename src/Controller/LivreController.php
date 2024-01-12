<?php

namespace App\Controller;

use App\Entity\Livre;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class LivreController extends AbstractController
{
    /**
     * @Route("/livres/sorted", name="livres_sorted", methods={"GET"})
     */
    public function getLivresSorted(EntityManagerInterface $entityManager, Request $request): JsonResponse
    {
        $tri = $request->query->get('tri', 'titre'); // Par défaut, tri par titre

        $livresRepository = $entityManager->getRepository(Livre::class);
        $livres = $livresRepository->findBy([], [$tri => 'ASC']);

        return $this->json(['livres' => $livres]);
    }

    public function getLivresByAuteur(EntityManagerInterface $entityManager, Request $request): JsonResponse
    {
        $auteur = $request->query->get('auteur');

        if (!$auteur) {
            return $this->json(['message' => 'Le paramètre "auteur" est requis.'], 400);
        }

        $livresRepository = $entityManager->getRepository(Livre::class);
        $livres = $livresRepository->findBy(['auteur' => $auteur]);

        return $this->json(['livres' => $livres]);
    }
}
