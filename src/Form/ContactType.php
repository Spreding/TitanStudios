<?php

namespace App\Form;

use Doctrine\DBAL\Types\TextType as TypesTextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('firstname', TextType::class, [
            'label' => 'Votre prénom *',
            'constraints' => new Length([
                'min' => 2,
                'max' => 40
            ]),
            'attr' => [
                'placeholder' => 'Veuillez rentrer votre prénom'
            ]
        ])
        ->add('lastname', TextType::class, [
            'label' => 'Votre nom *',
            'constraints' => new Length([
                'min' => 2,
                'max' => 40
            ]),
            'attr' => [
                'placeholder' => 'Veuillez rentrer votre nom'
            ]
        ])
        ->add('email', EmailType::class, [
            'label' => 'Votre adresse mail *',
            'constraints' => new Length([
                'min' => 2,
                'max' => 60
            ]),
            'attr' => [
                'placeholder' => 'Veuillez rentrer votre adresse mail'
            ]
        ])
        ->add('phone', TelType::class, [
            'label' => 'Votre téléphone',
            'required' =>false,
            'constraints' => new Length([
                'min' => 10,
                'max' => 10
            ]),
            'attr' => [
                'placeholder' => 'Veuillez rentrer votre numéro de téléphone'
            ]
        ])
        ->add('categorie', ChoiceType::class, [
            'label' => 'Catégorie de projet',
            'choices'  => [
                "Plus d'information" => "Plus d'information",
                'Jeu Vidéo' => 'Jeu Vidéo',
                'WEB' => 'WEB',
                'Application' => 'Application',
                'Autres' => 'Autres',
            ],
            'attr' => [
                'placeholder' => 'Veuillez rentrer votre message'
            ]
        ])
        ->add('texte', TextAreaType::class, [
            'label' => 'Votre message *',
            'attr' => [
                'placeholder' => 'Veuillez rentrer votre message'
            ]
        ])
        
        ->add('submit', SubmitType::class, [
            'label' => 'Envoyer',
            'attr' => [
                'class' => "buttonContact btn-lg btn-primary"
            ]
        ])
    
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
