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
            ->add('username', null, array('label' => 'Nombre de usuario', 'translation_domain' => 'FOSUserBundle'))
            ->add('email', LegacyFormHelper::getType('Symfony\Component\Form\Extension\Core\Type\EmailType'), array('label' => 'Email', 'translation_domain' => 'FOSUserBundle'))
            ->add('plainPassword', LegacyFormHelper::getType('Symfony\Component\Form\Extension\Core\Type\RepeatedType'), array(
                'type' => LegacyFormHelper::getType('Symfony\Component\Form\Extension\Core\Type\PasswordType'),
                'options' => array('translation_domain' => 'FOSUserBundle'),
                'first_options' => array('label' => 'Password'),
                'second_options' => array('label' => 'Confirmar password'),
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
            ->add('apellido')
            ->add('nombre')
            ->add('domicilio')
            ->add('localidad')
            ->add('provincia')
            ->add('telefono')
            ->add('dependencia')
            ->add('observaciones');

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