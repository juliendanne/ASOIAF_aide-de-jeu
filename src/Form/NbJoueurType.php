<?php

namespace App\Form;

use App\Entity\Game;
use App\Entity\NbJoueur;
use App\Entity\TournamentGame;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NbJoueurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nb')
            //->add('tournamentGames')           
          // ->add('tournamentGames', EntityType::class, [
          //     'class'=>TournamentGame::class,
          //     'choice_label'=>'name',
          //     'multiple'=>true,
          //     'expanded'=>true,
          //     'label'=>'Mode de jeu',
          // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => NbJoueur::class,
        ]);
    }
}
