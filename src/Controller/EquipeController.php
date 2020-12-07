<?php

namespace App\Controller;

use App\Entity\CompanyMembers;
use App\Entity\Realisations;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EquipeController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/équipe", name="equipe")
     */
    public function index(): Response
    {
        $realisationsHighlight = $this->entityManager->getRepository(Realisations::class)->findRealisationsHighlighted();
        $equipes = $this->entityManager->getRepository(CompanyMembers::class)->findAll();
        
        return $this->render('equipe/index.html.twig', [
            'highlight' => $realisationsHighlight,
            'equipes' => $equipes,
        ]);
    }
}
