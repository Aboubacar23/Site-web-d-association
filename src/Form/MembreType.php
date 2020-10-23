<?php

namespace App\Form;

use App\Entity\Membre;
use App\Entity\Niveau;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class MembreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Nom')
            ->add('Prenom')
            ->add('Date_anniversaire')
            ->add('telephone')
            ->add('Pays')
            ->add('Email')
            ->add('Profil',TextareaType::class,[
                'attr' => ['class' => 'tinymce'],
            ])
            ->add('Poste')
            ->add('Cv',FileType::class,[
                'label'=>'Cv (pdf file)',
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
            ->add('Photo', FileType::class,[
                'label'=>'Photo (image jpeg,jpg,png,)',
                'mapped'=>false,
                'required'=>false,
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
            ->add('Niveau',EntityType::class,[
                'class'=> Niveau::class,
                'choice_label'=> 'Libelle'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Membre::class,
        ]);
    }
}
