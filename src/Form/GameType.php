<?php

namespace App\Form;

use App\Entity\Game;
use App\Entity\Region;
use App\Entity\NbJoueur;
use App\Entity\TournamentGame;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
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
            // j'ai regroupé les propriétés  date et time dans une seule, et je l'ai mis en "nullable=true" (voire l'entity Game).Sinon, la requête Ajax en JQuery retourne une erreur 500
            ->add('date', DateTimeType::class,[
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
                'choices'=>[
                    '1 VS 1'=>'1vs1',
                    '2 VS 2'=>'2vs2',
                    '3 VS 3'=>'3vs3',
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
                    '1 ronde'=>1,
                    '2 rondes'=>2,
                    '3 rondes'=>3,
                    '4 rondes'=>4,
                    ],
                ])
           ->add('region', EntityType::class, [
                'class'=>Region::class,
                'choice_label'=>'name',
                'label'=>'Région',
            ])
            // tournamentGame est maintenant de type relation (voire en tity du même nom)
            ->add('tournamentGame', EntityType::class, [
                'class' => TournamentGame::class,
                'choice_label' => 'name',
                "attr"=>[
                    'class'=>'ms-2',
                ],
                'label'=>'Mode : ',
                'placeholder' => '',
            ])
        ;

        // j'ai aussi implémenter une classe NbJoueur qui fait le lien avec GameTournament et Game. c'est l'équivalent de l'entity Position dans la doc Symfony (https://symfony.com/doc/current/form/dynamic_form_modification.html)

        // ici on commence à implémenter sur le modèle Sport/Positions de la doc Symfony (voire https://symfony.com/doc/current/form/dynamic_form_modification.html)

        //--------------------------------------------
        $formModifier = function(FormInterface $form, TournamentGame $tournamentGame = null) {
            $nbJoueur = null === $tournamentGame ? [] : $tournamentGame->getNbJoueur();
            $form->add('nbPlayer', EntityType::class, [
                        'class' => NbJoueur::class,
                        'placeholder' => '',
                        'choices' => $nbJoueur,
                        'choice_label' => 'nb',
                    ]);
        };

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function(FormEvent $event) use ($formModifier){
                $data = $event->getData();
                $formModifier($event->getForm(), $data->getTournamentGame());
            }
        );

        $builder->get('tournamentGame')->addEventListener(
            FormEvents::POST_SUBMIT,
            function(FormEvent $event) use ($formModifier) {
                $tournamentGame = $event->getForm()->getData();
                $formModifier($event->getForm()->getParent(), $tournamentGame);
            }
        );
        //--------------------------------------------

  
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Game::class,
        ]);
    }
}
