<?php

namespace App\Form;

use App\Entity\TicketBook;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TicketBookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label'=> 'Type de carnet'])
            ->add('duration',IntegerType::class,['label'=>'Durée totale en unité d\'1/2 heure '])
            ->add('price', IntegerType::class,['label'=>'Prix total en € du carnet'])
            ->add('submit',SubmitType::class, ['label'=>'Valider'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TicketBook::class,
        ]);
    }
}