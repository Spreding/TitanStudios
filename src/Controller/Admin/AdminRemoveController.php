<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminRemoveController extends AbstractController
{
    /**
     * @Route("/admin/remove", name="admin_remove")
     */
    public function index(): Response
    {
        return $this->render('admin_remove/index.html.twig', [
            'controller_name' => 'AdminRemoveController',
        ]);
    }
}
