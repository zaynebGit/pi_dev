<?php

namespace App\Form;

use App\Entity\RespQuiz;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RespQuizType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('userAnswer1', TextareaType::class, [
                'label' => 'Réponse Question 1',
            ])
            ->add('userAnswer2', TextareaType::class, [
                'label' => 'Réponse Question 2',
            ])
            ->add('userAnswer3', TextareaType::class, [
                'label' => 'Réponse Question 3',
            ])
            ->add('rate', ChoiceType::class, [
                'label' => 'Évaluation',
                'choices' => [
                    '0 étoiles' => 0,
                    '1 étoile' => 1,
                    '2 étoiles' => 2,
                    '3 étoiles' => 3,
                    '4 étoiles' => 4,
                    '5 étoiles' => 5,
                ],
                'expanded' => true, // Render as radio buttons
                'multiple' => false, // Allow only one selection
                'attr' => [
                    'class' => 'star-rating', // Add a class for styling
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RespQuiz::class,
        ]);
    }
}