<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UsuariosType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username')
            ->add('apellido')
            ->add('nombre')
            ->add('email')
            ->add('domicilio')
            ->add('localidad')
            ->add('provincia')
            ->add('telefono')
            ->add('dependencia')
            ->add('observaciones')
            ->add('rol')
            ->add('isactive')
            ->add('idRefgeografica')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Usuarios'
        ));
    }
}
