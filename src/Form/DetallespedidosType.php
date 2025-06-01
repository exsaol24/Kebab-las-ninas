<?php

namespace App\Form;

use App\Entity\Detallespedidos;
use App\Entity\Pedidos;
use App\Entity\Platos;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DetallespedidosType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('pedido', EntityType::class, [
                'class' => Pedidos::class,
                'choice_label' => 'id',
                'label' => 'Pedido',
            ])
            ->add('platos', EntityType::class, [
                'class' => Platos::class,
                'choice_label' => 'nombre',
                'label' => 'Plato',
            ])
            ->add('cantidad', IntegerType::class, [
                'label' => 'Cantidad',
            ])
            ->add('preciounitario', MoneyType::class, [
                'label' => 'Precio',
                'currency' => 'EUR',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Detallespedidos::class,
        ]);
    }
}