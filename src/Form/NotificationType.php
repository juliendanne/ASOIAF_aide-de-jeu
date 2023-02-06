<?php

namespace App\Form;

use App\Entity\Notification;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class NotificationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('statut', ChoiceType::class,[
            'choices'=>[
                'Non lu'=>'non lu',
                'Lu'=>'lu',
                'Archiver'=>'archivée',
            ],
            'expanded'=>'false',
            'choice_attr'=>[
                'Non lu'=>['class'=>'me-1'],
                'Lu'=>['class'=>'me-1 ms-5'],
                'Archiver'=>['class'=>'me-1 ms-5'],
            ]

            ])
            ->add('save', SubmitType::class, [
                'attr' => ['class' => 'save flex_button flex_button_button btn btn-info border mt-2'],
                'label'=>'Valider'
            ]);

    }
/*             ->add('object')
            ->add('content')
            ->add('statut')
            ->add('creationDate')
            ->add('modifDate')
            ->add('notifAuthor')
            ->add('addressee')
            ->add('game') */
/*         ;
    } */

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Notification::class,
        ]);
    }
}
