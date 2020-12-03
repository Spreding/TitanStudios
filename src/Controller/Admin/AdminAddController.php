<?php

namespace App\Controller\Admin;

use App\classe\Slugify;
use App\Entity\LinksRealisation;
use App\Entity\Realisations;
use App\Form\AccessAdminType;
use App\Form\ActualiteType;
use App\Form\AdminAccessType;
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
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authenticator\Passport\UserPassportInterface;

class AdminAddController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/admin/Actualité/Ajout", name="admin_add_actu")
     */
    public function addActu(Request $request): Response
    {
        $form = $this->createForm(ActualiteType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $Actu = $form->getData();
            $imgFile = $form->get('image')->getData();
            // dd($imgFile);
            // $Actu->getSlug();
            $Actu->setSlug(Slugify::Slug($Actu->getTitle()));

            $Actu->setCreatedAt(new DateTime());

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

            $Actu->setImage($newFilename);




            
             $this->entityManager->persist($Actu);
             $this->entityManager->flush();

            return $this->redirectToRoute("admin_actu");
        }

        return $this->render('admin_add/index.html.twig', [
            'position' => 'actu',
            'form' => $form->createView(),
            
        ]);
    }

    /**
     * @Route("/admin/Réalisations/Ajout", name="admin_add_real")
     */
    public function addReal(Request $request): Response
    {
        $form = $this->createForm(RealisationsType::class);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){

            $Real = $form->getData();

            //Set slug
            $Real->setSlug(Slugify::Slug($Real->getTitle()));

            //Set les images
            for ($i=1; $i < 5; $i++) { 
                $imgFile = $form->get('image'.$i)->getData();
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
                        $Real->setImage1($newFilename);
                    break;
                    case 2:
                        $Real->setImage2($newFilename);
                    break;
                    case 3:
                        $Real->setImage3($newFilename);
                    break;
                    case 4:
                        $Real->setImage4($newFilename);
                    break;
                }
                
            }

             $this->entityManager->persist($Real);
             $this->entityManager->flush();
            
             
             $idReal = $this->entityManager->getRepository(Realisations::class)->findOneBy([], ['id' => 'DESC']);

            //Set Liens de réalisations
            for ($i=1; $i < 5; $i++) { 
                $LinkName = $form->get('linkName'.$i)->getData();
                $Link = $form->get('link'.$i)->getData();

                $newLink = new LinksRealisation;
                $newLink->setRealisation($idReal);
                $newLink->setNameLink($LinkName);
                $newLink->setLink($Link);

                
                $this->entityManager->persist($newLink);
                $this->entityManager->flush();

                
                
            }  

            $Links = $this->entityManager->getRepository(LinksRealisation::class)->findByRealisation($idReal->getId());
            foreach ($Links as $link ) {
                $idReal->addLinksRealisation($link);
            }
            
            

            return $this->redirectToRoute("admin_real");
        }

        return $this->render('admin_add/index.html.twig', [
            'position' => 'real',
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/Types/Ajout", name="admin_add_type")
     */
    public function addType(Request $request): Response
    {
        $form = $this->createForm(TypesType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $type = $form->getData();

            $this->entityManager->persist($type);
            $this->entityManager->flush();

            return $this->redirectToRoute("admin_type");
        }
        return $this->render('admin_add/index.html.twig', [
            'position' => 'type',
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/Categories/Ajout", name="admin_add_categorie")
     */
    public function addCategorie(Request $request): Response
    {
        $form = $this->createForm(CategoriesType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $categorie = $form->getData();

            $this->entityManager->persist($categorie);
            $this->entityManager->flush();

            return $this->redirectToRoute("admin_categorie");
        }
        return $this->render('admin_add/index.html.twig', [
            'position' => 'type',
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/Équipe/Ajout", name="admin_add_equipe")
     */
    public function addEquipe(Request $request): Response
    {
        $form = $this->createForm(CompanyMembersType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $equipe = $form->getData();
            $imgFile = $form->get('image')->getData();

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

            $this->entityManager->persist($equipe);
            $this->entityManager->flush();

            return $this->redirectToRoute("admin_equipe");
        }


        return $this->render('admin_add/index.html.twig', [
            'position' => 'equipe',
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/Access/Ajout", name="admin_add_access")
     */
    public function addAccess(Request $request, UserPasswordEncoderInterface $encoder): Response
    {
        $form = $this->createForm(AccessAdminType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $access = $form->getData();
            // dd($access->getPassword());
            $pwd = $encoder->encodePassword($access, $access->getPassword());
            $access->setPassword($pwd);
            // dd($access->getPassword());
            $this->entityManager->persist($access);
            $this->entityManager->flush();

            return $this->redirectToRoute("admin_access");
        }
        return $this->render('admin_add/index.html.twig', [
            'position' => 'access',
            'form' => $form->createView(),
        ]);
    }
}
