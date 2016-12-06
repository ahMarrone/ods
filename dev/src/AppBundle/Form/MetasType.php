<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class MetasType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->enabledChoices = $options['scopes_enabled'];
        $builder
            ->add('descripcion')
            ->add('ambito', ChoiceType::class, 
                  array('label'  => 'Ámbito', 
                        'expanded'=>true, 
                        'required'=>true, 
                        'choices' => array('Nacional' => 'N', 'Provincial' => 'P', 'Departamental' => 'D'), 
                        'choices_as_values' => true,
                        'choice_attr' => function($key, $val, $index) {
                            $disabled = !$this->enabledChoices[$key];
                            return $disabled ? ['disabled' => 'disabled'] : [];
                         },
                  )
            )
            ->add('fkidobjetivo')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Metas',
            'scopes_enabled' => array(),
        ));
    }
}
