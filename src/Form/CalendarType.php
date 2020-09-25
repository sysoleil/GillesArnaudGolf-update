<?php

namespace App\Form;

use App\Entity\Calendar;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CalendarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label'=> 'Votre Nom',
                'required'=>false])
            ->add('start', DateTimeType::class,[
                'date_widget' => 'single_text',
                'label'=>'début'])
            ->add('end',DateTimeType::class,[
                'date_widget' => 'single_text',
                'label'=> 'fin'])
            ->add('description', TextareaType::class,[
                'label'=>'cours choisi',
            ])
            ->add('allDay', ChoiceType::class,[
                'label'=>'journée compléte',
                'choices'  => [
                    'Non' => False,
                    'Oui' => true]])
            ->add('submit', SubmitType::class, ['label'=>'Envoyer'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Calendar::class,
        ]);
    }
}
