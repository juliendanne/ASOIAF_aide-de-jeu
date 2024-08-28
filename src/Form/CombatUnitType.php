<?php

namespace App\Form;

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
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class CombatUnitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                "attr"=>[
                    'class'=>'form-control',
                    ],
                'label'=>'Nom de l\'unité',
                ])
            ->add('cost', ChoiceType::class,[
                'label'=>'Coût en points',
                'choices'=>[
                    '0 point'=>0,
                    '1 point'=>1,
                    '2 points'=>2,
                    '3 points'=>3,
                    '4 points'=>4,
                    '5 points'=>5,

                ],
                'multiple'=>false,
            ])
            ->add('soloUnit', CheckboxType::class, [
                "attr"=>[
                    'class'=>'ms-2',
    
                ],
                'label'=>'Unité solo',
                'mapped' => true,
                'required' => false
            ])
            ->add('card', FileType::class, [
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize'=>'16384k',
                        'maxSizeMessage'=>'Taille de fichier trop grande',
                        'mimeTypes'=>[
                            'image/jpeg',
                            'image/jpg',
                            'image/png',
                            'image/svg',
                        ],
                        'mimeTypesMessage'=>'Extension de fichier invalide',
                    ])
                    ],
                'attr'=>[
                    'class'=>'form-control',
                ],
                'data_class'=>null,
            ])
            ->add('cardVerso', FileType::class, [
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize'=>'16384k',
                        'maxSizeMessage'=>'Taille de fichier trop grande',
                        'mimeTypes'=>[
                            'image/jpeg',
                            'image/jpg',
                            'image/png',
                            'image/svg',
                        ],
                        'mimeTypesMessage'=>'Extension de fichier invalide',
                    ])
                    ],
                'attr'=>[
                    'class'=>'form-control',
                ],
                'data_class'=>null,
            ])
            ->add('faction', EntityType::class, [
                'class'=>Faction::class,
                'choice_label'=>'name',
                'label_attr'=>['class'=>'me-1'],
                'label'=>'Faction',
                //'mapped'=>false
            ])
            ->add('typeOfUnit', EntityType::class, [
                'class'=>TypeOfUnit::class,
                'choice_label'=>'name',
                'label_attr'=>['class'=>'me-1'],
                'label'=>'Type d\'unité',
                //'mapped'=>false
            ])
            //->add('commander')
            //->add('army')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CombatUnit::class,
        ]);
    }
}
