<?php

namespace App\Form;

use App\Entity\Quiz;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuizType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Matiere', TextType::class, [
                'label' => 'Matière',
            ])
            ->add('quest1', TextareaType::class, [
                'label' => 'Question 1',
            ])
            ->add('quest2', TextareaType::class, [
                'label' => 'Question 2',
            ])
            ->add('quest3', TextareaType::class, [
                'label' => 'Question 3',
            ])
            ->add('correctAnswer1', TextType::class, [
                'label' => 'Réponse correcte 1',
            ])
            ->add('correctAnswer2', TextType::class, [
                'label' => 'Réponse correcte 2',
            ])
            ->add('correctAnswer3', TextType::class, [
                'label' => 'Réponse correcte 3',
            ])
            ->add('diff', ChoiceType::class, [
                'label' => 'Difficulté',
                'choices' => [
                    'Facile' => 'easy',
                    'Moyen' => 'medium',
                    'Difficile' => 'hard',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Quiz::class,
        ]);
    }
}