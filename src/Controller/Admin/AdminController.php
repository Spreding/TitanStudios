<?php

namespace App\Controller\Admin;

use App\Entity\Actualite;
use App\Entity\AdminAccess;
use App\Entity\AdminUser;
use App\Entity\Categories;
use App\Entity\CompanyMembers;
use App\Entity\LinksRealisation;
use App\Entity\Realisations;
use App\Entity\Types;
use App\Form\AdminConnexionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/admin/Accueil", name="admin_accueil")
     */
    public function home(): Response
    {
        // $isadmin = $this->entityManager->getRepository(AdminUser::class)->findAll();
        
        // if(count($isadmin) == 0){
        //     $this->denyAccessUnlessGranted('IS_ANONYMOUS');
        // }
        

        return $this->render('admin/menu.html.twig', [
            'position' => 'home'
        ]);
    }



    /**
     * @Route("/admin/Actualité", name="admin_actu")
     */
    public function actu(): Response
    {
        $Actu = $this->entityManager->getRepository(Actualite::class)->findBy([],['id' => 'DESC']);

        return $this->render('admin/actu.html.twig', [
            'Actus' => $Actu,
            'position' => 'actu'
        ]);
    }


    /**
     * @Route("/admin/Réalisations", name="admin_real")
     */
    public function real(): Response
    {


        $Real = $this->entityManager->getRepository(Realisations::class)->findBy([],['id' => 'DESC']);
        $LinkReal = $this->entityManager->getRepository(LinksRealisation::class)->findAll();
        //  dd($Real);
        // dd($LinkReal);

        return $this->render('admin/real.html.twig', [
            'Reals' => $Real,
            'Links' => $LinkReal,
            'position' => 'real'
        ]);
    }


    /**
     * @Route("/admin/Équipe", name="admin_equipe")
     */
    public function equipe(): Response
    {
        $Equipe = $this->entityManager->getRepository(CompanyMembers::class)->findBy([],['id' => 'DESC']);

        return $this->render('admin/equipe.html.twig', [
            'Equipes' => $Equipe,
            'position' => 'equipe'
        ]);
    }

    /**
     * @Route("/admin/Catégories", name="admin_categorie")
     */
    public function categorie(): Response
    {
        $Categories = $this->entityManager->getRepository(Categories::class)->findBy([],['id' => 'DESC']);

        return $this->render('admin/categorie.html.twig', [
            'Categories' => $Categories,
            'position' => 'categorie'
        ]);
    }

    /**
     * @Route("/admin/Types", name="admin_type")
     */
    public function type(): Response
    {
        $Types = $this->entityManager->getRepository(Types::class)->findBy([],['id' => 'DESC']);


        return $this->render('admin/type.html.twig', [
            'Types' => $Types,
            'position' => 'type'
        ]);
    }

    /**
     * @Route("/admin/Access", name="admin_access")
     */
    public function access(): Response
    {
        $AdminAccess = $this->entityManager->getRepository(AdminUser::class)->findBy([],['id' => 'DESC']);

        return $this->render('admin/access.html.twig', [
            'AdminAccess' => $AdminAccess,
            'position' => 'access'
        ]);
    }
    
}
