<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntityValidator;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\component\Form\FormView;

class UserRegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('password',RepeatedType::class,[
                'type' => PasswordType::class,
                'first_options'  => ['label' => 'Mot de passe'],
                'second_options' => ['label' => 'Répeter mot de passe'],
                'invalid_message' => 'Les mots de passe ne sont pas identiques',
            ])
            ->add('plainPassword', PasswordType::class, [
                // au lieu d'être directement placé sur l'objet,
                // il est lu puis encodé dans le controller
                'mapped' => false,
                'constraints' => [
                    // interdiction de laisser vide avec un message d'info
                    new NotBlank([
                        'message' => 'Entrer un mot de passe',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit faire au moins {{ limit }} de lettres.',
                        // Longueur maximale autorisée par Symfony pour des raisons de sécurité
                        'max' => 4096,
                    ]),
                ],
                'required'=> false,
            ])
            ->add('email', EmailType::class,[
                'label' => 'eMail'
            ])
            ->add('firstName', TextType::class,[
                'label' => "Prénom"
            ])
            ->add('lastName', TextType::class,[
                'label' => "Nom"
            ])

            ->add('level', TextType::class,[
                'label' => 'level'
            ])
            ->add('club', TextType::class,[
                'label' => 'club'
            ])
            ->add('phone', TextType::class,[
                'label' => 'Téléphone'
            ])
            ->add('genre', ChoiceType::class,[
                'choices' => [
                    'Femme' => true,
                    'Homme' => false]])

            ->add("submit", SubmitType::class ,[
                "label" => "S'enregistrer"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}