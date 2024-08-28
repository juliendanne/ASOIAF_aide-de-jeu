<?php

namespace App\Form;

use App\Entity\Game;
use App\Entity\Region;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class GameType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
            "attr"=>[
                'class'=>'form-control',
                ],
            'label'=>'Titre',
            ])
            ->add('description', TextareaType::class, [
            "attr"=>[
                'class'=>'form-control',
                ],
            'label'=>'Description',
            ])
            ->add('date', DateType::class,[
                "attr"=>[
                    'class'=>'form-control',
                ],
                'label'=>'Date*',
                'widget' => 'choice',
                'years' => range(date('Y')+0,date('Y')+1)
            ])
            ->add('authorIsPlayer', CheckboxType::class, [
                "attr"=>[
                    'class'=>'ms-2',
    
                ],
                'label'=>'Je participe à la partie',
                'mapped' => true,
                'required' => false
            ])
            ->add('format', ChoiceType::class,[
                'label'=>'Format de joueurs',
                'choices'=>[
                    '1 VS 1'=>1,
                    '2 VS 2'=>2,
                    '3 VS 3'=>3,
                ],
                'multiple'=>false,
            ])
            ->add('time', TimeType::class)
            ->add('nbOfTeam', ChoiceType::class,[
               'label' => 'Nombre d\'équipes',
               'choices'=>[
                   '2 équipes'=>2,
                   '4 équipes'=>4,
                   '6 équipes'=>6,
                   '8 équipes'=>8,
                   '10 équipes'=>10,
                ],
            ])
            ->add('address', TextType::class, [
                "attr"=>[
                    'class'=>'form-control',
                ],
                'label'=>'Adresse*',
            ])
            ->add('zipCode', IntegerType::class, [
                "attr"=>[
                    'class'=>'form-control',
                ],
                'label'=>'Code postal*',
            ])
            ->add('city', TextType::class, [
                "attr"=>[
                    'class'=>'form-control',
                ],
                'label'=>'Ville*',
            ])
            ->add('department', TextType::class, [
                "attr"=>[
                    'class'=>'form-control',
                ],
                'label'=>'Département',
                "required" => false
            ])
            ->add('nbOfGame', ChoiceType::class,[
                'label' => 'Nombre de rondes',
                'choices'=>[
                    '1 rondes'=>1,
                    '2 rondes'=>2,
                    '3 rondes'=>3,
                    '4 rondes'=>4,
                ],
            ])
           // ->add('playersjoined')
            ->add('region', EntityType::class, [
                'class'=>Region::class,
                'choice_label'=>'name',
                'label_attr'=>['class'=>'me-1'],
                'label'=>'Région',
                //'mapped'=>false
            ])
            ->add('tournamentGame', ChoiceType::class, [
                'choices' => [
                    'oui'=>true,
                    'non'=>false,
                ],
                'expanded'=>false,
                "attr"=>[
                    'class'=>'ms-2',
                                ],
                'multiple'=> false,
                'label'=>'Mode Tournoi',
            ])
            ->add('nbTotalPlayer', ChoiceType::class,[
                'label' => 'Nombres de joueurs',
                'choices'=>[
                    '2 joueurs'=>2,
                    '4 joueurs'=>4,
                    '6 joueurs'=>6,
                    '8 joueurs'=>8,
                    '10 joueurs'=>10,
                    '12 joueurs'=>12,
                    '14 joueurs'=>14,
                    '16 joueurs'=>16,
                    '18 joueurs'=>18,
                    '20 joueurs'=>20,
                    '24 joueurs'=>24,
                    '30 joueurs'=>30,
                ],
                'expanded'=>'true',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Game::class,
        ]);
    }
}
