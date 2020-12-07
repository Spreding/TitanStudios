<?php

namespace App\Controller\Admin;

use App\classe\Slugify;
use App\Entity\Actualite;
use App\Entity\AdminUser;
use App\Entity\Categories;
use App\Entity\CompanyMembers;
use App\Entity\LinksRealisation;
use App\Entity\Realisations;
use App\Entity\Types;
use App\Form\AccessAdminType;
use App\Form\ActualiteType;
use App\Form\CategoriesType;
use App\Form\CompanyMembersType;
use App\Form\RealisationsType;
use App\Form\TypesType;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AdminModifyController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/admin/Actualite/Modification/{id}", name="admin_modif_actu")
     */
    public function modifActu(Request $request, $id): Response
    {
        $ActuRef = $this->entityManager->getRepository(Actualite::class)->findOneById($id);
        if(!$ActuRef){
            return $this->redirectToRoute('admin_actu');
        }
        $form = $this->createForm(ActualiteType::class, $ActuRef);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $Actu = $form->getData();

            $ActuRef->setSlug(Slugify::Slug($Actu->getTitle()));

            $imgFile = $form->get('image')->getData();

            if($imgFile != null){
    
                $filename = pathinfo($imgFile->getClientOriginalName(), PATHINFO_FILENAME);
    
                $newFilename = $filename.'-'.uniqid().'.'.$imgFile->guessExtension();

                try {
                    $imgFile->move(
                        $this->getParameter('uploads_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                    throw new Exception("Erreur lors de l'upload de l'image", 1);
                    
                }
    
                $ActuRef->setImage($newFilename);
            }

             $this->entityManager->flush();

            return $this->redirectToRoute("admin_actu");
        }

        return $this->render('admin_modify/index.html.twig', [
            'position' => 'actu',
            'form' => $form->createView(),
            
        ]);
    }

    /**
     * @Route("/admin/Realisation/Modification/{id}", name="admin_modif_real")
     */
    public function modifReal(Request $request, $id): Response
    {
        $RealRef = $this->entityManager->getRepository(Realisations::class)->findOneById($id);
        if(!$RealRef){
            return $this->redirectToRoute('admin_real');
        }
        $links = $this->entityManager->getRepository(LinksRealisation::class)->findByRealisation($RealRef->getId());

        $form = $this->createForm(RealisationsType::class, $RealRef);
        for ($i=1; $i <5; $i++) { 
           $form->get('linkName'.$i)->setData($links[$i-1]->getNameLink());
           $form->get('link'.$i)->setData($links[$i-1]->getLink());
        }

        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){

            $Real = $form->getData();

            //Set slug
            $Real->setSlug(Slugify::Slug($Real->getTitle()));

            //Set les images
            for ($i=1; $i < 5; $i++) { 

                $imgFile = $form->get('image'.$i)->getData();
                // dd($imgFile);

                if($imgFile != null){
                    $filename = pathinfo($imgFile->getClientOriginalName(), PATHINFO_FILENAME);
    
                    $newFilename = $filename.'-'.uniqid().'.'.$imgFile->guessExtension();
                    try {
                        $imgFile->move(
                            $this->getParameter('uploads_directory'),
                            $newFilename
                        );
                    } catch (FileException $e) {
                        // ... handle exception if something happens during file upload
                        throw new Exception("Erreur lors de l'upload de l'image", 1);
                        
                    }
                    switch($i){
                        case 1:
                            $RealRef->setImage1($newFilename);
                        break;
                        case 2:
                            $RealRef->setImage2($newFilename);
                        break;
                        case 3:
                            $RealRef->setImage3($newFilename);
                        break;
                        case 4:
                            $RealRef->setImage4($newFilename);
                        break;
                    }
                }
                
                
            }

            //Update Liens de réalisations
            for ($i=1; $i <5; $i++) { 
                $ln = $form->get('linkName'.$i)->getData();
                $l = $form->get('link'.$i)->getData();
                if($links[$i-1]->getNameLink() != $ln) $links[$i-1]->setNameLink($ln);
                if($links[$i-1]->getLink() != $l) $links[$i-1]->setLink($l);
             }

             $this->entityManager->flush();

            return $this->redirectToRoute("admin_real");
        }

        return $this->render('admin_modify/index.html.twig', [
            'position' => 'real',
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/Types/Modification/{id}", name="admin_modif_type")
     */
    public function modifType(Request $request, $id): Response
    {
        $TypeRef = $this->entityManager->getRepository(Types::class)->findOneById($id);
        if(!$TypeRef){
            return $this->redirectToRoute('admin_type');
        }
        $form = $this->createForm(TypesType::class, $TypeRef);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $type = $form->getData();

            $this->entityManager->flush();

            return $this->redirectToRoute("admin_type");
        }
        return $this->render('admin_add/index.html.twig', [
            'position' => 'type',
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/Categories/Modification/{id}", name="admin_modif_categorie")
     */
    public function modifCategorie(Request $request, $id): Response
    {
        $CategorieRef = $this->entityManager->getRepository(Categories::class)->findOneById($id);
        if(!$CategorieRef){
            return $this->redirectToRoute('admin_categorie');
        }
        $form = $this->createForm(CategoriesType::class, $CategorieRef);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $categorie = $form->getData();


            $this->entityManager->flush();

            return $this->redirectToRoute("admin_categorie");
        }
        return $this->render('admin_add/index.html.twig', [
            'position' => 'type',
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/Equipe/Modification/{id}", name="admin_modif_equipe")
     */
    public function modifEquipe(Request $request, $id): Response
    {
        $EquipeRef = $this->entityManager->getRepository(CompanyMembers::class)->findOneById($id);
        if(!$EquipeRef){
            return $this->redirectToRoute('admin_equipe');
        }
        $form = $this->createForm(CompanyMembersType::class, $EquipeRef);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $equipe = $form->getData();

            
            $imgFile = $form->get('image')->getData();
            if($imgFile != null){
                $filename = pathinfo($imgFile->getClientOriginalName(), PATHINFO_FILENAME);

                $newFilename = $filename.'-'.uniqid().'.'.$imgFile->guessExtension();
                // dd($newFilename);
                try {
                    $imgFile->move(
                        $this->getParameter('uploads_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                    throw new Exception("Erreur lors de l'upload de l'image", 1);
                    
                }
    
                $equipe->setImage($newFilename);
            }
            

            $this->entityManager->flush();

            return $this->redirectToRoute("admin_equipe");
        }


        return $this->render('admin_add/index.html.twig', [
            'position' => 'equipe',
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/Access/Modification/{id}", name="admin_modif_access")
     */
    public function modifAccess(Request $request, UserPasswordEncoderInterface $encoder, $id): Response
    {
        $AccessRef = $this->entityManager->getRepository(AdminUser::class)->findOneById($id);
        if(!$AccessRef){
            return $this->redirectToRoute('admin_access');
        }
        $form = $this->createForm(AccessAdminType::class, $AccessRef);
        $form->handleRequest($request);

        // $form->get('password')->setData($AccessRef->getPassword());
        if($form->isSubmitted() && $form->isValid()){

            $access = $form->getData();
            
                $pwd = $encoder->encodePassword($access, $access->getPassword());
                $access->setPassword($pwd);
            
         
            $this->entityManager->flush();

            return $this->redirectToRoute("admin_access");
        }
        return $this->render('admin_add/index.html.twig', [
            'position' => 'access',
            'form' => $form->createView(),
        ]);
    }
}
