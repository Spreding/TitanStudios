<?php

namespace App\Controller;

use App\Form\AdminConnexionType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(Request $request): Response
    {
        $form = $this->createForm(AdminConnexionType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

        }
        if(true){
            return $this->redirectToRoute('admin_menu');
        }
        
        return $this->render('admin/index.html.twig', [
            'form' => $form->createView(),
        ]);
        
    }


    /**
     * @Route("/admin/menu", name="admin_menu")
     */
    public function menu(): Response
    {
        // dd("here");
        return $this->render('admin/menu.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
}
