<?php

namespace App\Controller;

use App\Entity\Realisations;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RealisationsController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/réalisations", name="realisations")
     */
    public function index(): Response
    { 
        $realisationsHighlight = $this->entityManager->getRepository(Realisations::class)->findRealisationsHighlighted();

        return $this->render('realisations/index.html.twig', [
            'highlight' => $realisationsHighlight,
        ]);
    }

    /**
     * @Route("/réalisations/{slug}", name="realisation")
     */
    public function realiation($slug): Response
    {
        $realisationsHighlight = $this->entityManager->getRepository(Realisations::class)->findRealisationsHighlighted();

        return $this->render('realisations/realiastion.html.twig',[
            'highlight' => $realisationsHighlight,
        ]);
    }
}
