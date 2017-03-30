<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use FOS\UserBundle\Util\LegacyFormHelper;

class UserRequestPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', null, array('label' => 'Nombre de Usuario', 'attr' => array('class' => 'col-sm-3', 'maxlength' => 50, 'readonly' => true), 'translation_domain' => 'FOSUserBundle'))
            ->add('email', LegacyFormHelper::getType('Symfony\Component\Form\Extension\Core\Type\EmailType'), array('label' => 'E-mail', 'attr' => array('class' => 'col-sm-3', 'maxlength' => 50, 'readonly' => true), 'translation_domain' => 'FOSUserBundle'));
    }

    public function getBlockPrefix()
    {
        return 'app_user_request_password';
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
