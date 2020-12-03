<?php

namespace App\Form;

use App\Entity\CompanyMembers;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class CompanyMembersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class,[
                'label' => 'Prenom',
                'attr' => [
                    'placeholder' => 'Le prenom',
                ]
            ])
            ->add('lastName', TextType::class,[
                'label' => 'Nom de famille',
                'attr' => [
                    'placeholder' => 'Le nom de famille',
                ]
            ])
            ->add('role', TextType::class,[
                'label' => 'Role',
                'attr' => [
                    'placeholder' => 'Le role',
                ]
            ])
            ->add('description', TextType::class,[
                'label' => 'Description',
                'attr' => [
                    'placeholder' => 'La description',
                ]
            ])
            ->add('image', FileType::class,[
                'label' => 'Image (png/jpg)',
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
            'data_class' => CompanyMembers::class,
        ]);
    }
}
