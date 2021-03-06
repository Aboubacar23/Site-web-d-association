<?php

namespace App\Form;

use App\Entity\Bureau;
use App\Entity\Niveau;
use App\Entity\Universite;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;

class BureauType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder 
            ->add('Nom',TextType::class) 
            ->add('Prenom',TextType::class)
            ->add('Telephone',NumberType::class)
            ->add('Email',EmailType::class)
            ->add('Pays',CountryType::class)
            ->add('Poste')
            ->add('DateNaissance',DateType::class,[
                'widget' => 'single_text',
            ])
            ->add('Cv',FileType::class,[
                'label'=>'Cv (pdf file)',
                'mapped'=>false,
                'required'=> true,
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
            ->add('Specialite',TextType::class)
            ->add('Profil')
            ->add('Niveau',EntityType::class,[
                'class'=> Niveau::class,
                'choice_label' => 'Libelle'
            ])
            ->add('Universite',EntityType::class,[
                'class'=>Universite::class,
                'choice_label'=>'Nom'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Bureau::class,
        ]);
    }
}
