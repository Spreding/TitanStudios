<?php

namespace App\Controller;

use App\Entity\LinksRealisation;
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
        $realisations = $this->entityManager->getRepository(Realisations::class)->findBy([], ['id' => 'DESC']);
        

        return $this->render('realisations/index.html.twig', [
            'highlight' => $realisationsHighlight,
            'reals' => $realisations,
        ]);
    }

    /**
     * @Route("/réalisations/{slug}", name="realisation")
     */
    public function realiation($slug): Response
    {
        $realisationsHighlight = $this->entityManager->getRepository(Realisations::class)->findRealisationsHighlighted();
        $realisation = $this->entityManager->getRepository(Realisations::class)->findOneBySlug($slug);
        if(!$realisation){
            return $this->redirectToRoute('realisations');
        }
        $links = $this->entityManager->getRepository(LinksRealisation::class)->findByRealisation($realisation);

        return $this->render('realisations/realisation.html.twig',[
            'highlight' => $realisationsHighlight,
            'real' => $realisation,
            'links' => $links,
        ]);
    }
}
