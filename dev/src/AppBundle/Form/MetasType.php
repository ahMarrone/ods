<?php

namespace AppBundle\Form;

use Symfony\Component\Validator\Context\ExecutionContext;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
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
        $this->last_code_used = $options['last_code_used'];
        $this->em = $options['entity_manager'];
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
                  'label' => "Código de meta", 'attr' => array('class' => 'col-sm-1')
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
            ->add('last_code_used', HiddenType::class, array(
                'empty_data' => $this->last_code_used,
                'mapped'=> false
            ))
        ;
    }

    public function validateNewMeta($meta, ExecutionContext $context)
    {
        $idObjetivo = $meta->getFkidobjetivo()->getId();
        $codigo = $meta->getCodigo();
        if (($this->last_code_used == null && $this->codeAlreadyUsed($idObjetivo, $codigo)) ||
           ($this->last_code_used != null && $this->last_code_used != $codigo && $this->codeAlreadyUsed($idObjetivo, $codigo)))
        {
            $context->addViolationAt('codigo', 'El código de meta para este objetivo ya está utilizado!');
        }
    }

    private function codeAlreadyUsed($idObjetivo, $codigoMeta){
        $entity = $this->em->createQueryBuilder()
            ->select('e.id')
            ->from('AppBundle:Metas', 'e')
            ->where('e.fkidobjetivo = ?1 AND e.codigo = ?2')
            ->setParameters(array(1 => $idObjetivo, 2 => $codigoMeta))
            ->getQuery()
            ->getResult();
        if (count($entity)){
          return true;
        } else {
          return false;
        }
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Metas',
            'constraints' => array(
               new Assert\Callback(array($this, 'validateNewMeta'))
              ),
            'scopes_enabled' => array(),
            'last_code_used' => null,
            'entity_manager' => null,
        ));
    }
}
