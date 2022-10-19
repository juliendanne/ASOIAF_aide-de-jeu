<?php

namespace App\Form;

use App\Entity\NbJoueur;
use App\Entity\TournamentGame;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TournamentGameType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            //->add('nbJoueur')
            ->add('nbJoueur', EntityType::class, [
                'class'=>NbJoueur::class,
                'choice_label'=>'nb',
                'multiple'=>true,
                'expanded'=>true,
                'label'=>'nb joueur',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TournamentGame::class,
        ]);
    }
}
