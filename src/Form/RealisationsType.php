<?php

namespace App\Form;

use App\Entity\Categories;
use App\Entity\Realisations;
use App\Entity\Types;
use Doctrine\DBAL\Types\BooleanType;
use phpDocumentor\Reflection\Types\Boolean;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RealisationsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class,[
                'label' => 'Titre de la réalisation',
                'attr' => [
                    'placeholder' => 'Votre titre',
                    'class' => 'slugFrom'
                ]
            ])
            ->add('slug', TextType::class,[
                'label' => 'slug de votre actualité',
                'disabled' => true,
                'attr' => [
                    'placeholder' => 'Votre slug',
                    'class' => 'slugTo'
                ]
            ])
            ->add('description', TextType::class,[
                'label' => 'description de la réalisation',
                'attr' => [
                    'placeholder' => 'Votre description',
                ]
            ])
            ->add('text', TextareaType::class,[
                'label' => 'Texte de la réalisation',
                'attr' => [
                    'placeholder' => 'Votre titre',
                ]
            ])
            ->add('image1', FileType::class,[
                'label' => 'image 1 de la réalisation (png)',
                'required' =>false,
                'mapped' => false,
                'attr' => [
                    
                ],
                'constraints' => [
                    new File([
                        'maxSize' => '2048k',
                        'mimeTypes' => [
                            'image/png',
                            'image/jpeg'
                        ],
                        'mimeTypesMessage' => 'Veuillez insérer une image valide',
                    ])
                ],
                
            ])
            ->add('image2', FileType::class,[
                'label' => 'image 2 de la réalisation (png)',
                'required' =>false,
                'mapped' => false,
                'attr' => [
                    
                ],
                'constraints' => [
                    new File([
                        'maxSize' => '2048k',
                        'mimeTypes' => [
                            'image/png',
                            'image/jpeg'
                        ],
                        'mimeTypesMessage' => 'Veuillez insérer une image valide',
                    ])
                ],
                
            ])
            ->add('image3', FileType::class,[
                'label' => 'image 3 de la réalisation (png)',
                'required' =>false,
                'mapped' => false,
                'attr' => [
                    
                ],
                'constraints' => [
                    new File([
                        'maxSize' => '2048k',
                        'mimeTypes' => [
                            'image/png',
                            'image/jpeg'
                        ],
                        'mimeTypesMessage' => 'Veuillez insérer une image valide',
                    ])
                ],
                
            ])
            ->add('image4', FileType::class,[
                'label' => 'image 4 de la réalisation (png)',
                'required' =>false,
                'mapped' => false,
                'attr' => [
                    
                ],
                'constraints' => [
                    new File([
                        'maxSize' => '2048k',
                        'mimeTypes' => [
                            'image/png',
                            'image/jpeg'
                        ],
                        'mimeTypesMessage' => 'Veuillez insérer une image valide',
                    ])
                ],
                
            ])
            ->add('highlight', CheckboxType::class,[
                'label' => 'Si la réalisation doit être mise en avant',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Votre titre',
                ]
            ])
            ->add('categorie', EntityType::class,[
                'label' => 'Catégorie de la réalisation',
                'required' => true,
                'class' => Categories::class,
                // 'choices' => $user->getAddresses(),
                'multiple' => false,
                'expanded' => false,
            ])
            ->add('type', EntityType::class,[
                'label' => 'Type de la réalisation',
                'required' => true,
                'class' => Types::class,
                // 'choices' => $user->getAddresses(),
                'multiple' => false,
                'expanded' => false,
            ])
            ->add('linkName1', TextType::class,[
                'label' => 'Nom du lien 1 de votre réalisation',
                'mapped' =>false,
                'attr' => [
                    'placeholder' => 'nom lien 1',
                ]
            ])
            ->add('link1', TextType::class,[
                'label' => 'Lien 1 de votre réalisation',
                'mapped' =>false,
                'attr' => [
                    'placeholder' => 'lien 1',
                ]
            ])
            ->add('linkName2', TextType::class,[
                'label' => 'Nom du lien 2 de votre réalisation',
                'mapped' =>false,
                'attr' => [
                    'placeholder' => 'nom lien 2',
                ]
            ])
            ->add('link2', TextType::class,[
                'label' => 'Lien 2 de votre réalisation',
                'mapped' =>false,
                'attr' => [
                    'placeholder' => 'lien 2',
                ]
            ])
            ->add('linkName3', TextType::class,[
                'label' => 'Nom du lien 3 de votre réalisation',
                'mapped' =>false,
                'attr' => [
                    'placeholder' => 'nom lien 3',
                ]
            ])
            ->add('link3', TextType::class,[
                'label' => 'Lien 3 de votre réalisation',
                'mapped' =>false,
                'attr' => [
                    'placeholder' => 'lien 3',
                ]
            ])
            ->add('linkName4', TextType::class,[
                'label' => 'Nom du lien 4 de votre réalisation',
                'mapped' =>false,
                'attr' => [
                    'placeholder' => 'nomlien 4',
                ]
            ])
            ->add('link4', TextType::class,[
                'label' => 'Lien 4 de votre réalisation',
                'mapped' =>false,
                'attr' => [
                    'placeholder' => 'lien 4',
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
            'data_class' => Realisations::class,
        ]);
    }
}
