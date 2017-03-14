<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use FOS\UserBundle\Util\LegacyFormHelper;

class UserProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('apellido', null, array('attr' => array('class' => 'col-sm-6', 'maxlength' => 50)))       
            ->add('nombre', null, array('attr' => array('class' => 'col-sm-6', 'maxlength' => 50)))
            ->add('roles', 'choice', array(
                'mapped' => false,
                'required' => true,
                'label'    => 'Rol de usuario',
                'choices' => array(
                    'ROLE_ADMIN' => 'Administrador',
                    'ROLE_USER' => 'Data entry',
                ),
                'disabled' => false,
                'expanded'   => true,
            ))
            ->add('domicilio', null, array('attr' => array('class' => 'col-sm-6', 'maxlength' => 100)))
            ->add('localidad', null, array('attr' => array('class' => 'col-sm-6', 'maxlength' => 100)))
            ->add('provincia', null, array('attr' => array('class' => 'col-sm-6', 'maxlength' => 100)))
            ->add('telefono', null, array('attr' => array('class' => 'col-sm-6', 'maxlength' => 50)))
            ->add('dependencia', null, array('attr' => array('class' => 'col-sm-12', 'maxlength' => 100)))
            ->add('observaciones', null, array('attr' => array('maxlength' => 250),));
    }

    public function getBlockPrefix()
    {
        return 'app_user_profile';
    }

    // For Symfony 2.x
    public function getName()
    {
        return $this->getBlockPrefix();
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Usuarios',
        ));
    }

}
