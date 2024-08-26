<?php

namespace App\Form;

use App\Entity\Army;
use App\Entity\Faction;
use App\Entity\CombatUnit;
use App\Entity\TypeOfUnit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class SelectCUType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('link_combatUnit', EntityType::class, [
                'class'=>CombatUnit::class,
                'choice_label'=>'name',
                'label_attr'=>['class'=>'me-1'],
                'label'=>'Choisir une unité de combat',
                'mapped'=>false
            ])
            ->add('secondary_stuff_add_btn', ButtonType::class, [
                'attr' => ['class' => 'secondary_stuff_add_btn'],
            ]);
            //->add('commander')
            //->add('army')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Army::class,
        ]);
    }
}
