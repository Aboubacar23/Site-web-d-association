<?php

namespace App\Form;

use App\Entity\Genre; 
use App\Entity\Projet;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class ProjetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Nom')
            ->add('Description')
            ->add('Document',FileType::class,[
                'label'=>'document projet (pdf file)',
                'mapped'=>false,
                'required'=>false,
                'constraints'=>[
                    new File([
                        'maxSize' => '5000000k',
                        'mimeTypes'=>[
                            'application/pdf',
                            'application/x-pdf'
                        ],
                        'mimeTypesMessage'=>'Veuillez choisir un document pdf',
                        
                    ])
                ]
            ])
            ->add('DateAjout',DateType::class,[
                'widget' => 'single_text'
            ])
            ->add('DateCreation',DateType::class,[
                'widget' => 'single_text'
            ])
            ->add('Type',EntityType::class,[
                'class'=> Genre::class,
                'choice_label'=> 'Nom'
            ]) 
            ->add('Photo',FileType::class,[
                'label'=>'Photo (image du projet jpeg,jpg,png,)',
                'mapped'=>false,
                'required'=> true,
                'constraints'=>[
                    new File([
                        'maxSize' => '5000000k',
                        'mimeTypes'=>[
                            'image/png',
                            'image/jpg',
                            'image/jpeg'
                            
                        ],
                        'mimeTypesMessage'=>'Veuillez choisir un fichier du type png jpg ou jpeg',
                        
                    ])
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Projet::class,
        ]);
    }
}
