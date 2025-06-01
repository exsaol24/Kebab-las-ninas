<?php

namespace App\Form;

use App\Entity\Platos;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Categorias;

class PlatosType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // Usa EntityType para relaciones ManyToOne con Categorias
            ->add('categoria', EntityType::class, [
                'class' => Categorias::class,
                'choice_label' => 'nombre',
                'label' => 'Categoría',
                'required' => false,
                'placeholder' => 'Selecciona una categoría',
            ])
            ->add('nombre', TextType::class, [
                'label' => 'Nombre',
            ])
            ->add('descripcion', TextareaType::class, [
                'label' => 'Descripción',
            ])
            ->add('precio', MoneyType::class, [
                'label' => 'Precio',
                'currency' => 'EUR',
            ])
            ->add('imagen', FileType::class, [
                'label' => 'Imagen (JPG, PNG, etc.)',
                'mapped' => false,
                'required' => false,
            ])
            ->add('ingredientes', TextType::class, [
                'label' => 'Ingredientes',
                'required' => false,
            ])
            ->add('alergenos', TextType::class, [
                'label' => 'Alergenos',
                'required' => false,
            ])
            ->add('disponible', CheckboxType::class, [
                'label' => 'Disponible',
                'required' => false,
            ])
            ->add('creadoen', DateTimeType::class, [
                'label' => 'Creado en',
                'widget' => 'single_text',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Platos::class,
        ]);
    }
}
