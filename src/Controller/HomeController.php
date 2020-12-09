<?php

namespace App\Controller;

use App\Entity\Actualite;
use App\Entity\Realisations;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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

        $nbElemMax = 4;
        $actusToShow = $this->entityManager->getRepository(Actualite::class)->findBy([], ['id'=>'DESC'], $nbElemMax);

         
         
    if ($request->isXmlHttpRequest()){
        $jsonData =  array();

        $firstactu = $this->entityManager->getRepository(Actualite::class)->findBy([], ['id'=>'ASC'], 1);
         $search = $request->request->all();

        $offset = $search['data'] * $nbElemMax;
        $actusToAdd = $this->entityManager->getRepository(Actualite::class)->findBy([], ['id'=>'DESC'], $nbElemMax, $offset);

        $canFetchMore = in_array($firstactu[0], $actusToAdd);
          for ($i=0; $i < count($actusToAdd); $i++) { 
            $temp = array(
                'title' => $actusToAdd[$i]->getTitle(),
                'description' => $actusToAdd[$i]->getdescription(),
                'image' => $actusToAdd[$i]->getImage(),
                'slug' => $actusToAdd[$i]->getSlug(),
                'last' => $canFetchMore,
            );

            $jsonData[$i] = $temp;
          } 
          
          
        return new JsonResponse($jsonData);
    }

        return $this->render('home/index.html.twig',[
            'highlight' => $realisationsHighlight,
            'actus' => $actusToShow,
        ]);
    }


    /**
     * @Route("/actualite/{slug}", name="actualite")
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
