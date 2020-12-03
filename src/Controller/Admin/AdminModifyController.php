<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminModifyController extends AbstractController
{
    /**
     * @Route("/admin/modify", name="admin_modify")
     */
    public function index(): Response
    {
        return $this->render('admin_modify/index.html.twig', [
            'controller_name' => 'AdminModifyController',
        ]);
    }
}
