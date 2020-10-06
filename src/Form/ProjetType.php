<?php

namespace App\Form;

use App\Entity\Projet;
use App\Entity\TypeProjet;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class ProjetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    { 
        $builder
            ->add('Nom')
            ->add('Description')
            ->add('Document',FileType::class,[
                'label'=>'document (pdf file)', 
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
            ->add('Type',EntityType::class,[
                'class'=> TypeProjet::class,
                'choice_label' => 'Nom'

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
