<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserAdminType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder
        ->add('email', EmailType::class, [
            "attr"=>[
                'class'=>'form-control',
                
            ],
            'label'=>'Email',
            'invalid_message'=>'Entrez une adresse valide'
        ])
        ->add('name', TextType::class, [
            "attr"=>[
                'class'=>'form-control',
                
            ],
            'label'=>'Nom',
        ])
        ->add('firstname', TextType::class, [
            "attr"=>[
                'class'=>'form-control',
                
            ],
            'label'=>'Prénom',
        ])
        ->add('login', TextType::class, [
            "attr"=>[
                'class'=>'form-control',
                
            ],
            'label'=>'Login',
        ])
        ->add('birthDate', DateType::class,[
            "attr"=>[
                'class'=>'form-control',
            ],
            'label'=>'Entrez votre date de naissance',
            'widget' => 'choice',
            'years' => range(date('Y')-100,date('Y')-18)
        ])
/*         ->add('agreeTerms', CheckboxType::class, [
            'mapped' => false,
            'constraints' => [
                new IsTrue([
                    'message' => 'You should agree to our terms.',
                ]),
            ],
        ]) */
        ->add('statut', ChoiceType::class,[
            'label' => 'Choisissez un statut :',
            'choices' => [
                'Valider' => false,
                
                'Desactiver' => true,
            ],
            'choice_attr' => [
                'Valider' => ['class'=>'me-1'],
                
                'Desactiver' => ['class'=>'ms-3 me-1'],
            ],
            'multiple' => false,
            'expanded' => true,
            'attr' => [
                'class' => 'form-control'
            ]
        ])
    ;
        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
