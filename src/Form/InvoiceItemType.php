<?php

namespace App\Form;

use App\Entity\InvoiceItem;
use App\Entity\Product;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InvoiceItemType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('product', EntityType::class, [
                'class' => Product::class,
                'label' => 'Select a product',
                'choice_label' => 'name',
                'multiple' => false,
                'attr' => ['class' => 'item-name form-control me-2'],
            ])
            ->add('quantity', IntegerType::class, [
                'label' => 'Select quantity',
                'attr' => ['class' => 'item-quantity form-control ms-2 me-2 w-50', 'min' => 1],
            ])
            ->add('productPrice', NumberType::class, [
                'attr' => ['class' => 'item-cost form-control ms-2 me-2','readonly' => true],
                'data' => 0
            ])
            ->add('discount', NumberType::class, [
                'attr' => ['class' => 'item-discount form-control ms-2 me-2','readonly' => true],
                'mapped' => false,
                'data' => 0
            ])
            ->add('price', NumberType::class, [
                'label' => 'Final price',
                'attr' => ['class' => 'item-price form-control ms-2 me-2','readonly' => true],
                'data' => 0
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => InvoiceItem::class,
        ]);
    }
}
