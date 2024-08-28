<?php

namespace App\Form;

use App\Entity\LineArmy;
use App\Entity\Attachment;
use App\Entity\CombatUnit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class LineArmyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
/*         ->add('quantity', IntegerType::class, [
            "attr"=>[
                'class'=>'form-control',
                ],
            'label'=>'Titre',
            ]) */
            ->add('attachments', EntityType::class, [
                "attr"=>[
                    'class'=>'form-control',
                    ],
                'class'=>Attachment::class,
                'choice_label'=>'cardVerso',
                'choice_attr'=>function($choice) {
                    return ['data-faction' => $choice->getFaction()->getId()];
                },
                'label_attr'=>['class'=>'me-1'],
                'label'=>'Choisir un attachement',
                'multiple' => true,
                'expanded'=>true,
            ])
            
            
            //->add('faction')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => LineArmy::class,
        ]);
    }
}
