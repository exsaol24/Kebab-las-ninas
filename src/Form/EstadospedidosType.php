<?php

namespace App\Form;

use App\Entity\Estadospedidos;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EstadospedidosType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombre', ChoiceType::class, [
                'label' => 'Estado',
                'choices' => [
                    'Pendiente' => 'Pendiente',
                    'En preparación' => 'En preparación',
                    'En reparto' => 'En reparto',
                    'Entregado' => 'Entregado',
                    'Cancelado' => 'Cancelado',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Estadospedidos::class,
        ]);
    }
}