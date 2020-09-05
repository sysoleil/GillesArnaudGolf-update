<?php

namespace App\Form;

use App\Entity\Course;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CourseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, ['label'=> 'Nom',
                'required'=> false])
            ->add('description', TextareaType::class,  [
                'label'=>'Description'])
            ->add('price', IntegerType::class, ['label'=> 'Prix',
                'required'=> false])
            ->add('minPerson', IntegerType::class, ['label'=> 'Nombre minimum'])
            ->add('maxPerson', IntegerType::class, ['label'=> 'Nombre maximum'])
            ->add('priceCe', TextType::class, ['label'=> 'Prix CE'])
            ->add('duration', TextType::class, ['label'=> 'Durée'])
            ->add('ticket', ChoiceType::class,[
                'choices' => [
                    'Oui' => true,
                    'Non' => false]])
            ->add('photo', FileType::class, [
                'label'=> 'Photo',
                'mapped'=> false])
            // je créé l'input File, avec en option "mapped => false" pour
            // que symfony n'enregistre pas automatiquement la valeur du champs
            // (comme il le fait sur les autres champs) quand le formulaire est envoyé

            ->add('alt', TextType::class, ['label'=> 'Référencement'])
            ->add('submit', SubmitType::class, ['label'=>'Envoyer'])
            // Je rajoute manuellemet un input 'submit'
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Course::class,
        ]);
    }
}