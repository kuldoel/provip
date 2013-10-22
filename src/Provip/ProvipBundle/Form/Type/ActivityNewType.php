<?php

namespace Provip\ProvipBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ActivityNewType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text', array(
                'label'          => 'Title',
                'error_bubbling' => true,
                'attr'           => array('placeholder' => 'Title of this activity')

            ))
            ->add('description', 'textarea', array(
                'label'          => 'Description',
                'error_bubbling' => true,
                'attr'           => array('placeholder' => 'Give a detailed description on what you will do')
            ))
            ->add('deadline','date',array(
                'widget'         => 'single_text',
                'format'         => 'dd-MM-yyyy',
                'attr'           => array('class' => 'date', 'data-date-format' => 'dd-mm-yyyy', 'placeholder' => 'Deadline'),
                'label'          => 'Deadline',
                'error_bubbling' => true,
            ))
            ->add('nbrOfOccurrences', 'integer', array(
                'label'          => 'Occurences',
                'attr'           => array('placeholder' => 'Number of occurrences')
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Provip\ProvipBundle\Entity\Activity'
        ));
    }

    public function getName()
    {
        return 'provip_provipbundle_activitytype';
    }
}
