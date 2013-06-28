<?php

namespace Provip\ProvipBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text', array(
                'label' => 'Task',
                'error_bubbling' => true,
                'attr' => array('placeholder' => 'Task')
            ))
            ->add('deadline','date',array(
                'widget' => 'single_text',
                'format' => 'dd-MM-yyyy',
                'attr' => array('class' => 'date', 'data-date-format' => 'dd-mm-yyyy', 'placeholder' => 'Deadline'),
                'label' => 'Deadline',
                'error_bubbling' => true,
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Provip\ProvipBundle\Entity\Task'
        ));
    }

    public function getName()
    {
        return 'provip_provipbundle_tasktype';
    }
}
