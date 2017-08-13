<?php

namespace AppBundle\Form;

use Symfony\Component\Validator\Context\ExecutionContext;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

use Symfony\Component\Validator\Constraints as Assert;

class IndicadoresType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->em = $options['entity_manager'];
        $this->indicador = $builder->getData();
        $tipoSeleccionado = $options['data']->getTipo();
        $ambitoSeleccionado = $options['data']->getAmbito();
        $this->scoped_enabled = $options['scopes_enabled'];
        $this->last_code_used = $options['last_code_used'];
        $builder
            ->add('fkidmeta','hidden',array('mapped'=>false))
            ->add('codigo', TextType::class, array(
                'label' => 'Código del indicador', 'attr' => array(
                    'class' => 'col-sm-1',
                    'maxlength' => 4
                )                 
            ))                        
            ->add('descripcion', TextareaType::class , array('label'  => 'Descripción', 'attr' => array('maxlength' => 500, 'rows' => 4),))
            ->add('tipo', ChoiceType::class, array('label'  => 'Tipo', 'expanded'=>true, 'required'=>true, 'choices' => array('Porcentual' => 'porcentual', 'Entero' => 'entero', 'Real' => 'real', ), 'data' => $tipoSeleccionado, 'choices_as_values' => true, ))
            ->add('valmin', IntegerType::class , array(
                'label'  => 'Valor Mínimo ', 
                'attr' => array(
                    'class' => 'col-sm-2 input-user-entry range-input-entry',
                    'step'=>'1',
                    'max_length' => 10,
                )
            ))
            ->add('valmax', IntegerType::class , array(
                'label'  => 'Valor Máximo ',
                'attr' => array(
                    'class' => 'col-sm-2 input-user-entry range-input-entry',
                    'step' => 1,
                )
            ))
            ->add('ambito', ChoiceType::class, array(
                'label'  => 'Ámbito', 
                'expanded'=>true, 
                'required'=>true, 
                'choices' => array('Nacional' => 'N', 'Provincial' => 'P', 'Departamental' => 'D'), 
                //'data' => $ambitoSeleccionado, 
                'choices_as_values' => true,
            ))
            ->add('scoped_enabled', HiddenType::class, array(
                'empty_data' => $this->scoped_enabled,
                'mapped'=> false
            ))
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
            ->add('fechametaintermedia', TextType::class, array(
                'attr' => ['class' => 'col-sm-2 expected-value-datepicker'],
                'label' => 'Año meta intermedia',
                'required'=>false,
            ))
            ->add('valoresperadometaintermedia', TextType::class, array(
                'label'=>'Valor esperado meta intermedia', 
                'required'=>false, 
                'attr' => array(
                    'class' => 'col-sm-2 expected-value-input input-user-entry',
                    'step' => 1,
                    )
                ))             
            ->add('fechametafinal', TextType::class, array(
                'attr' => ['class' => 'col-sm-2 expected-value-datepicker'],
                'label' => 'Año meta final',
                'required'=>false,
            ))
            ->add('valoresperadometafinal', TextType::class , array(
                'label'=> 'Valor esperado meta final', 
                'required'=>false,  
                'attr' => array(
                    'class' => 'col-sm-2 expected-value-input input-user-entry',
                    'step' => 1,
                    )
                ))
            ->add('documentpath', FileType::class, array('label' => 'Documento técnico (archivo PDF)', 'required'=>false))
            ->add('last_code_used', HiddenType::class, array(
                'empty_data' => $this->last_code_used,
                'mapped'=> false
            ))
             
        ;
    }

    // Se debe validar:
    //      - el código del indicador.
    //      - que las fecha de meta final sea mayor a la fecha de meta intermedia
    public function validateNewIndicador($indicador, ExecutionContext $context){
        $idMeta = $indicador->getFkidmeta()->getId();
        $codigo = $indicador->formatCodigo($indicador->getCodigo());
        if (($this->last_code_used == null && $this->codeAlreadyUsed($idMeta, $codigo)) ||
           ($this->last_code_used != null && $indicador->formatCodigo($this->last_code_used)  != $codigo && $this->codeAlreadyUsed($idMeta, $codigo)))
        {
            $context->addViolationAt('codigo', 'El código de indicador para esta meta ya está utilizado!');
        }
        /*if (!$this->checkValidDates($indicador->getFechametaintermedia(), $indicador->getFechametafinal())){
            $context->addViolationAt('fechametafinal',"El año de la meta final debe ser posterior al año de meta intermedia");
        }*/
    }

    private function checkValidDates($fechaIntermedia, $fechaFinal){
        $fechaIntermedia = (int) $fechaIntermedia;
        $fechaFinal = (int) $fechaFinal;
        return $fechaIntermedia < $fechaFinal;
    }

    private function codeAlreadyUsed($idMeta, $codigoIndicador){
        $entity = $this->em->createQueryBuilder()
            ->select('e.id')
            ->from('AppBundle:Indicadores', 'e')
            ->where('e.fkidmeta = ?1 AND e.codigo = ?2')
            ->setParameters(array(1 => $idMeta, 2 => $codigoIndicador))
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
            'data_class' => 'AppBundle\Entity\Indicadores',
            'allow_extra_fields' => true,
            'scopes_enabled' => true,
            'last_code_used' => null,
            'constraints' => array(
               new Assert\Callback(array($this, 'validateNewIndicador'))
              ),
            'entity_manager' => null,
        ));
    }  
}
