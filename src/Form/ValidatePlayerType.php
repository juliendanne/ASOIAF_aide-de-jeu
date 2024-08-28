<?php

namespace App\Form;

use App\Entity\StatutPlayer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ValidatePlayerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('name', ChoiceType::class,[
            'label'=>'Satut du joueur',
            'choices'=>[
                'Accepter joueur'=>'accepté',
                'Refuser joueur'=>'refusé'
            ],
            'expanded'=>'false',
            'choice_attr'=>[
                'Accepter joueur'=>['class'=>'me-1'],
                'Refuser joueur'=>['class'=>'me-1 ms-5'],
            ]

        ])
        ->add('save', SubmitType::class, [
            'attr' => ['class' => 'save flex_button flex_button_button btn btn-info border mt-2'],
            'label'=>'Valider'
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => StatutPlayer::class,
        ]);
    }
}
