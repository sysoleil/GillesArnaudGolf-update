<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class,[
                'label' => 'eMail'
            ])
            ->add('firstName', TextType::class,[
                'label' => "Nom"
            ])
            ->add('lastName', TextType::class,[
                'label' => "Prénom"
            ])
        //    ->add('roles', TextType::class,[
         //   ])

            ->add('creditDuration', IntegerType::class,[
                'label'=> 'Nombre de ticket'
            ])
            ->add('level', TextType::class,[
                'label' => 'index'
            ])
            ->add('club', TextType::class,[
            ])
            ->add('phone', TextType::class,[
                'label' => 'Téléphone'
            ])
            ->add('genre', ChoiceType::class,[
                'choices' => [
                    'Femme' => true,
                    'Homme' => false]])
        //    ->add('plainPassword', PasswordType::class, [
                // au lieu d'être directement placé sur l'objet,
                // il est lu puis encodé dans le controller
         //       'mapped' => false,
         //       'constraints' => [
                    // interdiction de laisser vide + (Msg)
         //           new NotBlank([
         //               'message' => 'Entrer un mot de passe',
         //           ]),
         //           new Length([
         //               'min' => 6,
         //               'minMessage' => 'Votre mot de passe doit faire au moins {{ limit }} de lettres.',
                        // Longueur maximale autorisée par Symfony pour des raisons de sécurité
         //               'max' => 4096,
          //          ]),
         //       ],
         //   ])
            ->add('submit',SubmitType::class, ['label'=>'Valider'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
