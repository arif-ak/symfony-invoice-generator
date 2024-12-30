<?php

namespace App\Form;

use App\Entity\Invoice;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InvoiceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('invoiceItems',CollectionType::class,[
                'entry_type' => InvoiceItemType::class,
                'entry_options' => ['label' => false],
                'prototype_options'  => [
                    'attr' => ['class' => 'd-flex'],
                ],
                'allow_add' => true,
                'allow_delete' => true,
                'label' => ' ',
            ])
            ->add('paymentType', ChoiceType::class, [
                'choices' => ['Cash' => 'cash', 'Card' => 'card'],
                'attr' => ['class' => 'form-control'],
                'label' => 'Payment type',
                'expanded' => true,
            ])
            ->add('discountPercentage', IntegerType::class, [
                'label' => 'Discount percentage',
                'attr' => ['class' => 'invoice-discount form-control', 'min' => 0, 'max' => 99],
                'data' => 0,
            ])
            ->add('taxPercentage', IntegerType::class, [
                'label' => 'Tax percentage',
                'attr' => ['class' => 'invoice-tax form-control', 'min' => 0, 'max' => 99],
                'data' => 0,
            ])
            ->add('totalAmount', NumberType::class, [
                'label' => 'Total amount',
                'attr' => ['class' => 'invoice-price form-control', 'readonly' => true],
                'data' => 0.00
            ])
            ->add('finalAmount', NumberType::class, [
                'label' => 'Final amount',
                'attr' => ['class' => 'invoice-total form-control', 'readonly' => true],
                'data' => 0.00
            ])
            ->add('save', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-success order-button mt-4'
                ]
            ])
//            ->add('customer', EntityType::class, [
//                'class' => Customer::class,
//                'choice_label' => 'name',
//            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Invoice::class,
        ]);
    }
}
