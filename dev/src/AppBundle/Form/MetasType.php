<?php

namespace AppBundle\Form;

use Symfony\Component\Validator\Context\ExecutionContext;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;


use Symfony\Component\Validator\Constraints as Assert;

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
            ->add('fkidobjetivo', EntityType::class, array(
                          'class' => 'AppBundle:Objetivos',
                          'choice_label' => function ($objetivo) {
                              return $objetivo->getDisplayName();
                          },
                          'label'=> "Objetivo",
                    )
            )
            ->add('codigo', IntegerType::class, array(
                  'label' => "Código de meta",
                  'constraints' => array(
                      new Assert\Callback(array($this, 'validateEventDates'))
                  )
            )
            )
            ->add('descripcion', TextType::class, array(
                      'label' => 'Descripción'
                )
            )
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
        ;
    }

    public function validateEventDates($meta, ExecutionContext $context)
    {
        //$idObjetivo = $m
        $context->addViolationAt('codigo', 'El codigo ya está utilizado!');
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Metas',
            'constraints' => array(
               new Assert\Callback(array($this, 'validateEventDates'))
              ),
            'scopes_enabled' => array(),
        ));
    }
}
