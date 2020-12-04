<?php

namespace App\Controller\Admin;

use App\Entity\Actualite;
use App\Form\DeleteEntityAdminType;
use Doctrine\ORM\EntityManagerInterface;
use PhpParser\Node\Scalar\MagicConst\File;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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

        $form = $this->createForm(DeleteEntityAdminType::class);
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
     * @Route("/admin/Types/Suppression/{id}", name="admin_suppr_type")
     */
    public function supprType(Request $request, $id): Response
    {
        $TypeRef = $this->entityManager->getRepository(Types::class)->findOneById($id);
        $form = $this->createForm(DeleteEntityAdminType::class);
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
     * @Route("/admin/Categories/Suppression/{id}", name="admin_suppr_categorie")
     */
    public function supprCategorie(Request $request, $id): Response
    {
        $CategorieRef = $this->entityManager->getRepository(Categories::class)->findOneById($id);
        $form = $this->createForm(DeleteEntityAdminType::class);
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
     * @Route("/admin/Equipe/Suppression/{id}", name="admin_suppr_equipe")
     */
    public function supprEquipe(Request $request, $id): Response
    {
        $EquipeRef = $this->entityManager->getRepository(CompanyMembers::class)->findOneById($id);
        $form = $this->createForm(DeleteEntityAdminType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $equipe = $form->getData();

            
            $imgFile = $form->get('image')->getData();
            if($imgFile != null){
                $filename = pathinfo($imgFile->getClientOriginalName(), PATHINFO_FILENAME);

                $newFilename = $filename.'-'.uniqid().'.'.$imgFile->guessExtension();
                // dd($newFilename);
                
    
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
     * @Route("/admin/Access/Suppression/{id}", name="admin_suppr_access")
     */
    public function supprAccess(Request $request, $id): Response
    {
        $AccessRef = $this->entityManager->getRepository(AdminUser::class)->findOneById($id);
        $form = $this->createForm(DeleteEntityAdminType::class);
        $form->handleRequest($request);

        // $form->get('password')->setData($AccessRef->getPassword());
        if($form->isSubmitted() && $form->isValid()){

            $access = $form->getData();
            
                // $pwd = $encoder->encodePassword($access, $access->getPassword());
                // $access->setPassword($pwd);
            
         
            $this->entityManager->flush();

            return $this->redirectToRoute("admin_access");
        }
        return $this->render('admin_add/index.html.twig', [
            'position' => 'access',
            'form' => $form->createView(),
        ]);
    }
}
