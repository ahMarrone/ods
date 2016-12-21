<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class IndicadoresType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $tipoSeleccionado = $options['data']->getTipo();
        $ambitoSeleccionado = $options['data']->getAmbito();

        $builder
            ->add('fkidmeta','hidden',array('mapped'=>false))
            ->add('descripcion', TextareaType::class , array('label'  => 'Descripción', 'attr' => array('max_length' => 10, ),))
            ->add('tipo', ChoiceType::class, array('label'  => 'Tipo', 'expanded'=>true, 'required'=>true, 'choices' => array('Porcentual' => 'porcentual', 'Entero' => 'entero', 'Real' => 'real', ), 'data' => $tipoSeleccionado, 'choices_as_values' => true, ))
            ->add('valmin', NumberType::class , array('label'  => 'Valor Mínimo ', 'scale' => 2))
            ->add('valmax', IntegerType::class , array('label'  => 'Valor Máximo ', 'scale' => 2))
            ->add('ambito', ChoiceType::class, array('label'  => 'Ámbito', 'expanded'=>true, 'required'=>true, 'choices' => array('Nacional' => 'N', 'Provincial' => 'P', 'Departamental' => 'D', ), 'data' => $ambitoSeleccionado, 'choices_as_values' => true, ))
            ->add('visible', ChoiceType::class, array(
                'choices'  => array(
                    'Si' => true,
                    'No' => false,
                ),
                'choices_as_values' => true,
                'expanded' => true,
                'multiple' => false,
            ))
            ->add('fechasdestacadas','hidden')
            //->add('visible', 'checkbox', array('label'  => 'Visible', 'required'  => false))   
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Indicadores',
            'allow_extra_fields' => true
        ));
    }  



}
