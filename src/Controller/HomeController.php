<?php

namespace App\Controller;

use App\Entity\Actualite;
use App\Entity\Realisations;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    /**
     * @Route("/", name="home")
     */
    public function index(Request $request): Response
    {
         $realisationsHighlight = $this->entityManager->getRepository(Realisations::class)->findRealisationsHighlighted();

         $actus = $this->entityManager->getRepository(Actualite::class)->findAll();
        //  dd($request->query->get('id'));
        // dd($realisationsHighlight);
        return $this->render('home/index.html.twig',[
            'highlight' => $realisationsHighlight,
            'actus' => $actus,
        ]);
    }


    /**
     * @Route("/actualité/{slug}", name="actualite")
     */
    public function actualite($slug): Response
    {
        $realisationsHighlight = $this->entityManager->getRepository(Realisations::class)->findRealisationsHighlighted();
        $actualite = $this->entityManager->getRepository(Actualite::class)->findOneBySlug($slug);

        if(!$actualite){
            return $this->redirectToRoute('home');
        }

        return $this->render('home/actu.html.twig', [
            'highlight' => $realisationsHighlight,
            'actu' =>$actualite,
        ]);
    }
}
