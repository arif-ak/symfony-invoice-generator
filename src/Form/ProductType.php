<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Product;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;

class ProductType extends AbstractType
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
            ->add('description', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Length(
                        [
                            'min' => 3,
                            'minMessage' => 'Your description must be at least {{ limit }} characters long.',
                            'max' => 1000,
                            'maxMessage' => 'Your description must be at most {{ limit }} characters long.',
                        ]
                    )
                ]
            ])
            ->add('price', NumberType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Positive(),
                ]
            ])
            ->add('quantity', IntegerType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Positive(),
                ]
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
