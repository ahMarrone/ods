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

class DesglocesPorIndicadorType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this_indicador = $options['idIndicador'];
        $choice_desgloces = array();


        $all_etiquetas = $options['label'];
        $this->desgloces_seleccionados = $options['desgloces_seleccionados'];


        foreach ($options['data'] as $key => $value) {
            $this_id = $value->getId();
            $newkey = $this_id . ". ". $value->getDescripcion();

            $this_etiquetas = "";
            if (isset($all_etiquetas[$this_id]))
            {
                $this_etiquetas = " " . $all_etiquetas[$this_id];
            }
            $choice_desgloces[$key]="". $newkey . $this_etiquetas;
        }
        $builder
            ->add('desglocesSeleccionados',  ChoiceType::class, array(
                                            'mapped' => false, 
                                            'label'  => 'Desgloces', 
                                            'required'=>true, 
                                            'choices' => $choice_desgloces,
                                            'choice_attr' => function($key, $val, $index) {
                                                return in_array($key, $this->desgloces_seleccionados)? ['disabled' => 'disabled'] : [];
                                             },
                                            'expanded'=>true, 
                                            'multiple'=>true, 
                                            'data' => $this->desgloces_seleccionados // siempre la opcion cero (Sin desgloces esta seleccionada)
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
            //'data_class' => 'AppBundle\Entity\Desgloces',
            'idIndicador' => null,
            'desgloces_seleccionados' => array(),
        ));
    } 
}
