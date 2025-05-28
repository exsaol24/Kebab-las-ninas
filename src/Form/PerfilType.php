<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Usuarios;

class PerfilType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('direccion', TextType::class, [
                'label' => 'Dirección',
                'required' => false,
                'attr' => [
                    'pattern' => '^[A-Za-z0-9ÁÉÍÓÚáéíóúÑñ\s\.,\-ºª#]{5,100}$',
                    'title' => 'La dirección debe tener entre 5 y 100 caracteres'
                ]
            ])
            ->add('telefono', TelType::class, [
                'label' => 'Teléfono',
                'required' => false,
                'attr' => [
                    'pattern' => '^\d{9}$',
                    'title' => 'El teléfono debe tener 9 dígitos'
                ]
            ])
            ->add('plainPassword', PasswordType::class, [
                'label' => 'Nueva contraseña',
                'required' => false,
                'mapped' => false,
                'attr' => [
                    'pattern' => '^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$',
                    'title' => 'Mínimo 8 caracteres, una mayúscula, una minúscula, un número y un carácter especial'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Usuarios::class,
        ]);
    }
}