<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class UserType22 extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('fullName', TextType::class, [
                'label' => 'Full Name',
                'attr' => ['placeholder' => 'Enter full name', 'class' => 'form-control'],
                'required' => true,
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Full Name is required.',
                    ]),
                    new Assert\Length([
                        'min' => 3,
                        'max' => 50,
                        'minMessage' => 'Full Name must be at least {{ limit }} characters long',
                        'maxMessage' => 'Full Name cannot be longer than {{ limit }} characters',
                    ]),
                ],
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email Address',
                'attr' => ['placeholder' => 'Enter email', 'class' => 'form-control'],
                'required' => true,
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Email is required.',
                    ]),
                    new Assert\Email([
                        'message' => 'Please enter a valid email address.',
                    ]),
                ],
            ])
            ->add('password', PasswordType::class, [
                'label' => 'Password',
                'attr' => ['placeholder' => 'Enter password', 'class' => 'form-control'],
                'required' => true,
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Password is required.',
                    ]),
                    new Assert\Length([
                        'min' => 6,
                        'minMessage' => 'Password must be at least {{ limit }} characters long',
                    ]),
                ],
            ])
            ->add('role', HiddenType::class, [
                'data' => 'ROLE_CLIENT',  // Set default value for the role
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}

