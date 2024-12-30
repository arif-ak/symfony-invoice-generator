<?php

namespace App\Form;

use App\Entity\Customer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class CustomerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Length(
                        [
                            'min' => 3,
                            'minMessage' => 'Your name must be at least {{ limit }} characters long.',
                            'max' => 255,
                            'maxMessage' => 'Your name must be at most {{ limit }} characters long.',
                        ]
                    ),
                ],
            ])
            ->add('email', EmailType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Email(['message' => 'Please enter a valid email address']),
                ],
            ])
            ->add('address', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Length(
                        [
                            'min' => 3,
                            'minMessage' => 'Your address must be at least {{ limit }} characters long.',
                            'max' => 1000,
                            'maxMessage' => 'Your address must be at most {{ limit }} characters long.',
                        ]
                    )
                ]
            ])
            ->add('contactNumber', TelType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Regex('/^[0-9]{10}$/')
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Customer::class,
        ]);
    }
}
