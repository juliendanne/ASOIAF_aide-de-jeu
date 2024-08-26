<?php

namespace App\Form;

use App\Entity\Army;
use App\Entity\Faction;
use App\Entity\Commander;
use App\Entity\CombatUnit;

use App\Entity\NoCombatUnit;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class ArmyEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

             ->add('name', TextType::class, [
                "attr"=>[
                    'class'=>'form-control',
                ],
            ])
            ->add('commander', EntityType::class, [
                'class'=>Commander::class,
                'choice_label'=>'cardVerso',
                "attr"=>[
                    'class'=>'form-control',
                    ],
       
                'choice_attr'=>function($choice) {
                    return ['data-faction' => $choice->getFaction()->getId()];
                },
    
                'label_attr'=>['class'=>'me-1'],
                'label'=>'Choisir un commandant',
                //'multiple' => true,
                'expanded'=>true,
                'required'=>true,
    
    
            ])

         
           // ->add('limit_cost')
            //->add('total_cost')
           // ->add('commander')
/*---------------------------V1-------------------------------------------------------*/           
         ->add('linkCombatUnit', EntityType::class, [
            'class'=>CombatUnit::class,
            'choice_label'=>'cardVerso',
            "attr"=>[
                'class'=>'form-control',
                ],
            'placeholder'=>'choisir unité de combat',    
            'choice_attr'=>function($choice) {
                return ['data-faction' => $choice->getFaction()->getId()];
            },

            'label_attr'=>['class'=>'me-1'],
            'label'=>'Choisir une unité de combat',
            'multiple' => true,
            'expanded'=>true,
            'required'=>false,


        ])
/*------------------------------------------------------------------------------------*/
/*-------------------V2---------------------------------------------------------------*/ 
/*         ->add('linkCombatUnit', ChoiceType::class, [
            'placeholder'=>'Choisir une unité de combat',

        ]) */
/*-------------------------------------------------------------------------------------*/
        ->add('secondary_stuff_add_btn', SubmitType::class, [
                'attr' => ['class' => 'secondary_stuff_add_btn'],
                'label' => 'Add Item',
            ])

          ->add('linkNCU', EntityType::class, [
              "attr"=>[
                  'class'=>'form-control',
                  ],
              'class'=>NoCombatUnit::class,
              'choice_label'=>'cardVerso',
              'choice_attr'=>function($choice) {
                return ['data-faction' => $choice->getFaction()->getId()];
                 },
              'label_attr'=>['class'=>'me-1'],
              'label'=>'Choisir une unité non combattante',
              'multiple' => true,
              'expanded'=>true,
              'required'=>false,
          ])
            ->add('tertiary_stuff_add_btn', SubmitType::class, [
                'attr' => ['class' => 'tertiary_stuff_add_btn'],
                'label' => 'Add Item',
            ])
            ->add('save', SubmitType::class, [
                'attr' => ['class' => 'save'],
                'label' => 'Save',
            ]);
/*----------------------V2-------------------------------------------------------------------*/            
/*             $formModifier = function(FormInterface $form, Faction $faction = null){
                $CUlist = null ===  $faction ? [] : $faction->getCombatUnits(); 
                $form->add('linkCombatUnit', EntityType::class, [
                    'class'=> CombatUnit::class,
                    'choices'=>$Culist,
                    "attr"=>[
                        'class'=>'form-control',
                        ],
                        'choice_label'=>'name',
              
                        'label_attr'=>['class'=>'me-1'],
                        'label'=>'Choisir une unité de combat',
                        'multiple' => true,
                       'expanded'=>true,
                        'required'=>false,
                    ]);
            };  
             $builder->get('faction')->addEventListener(
                FormEvents::POST_SUBMIT,
                function(formEvent $event) use ($formModifier){
                    $faction=$event->getForm()->getData();
                    $formModifier($event->getForm()->getParent(), $faction);

                }
            );
 */
/*-------------------------------------------------------------------------------------------------*/
/*-------------------------------------V3----------------------------------------------------------*/            
 

/*             $formModifier = function (FormInterface $form, Faction $faction = null){
                $CUlist = null === $faction ? [] : $faction->getCombatUnits();
                var_dump($CUlist);
                $form->add('linkCombatUnit', EntityType::class, [
                    'class'=>CombatUnit::class,
                    'placeholder'=>'',
                    'choices'=>$CUlist,
                    'choice_label'=>'name',
                    'multiple' => true,
                    'expanded'=>true,
                     'required'=>false,
                    'mapped'=>false,
                ]);
            };
            $builder->addEventListener(
                FormEvents::PRE_SET_DATA,
                function (FormEvent $event) use ($formModifier) {
                    $data=$event->getData();
                    $formModifier($event->getForm(), $data->getFaction());
                }

            );
            $builder->get('faction')->addEventListener(
                FormEvents::POST_SUBMIT,
                function (FormEvent $event) use ($formModifier){
                    $faction = $event->getForm()->getData();
                    $formModifier($event->getForm()->getParent(), $faction);
                }
            );
            $builder->setAction($options['action']);  */

/*---------------------------------------------------------------------------------------------------------------*/
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([

            'data_class' => Army::class,
        ]);
    }
}
