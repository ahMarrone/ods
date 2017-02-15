<?php
// src/AppBundle/Form/RegistrationType.php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;


use FOS\UserBundle\Util\LegacyFormHelper;

class UserRegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', LegacyFormHelper::getType('Symfony\Component\Form\Extension\Core\Type\EmailType'), array('label' => 'Email', 'attr' => array('class' => 'col-sm-4', 'maxlength' => 50), 'translation_domain' => 'FOSUserBundle'))
            ->add('username', null, array('label' => 'Nombre de usuario', 'attr' => array('class' => 'col-sm-3', 'maxlength' => 50), 'translation_domain' => 'FOSUserBundle'))
            ->add('plainPassword', LegacyFormHelper::getType('Symfony\Component\Form\Extension\Core\Type\RepeatedType'), array(
                'type' => LegacyFormHelper::getType('Symfony\Component\Form\Extension\Core\Type\PasswordType'),
                'options' => array('translation_domain' => 'FOSUserBundle'),
                'first_options' => array('label' => 'Clave', 'attr' => array('class' => 'col-sm-3', 'maxlength' => 50),),
                'second_options' => array('label' => 'Confirmar clave', 'attr' => array('class' => 'col-sm-3', 'maxlength' => 50),),
                'invalid_message' => 'fos_user.password.mismatch',
            ))
            ->add('roles', 'choice', array(
                'mapped' => false,
                'required' => true,
                'label'    => 'Rol de usuario',
                'choices' => array(
                    'ROLE_ADMIN' => 'Administrador',
                    'ROLE_USER' => 'Data entry',
                ),
                'expanded'   => true,
            ))
            ->add('apellido', null, array('attr' => array('class' => 'col-sm-6', 'maxlength' => 50)))       
            ->add('nombre', null, array('attr' => array('class' => 'col-sm-6', 'maxlength' => 50)))
            ->add('domicilio', null, array('attr' => array('class' => 'col-sm-6', 'maxlength' => 100)))
            ->add('localidad', null, array('attr' => array('class' => 'col-sm-6', 'maxlength' => 100)))
            ->add('provincia', null, array('attr' => array('class' => 'col-sm-6', 'maxlength' => 100)))
            ->add('telefono', null, array('attr' => array('class' => 'col-sm-6', 'maxlength' => 50)))
            ->add('dependencia', null, array('attr' => array('class' => 'col-sm-12', 'maxlength' => 100)))
            ->add('observaciones', null, array('attr' => array('maxlength' => 250),));
            

    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';

        // Or for Symfony < 2.8
        // return 'fos_user_registration';
    }

    public function getBlockPrefix()
    {
        return 'app_user_registration';
    }

    // For Symfony 2.x
    public function getName()
    {
        return $this->getBlockPrefix();
    }
}
