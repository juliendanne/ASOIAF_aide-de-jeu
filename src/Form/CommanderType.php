<?php

namespace App\Form;

use App\Entity\Faction;
use App\Entity\Commander;
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

class CommanderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('name', TextType::class, [
            "attr"=>[
                'class'=>'form-control',
                ],
            'label'=>'Nom du Commandant',
            ])
            ->add('full_name', TextType::class, [
                "attr"=>[
                    'class'=>'form-control',
                    ],
                'label'=>'Nom complet',
                ])
            //->add('is_a_character')
            ->add('soloUnit', CheckboxType::class, [
                "attr"=>[
                    'class'=>'ms-2',
    
                ],
                'label'=>'Ce commandant est une unité solo',
                'mapped' => true,
                'required' => false
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
                    '6 points'=>6,
                    '7 points'=>7,
                    '8 points'=>8,
                    '9 points'=>9,
                    '10 points'=>10,
                ],
                'multiple'=>false,
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
            //->add('combatUnit')
            ->add('faction', EntityType::class, [
                'class'=>Faction::class,
                'choice_label'=>'name',
                'label_attr'=>['class'=>'me-1'],
                'label'=>'Faction',
                //'mapped'=>false
            ])
            ->add('type', EntityType::class, [
                'class'=>TypeOfUnit::class,
                'choice_label'=>'name',
                'label_attr'=>['class'=>'me-1'],
                'label'=>'Type d\'unité',
                //'mapped'=>false
            ])
            //->add('attached_to_unit')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Commander::class,
        ]);
    }
}
