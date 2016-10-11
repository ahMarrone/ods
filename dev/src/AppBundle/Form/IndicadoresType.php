<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
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
        // print_r(array_keys($options));
        // print_r("<br>*");
        // print_r($options['data']);

        $tipoSeleccionado = $options['data']->getTipo();
        $ambitoSeleccionado = $options['data']->getAmbito();

        $builder
            ->add('objetivo', EntityType::class, array('label' => 'Objetivo', 'mapped' => false, 'class' => 'AppBundle:Objetivos', 'choice_label' => 'descripcion', ))
            ->add('fkidmeta', EntityType::class, array('label' => 'Meta', 'class' => 'AppBundle:Metas', 'choice_label' => 'descripcion', ))
            ->add('descripcion', TextareaType::class , array('label'  => 'Descripción', 'attr' => array('max_length' => 10, ),))
            ->add('tipo', ChoiceType::class, array('label'  => 'Tipo', 'expanded'=>true, 'required'=>true, 'choices' => array('Porcentual' => 'porcentual', 'Entero' => 'entero', 'Real' => 'real', ), 'data' => $tipoSeleccionado, 'choices_as_values' => true, ))
            //->add('tipo', ChoiceType::class, array('label'  => 'Tipo2', 'choices_as_values' => true, ))
            ->add('valmin', NumberType::class , array('label'  => 'Valor Mínimo ', 'scale' => 2))
            ->add('valmax', IntegerType::class , array('label'  => 'Valor Máximo ', 'scale' => 2))
            //->add('ambito')
            ->add('ambito', ChoiceType::class, array('label'  => 'Ámbito', 'expanded'=>true, 'required'=>true, 'choices' => array('Nacional' => 'N', 'Provincial' => 'P', 'Municipal' => 'M', ), 'data' => $ambitoSeleccionado, 'choices_as_values' => true, ))
            //->add('visiblenacional', CheckboxType::class, array('label' => 'Show this entry publicly?', ))
            ->add('visiblenacional', 'checkbox', array('label'  => 'Nacional', 'required'  => false))   
            ->add('visibleprovincial', 'checkbox', array('label'  => 'Provincial', 'required'  => false))   
            ->add('visiblemunicipal', 'checkbox', array('label'  => 'Municipal', 'required'  => false))
            //->add('fkidmeta')
        ;




        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            // ... adding the name field if needed
            //$product = $event->getData();


             $form = $event->getForm();
             $data = $event->getData();

            echo "name: ".$form->get('objetivo')->getData();
            

            $indicador = $event->getData();

            $form = $event->getForm();
            $unmappedField = $form['objetivo']->getData();

            echo "Unmmapped: ". $unmappedField;

            $tipo = $indicador->getTipo();

            //echo $tipo;

            // echo $user['objetivo'];
            //echo var_dump(array_keys($event->getData()) );
        });
      }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Indicadores'
        ));
    }
}
