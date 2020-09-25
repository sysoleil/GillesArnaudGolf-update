<?php

namespace App\Form;

use App\Entity\Reservation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateCourse',DateTimeType::class,['date_widget' =>'single_text'])
            ->add('datePurchase', DateTimeType::class,['date_widget' =>'single_text'])
            ->add('price', IntegerType::class,
                ['label'=> 'Prix du cours',
                'required'=> false])
            ->add('hourStart', ChoiceType::class,['choice_value'=> 'h'])
            ->add('hourEnd', ChoiceType::class,['choice_value'=> 'h'])
            ->add('submit', SubmitType::class,["label"=> 'Enregistrer'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }
}
