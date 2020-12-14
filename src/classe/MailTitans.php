<?php

namespace App\classe;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
const TitanMail = 'contact@titanstudios.fr';//'stud.titan@gmail.com';
const SubjectToTitan = 'Un Mail de votre site';

Class MailTitans{

    // private $mailer;
        
    //     public function __construct(MailerInterface $mailer)
    //     {
    //         $this->mailer = $mailer;
    //     }

    public function sendMailToUser(string $clientName , string $subject , string $fromMail){

        $email = (new TemplatedEmail())
        ->from(TitanMail)
        ->to($fromMail)
        ->subject($subject)
        ->htmlTemplate('mail/mailToClient.html.twig')
        ->context([
            'client'=> $clientName,
        ])
        ;
        

        return $email;
    }

    public function sendMailToTitan(string $clientName, string $clientMail, string $cateProjet, string $clientText, $clientPhone){

        $subject = 'Un mail de '.$clientName;
        $email = (new TemplatedEmail())
        ->from(TitanMail)
        ->to(TitanMail)
        ->subject($subject)
        ->htmlTemplate('mail/mailToTitans.html.twig')
        ->context([
            'client'=> $clientName,
            'mail'=> $clientMail,
            'categorie'=> $cateProjet,
            'text'=> $clientText,
            'phone'=> $clientPhone,
        ])
        ;

       

        return $email;
    }

}