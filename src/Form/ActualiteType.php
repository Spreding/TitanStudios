<?php

namespace App\Form;

use App\Entity\Actualite;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class ActualiteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class,[
                'label' => 'Titre de votre actualité',
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
                'label' => 'Description de votre actualité',
                'attr' => [
                    'placeholder' => 'Votre description',
                ]
            ])
            ->add('text', TextareaType::class,[
                'label' => 'texte de votre actualité',
                'attr' => [
                    'placeholder' => 'Votre texte',
                ]
            ])
            ->add('image', FileType::class,[
                'label' => 'image de votre actualité (png)',
                'attr' => [
                    
                ],
                'constraints' => [
                    new File([
                        'maxSize' => '2048k',
                        'mimeTypes' => [
                            'image/png',
                            'image/jpeg'
                        ],
                        'mimeTypesMessage' => 'Please upload a valid Image document',
                    ])
                ],
                
            ])
            // ->add('createdAt')
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
            'data_class' => Actualite::class,
        ]);
    }
}
