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
                'label'=> 'Photo',
                'mapped'=> false])
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
