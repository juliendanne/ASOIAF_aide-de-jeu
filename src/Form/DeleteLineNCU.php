<?php

namespace App\Form;

use App\Entity\LineNCU;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class DeleteLineNCU extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('save', SubmitType::class, [
            'attr' => ['class' => 'save flex_button flex_button_button btn btn-info border mt-2'],
            'label'=>'Supprimer l\'unité non combattante'
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => LineNCU::class,
        ]);
    }
}