<?php

namespace App\Form;

use App\Entity\Historialventas;
use App\Entity\Pedidos;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HistorialventasType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('pedido', EntityType::class, [
                'class' => Pedidos::class,
                'choice_label' => 'id',
                'label' => 'Pedido',
            ])
            ->add('fechaventa', DateTimeType::class, [
                'widget' => 'single_text',
                'label' => 'Fecha de venta',
            ])
            ->add('total', MoneyType::class, [
                'currency' => 'EUR',
                'label' => 'Total',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Historialventas::class,
        ]);
    }
}
