<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('fullName', TextType::class, [
                'label' => 'Full Name',
                'attr' => ['placeholder' => 'Enter full name', 'class' => 'form-control'],
                'required' => true,
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email Address',
                'attr' => ['placeholder' => 'Enter email', 'class' => 'form-control'],
                'required' => true,
            ])
            ->add('password', PasswordType::class, [
                'label' => 'Password',
                'attr' => ['placeholder' => 'Enter password', 'class' => 'form-control'],
                'required' => true,
            ])
            ->add('role', ChoiceType::class, [
                'label' => 'User Role',
                'choices'  => [
                    'ADMIN' => 'ROLE_ADMIN',
                    'Client' => 'ROLE_CLIENT',
                ],
                'expanded' => false, // Dropdown (set to true for radio buttons)
                'multiple' => false, // Single selection
                'attr' => ['class' => 'form-select'],
                'required' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
