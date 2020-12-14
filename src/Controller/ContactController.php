<?php

namespace App\Controller;

use App\classe\MailTitans;
use App\Entity\Realisations;
use App\Form\ContactType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function index(Request $request, MailerInterface $mailer): Response
    {
        $realisationsHighlight = $this->entityManager->getRepository(Realisations::class)->findRealisationsHighlighted();
        $form = $this->createForm(ContactType::class);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $email = new MailTitans();

            //Form data
            $mailClient = $form->get('email')->getData();
            $clientName =$form->get('lastname')->getData().' '. $form->get('firstname')->getData();
            $phoneClient = $form->get('phone')->getData();

            $texteProjet = $form->get('texte')->getData();
            $categorieProjet = $form->get('categorie')->getData();
            

            //Mail to user
            $subject = "Merci d'avoir contacter TITANstudios";

            $mailTemplate = $email->sendMailToUser($clientName, $subject, $mailClient);

            $mailer->send($mailTemplate);

            //mail to Titans
            $mailTemplate = $email->sendMailToTitan($clientName, $mailClient, $categorieProjet, $texteProjet, $phoneClient);

            $mailer->send($mailTemplate);

            $this->addFlash('notice', 'Votre message à bien été envoyé!');
            $form = $this->createForm(ContactType::class);
            
        }

        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
            'highlight' => $realisationsHighlight,
        ]);
    }
}
