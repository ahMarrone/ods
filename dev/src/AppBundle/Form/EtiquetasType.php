<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class EtiquetasType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fkiddesgloce', EntityType::class, array(
                    'class' => 'AppBundle:Desgloces',
                    'label'=> "Desglose",
                    'choice_attr' => function($key, $val, $index) {
                        return $index ? [] : ['disabled' => 'disabled'];
                    },
            ))
            ->add('descripcion')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Etiquetas'
        ));
    }
}
