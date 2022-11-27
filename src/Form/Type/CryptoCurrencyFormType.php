<?php

declare(strict_types=1);

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;

final class CryptoCurrencyFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('quantity', NumberType::class, [
                'attr' => [
                    'data-target' => 'crypto-currency-converter.quantity',
                    'data-action' => 'crypto-currency-converter#changePrice'
                ]
            ])
            ->add('price', MoneyType::class, [
                'currency' => 'USD',
                'attr' => [
                    'data-target' => 'crypto-currency-converter.price',
                    'data-action' => 'crypto-currency-converter#changeQuantity'
                ]
            ]);
    }
}