<?php

namespace App\Controller\Admin;

use App\Entity\Actualite;
use App\Entity\AdminUser;
use App\Entity\Categories;
use App\Entity\CompanyMembers;
use App\Entity\LinksRealisation;
use App\Entity\Realisations;
use App\Entity\Types;
use App\Form\DeleteEntityAdminType;
use Doctrine\ORM\EntityManagerInterface;
use PhpParser\Node\Scalar\MagicConst\File;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminRemoveController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/admin/Actualite/Suppression/{id}", name="admin_suppr_actu")
     */
    public function supprActu(Request $request, $id): Response
    {
        $ActuRef = $this->entityManager->getRepository(Actualite::class)->findOneById($id);

        if(!$ActuRef){
            return $this->redirectToRoute('admin_actu');
        }

        $form = $this->createForm(DeleteEntityAdminType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $Actu = $form->getData();
            // dd($form->get('checkBox')->getdata());
            if($form->get('checkBox')->getdata()){
                $filesystem = new Filesystem();
                // dd('public/uploads/'.$ActuRef->getImage());
            // dd();
            if($filesystem->exists('uploads/'.$ActuRef->getImage())){
                $filesystem->remove(['uploads/'.$ActuRef->getImage()]);
                
            }
            $this->entityManager->remove($ActuRef);
            $this->entityManager->flush();

            return $this->redirectToRoute("admin_actu");

                
            }
            

             
        }

        return $this->render('admin_remove/actu.html.twig', [
            'position' => 'actu',
            'actu' => $ActuRef,
            'form' => $form->createView(),
            
        ]);
    }

    /**
     * @Route("/admin/Realisation/Suppression/{id}", name="admin_suppr_real")
     */
    public function supprReal(Request $request, $id): Response
    {
        $RealRef = $this->entityManager->getRepository(Realisations::class)->findOneById($id);
        $links = $this->entityManager->getRepository(LinksRealisation::class)->findByRealisation($RealRef->getId());

        if(!$RealRef){
            return $this->redirectToRoute('admin_real');
        }

        $form = $this->createForm(DeleteEntityAdminType::class);

        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){

           
            if($form->get('checkBox')->getdata()){

                $filesystem = new Filesystem();
                
                    if($filesystem->exists('uploads/'.$RealRef->getImage1())){
                        $filesystem->remove(['uploads/'.$RealRef->getImage1()]); 
                    }
                    if($filesystem->exists('uploads/'.$RealRef->getImage2())){
                        $filesystem->remove(['uploads/'.$RealRef->getImage2()]); 
                    }
                    if($filesystem->exists('uploads/'.$RealRef->getImage3())){
                        $filesystem->remove(['uploads/'.$RealRef->getImage3()]); 
                    }
                    if($filesystem->exists('uploads/'.$RealRef->getImage4())){
                        $filesystem->remove(['uploads/'.$RealRef->getImage4()]); 
                    }
                
                
                $this->entityManager->remove($RealRef);
                foreach ($links as $link) {
                    $this->entityManager->remove($link);
                }
                
                $this->entityManager->flush();

                return $this->redirectToRoute("admin_real");
            }

        }

        return $this->render('admin_remove/real.html.twig', [
            'position' => 'real',
            'real' => $RealRef,
            'links' => $links,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/Types/Suppression/{id}", name="admin_suppr_type")
     */
    public function supprType(Request $request, $id): Response
    {
        $TypeRef = $this->entityManager->getRepository(Types::class)->findOneById($id);

        if(!$TypeRef){
            return $this->redirectToRoute('admin_type');
        }

        $form = $this->createForm(DeleteEntityAdminType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            if($form->get('checkBox')->getdata()){

                $this->entityManager->remove($TypeRef);
                $this->entityManager->flush();

                return $this->redirectToRoute("admin_type");
            }
        }
        return $this->render('admin_remove/type.html.twig', [
            'position' => 'type',
            'type' => $TypeRef,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/Categories/Suppression/{id}", name="admin_suppr_categorie")
     */
    public function supprCategorie(Request $request, $id): Response
    {
        $CategorieRef = $this->entityManager->getRepository(Categories::class)->findOneById($id);
        if(!$CategorieRef){
            return $this->redirectToRoute('admin_categorie');
        }
        $form = $this->createForm(DeleteEntityAdminType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            if($form->get('checkBox')->getdata()){

                $this->entityManager->remove($CategorieRef);
                $this->entityManager->flush();

                return $this->redirectToRoute("admin_categorie");
            }
        }
        return $this->render('admin_remove/categorie.html.twig', [
            'position' => 'categorie',
            'cate' => $CategorieRef,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/Equipe/Suppression/{id}", name="admin_suppr_equipe")
     */
    public function supprEquipe(Request $request, $id): Response
    {
        $EquipeRef = $this->entityManager->getRepository(CompanyMembers::class)->findOneById($id);
        if(!$EquipeRef){
            return $this->redirectToRoute('admin_equipe');
        }
        $form = $this->createForm(DeleteEntityAdminType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            if($form->get('checkBox')->getdata()){
                $filesystem = new Filesystem();
                
                if($filesystem->exists('uploads/'.$EquipeRef->getImage())){
                    $filesystem->remove(['uploads/'.$EquipeRef->getImage()]); 
                }
                $this->entityManager->remove($EquipeRef);
                $this->entityManager->flush();

                return $this->redirectToRoute("admin_equipe");
            }
        }


        return $this->render('admin_remove/equipe.html.twig', [
            'position' => 'equipe',
            'equipe' => $EquipeRef,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/Access/Suppression/{id}", name="admin_suppr_access")
     */
    public function supprAccess(Request $request, $id): Response
    {
        $AccessRef = $this->entityManager->getRepository(AdminUser::class)->findOneById($id);
        if(!$AccessRef){
            return $this->redirectToRoute('admin_access');
        }
        $nbAdmin = $this->entityManager->getRepository(AdminUser::class)->findAll();
        $form = $this->createForm(DeleteEntityAdminType::class);
        $form->handleRequest($request);

         
        if(count($nbAdmin) == 1){
                $this->addFlash('notice', "Vous ne pouvez pas supprimer le dernier administrateur!")  ;
                return $this->redirectToRoute("admin_access");
        }else if($this->getUser() == $AccessRef){
            $this->addFlash('notice', "Vous ne pouvez pas vous supprimez!")  ;
            return $this->redirectToRoute("admin_access");
        }

        if($form->isSubmitted() && $form->isValid()){

            if($form->get('checkBox')->getdata()){

                

                $this->entityManager->remove($AccessRef);
                $this->entityManager->flush();

                
                
            }
        }
        return $this->render('admin_remove/access.html.twig', [
            'position' => 'access',
            'access' => $AccessRef,
            'form' => $form->createView(),
        ]);
    }
}
