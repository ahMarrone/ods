<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ObjetivosType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('codigo', null, array(
                    'disabled' => $options['disable_form'],
                )
            )
            ->add('descripcion', TextareaType::class, array(
                      'label' => 'Descripción', 'attr' => array('maxlength' => 500, 'rows' => 4)
                )
            )

        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Objetivos',
            'disable_form' => false,
        ));
    }
}
