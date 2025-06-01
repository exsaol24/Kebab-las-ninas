<?php

namespace App\Form;

use App\Entity\Pedidos;
use App\Entity\Usuarios;
use App\Entity\Estadospedidos;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PedidosType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('usuarios', EntityType::class, [
                'class' => Usuarios::class,
                'choice_label' => 'nombre',
                'label' => 'Usuario',
            ])
            ->add('direccionentrega', TextType::class, [
                'label' => 'Dirección de entrega',
            ])
            ->add('total', MoneyType::class, [
                'currency' => 'EUR',
                'label' => 'Total',
            ])
            ->add('metodopago', TextType::class, [
                'label' => 'Método de pago',
            ])
            ->add('fechapedido', DateTimeType::class, [
                'widget' => 'single_text',
                'label' => 'Fecha del pedido',
            ])
            ->add('estado', EntityType::class, [
                'class' => Estadospedidos::class,
                'choice_label' => 'nombre',
                'label' => 'Estado',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Pedidos::class,
        ]);
    }
}
