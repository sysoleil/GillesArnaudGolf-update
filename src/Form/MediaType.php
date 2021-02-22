<?php

namespace App\Form;

use App\Entity\Media;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\File;

class MediaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, ['label'=> 'Nom',
                'required'=> false])
            ->add('description', TextareaType::class,  [
                'label'=>'Description'])
            ->add('photo', FileType::class, [
                'label'=> 'sélectionner une Photo',
                'mapped'=> false,
                    'constraints'=>[
                        new File([
                            //'maxSize' => '1024k',
                            'mimeTypes' => [
                                'image/jpeg',
                                'image/x-jpeg',
                                'image/png',
                                'image/x-png',
                                'video/mpeg',
                                'video/x-mpeg',
                                'video/x-quicktime',
                                'video/quicktime',
                                'video/ms--wmv',
                                'video/x-ms-wmv',
                                'video/msvideo',
                                'video/x-msvideo',
                                'video/flv',
                                'video/x-flv',
                                'video/mp4',
                                'video/x-mp4',
                            ],
                            'mimeTypesMessage' => 'Veuillez choisir une extension valide pour les images .jpeg ou .png',
                        ])
                    ]
                ])
            // je créé l'input File, avec en option "mapped => false" pour
            // que symfony n'enregistre pas automatiquement la valeur du champs
            // (comme il le fait sur les autres champs) quand le formulaire est envoyé

            ->add('alt', TextType::class, ['label'=> 'Mots clés'])
            ->add('submit', SubmitType::class, ['label'=>'Envoyer'])
            // Je rajoute manuellemet un input 'submit'
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
            'data_class' => Media::class,
        ]);
    }
}
