<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;


class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class,[
                'label' => "Nom"
            ])
            ->add('lastName', TextType::class,[
                'label' => "Prénom"
            ])
            ->add('email', EmailType::class,[
                'label' => 'eMail'
            ])
            ->add('phone', TextType::class,[
                'label' => 'Téléphone'
            ])
            ->add('message', TextareaType::class,[
                'label' => 'Votre message'
            ])
            ->add('submit',SubmitType::class, ['label'=>'Valider'])
        ;
    }
}
