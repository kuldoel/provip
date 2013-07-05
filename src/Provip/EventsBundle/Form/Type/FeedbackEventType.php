<?php

namespace Provip\EventsBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FeedbackEventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('message', 'textarea', array(
                'label' => 'Message',
                'required' => false,
                'error_bubbling' => true,
            ))
            ->add('evaluationValue', 'choice', array(
                'choices' => array(
                    'Good' => 'Good',
                    'Fair' => 'Fair',
                    'Poor'   => 'Poor',
                ),
                'label' => 'Evaluation',
                'error_bubbling' => true,
                'attr' => array('class' => 'selectpicker', 'data-style' => 'btn-info')
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Provip\EventsBundle\Entity\FeedbackEvent'
        ));
    }

    public function getName()
    {
        return 'provip_eventsbundle_feedbackeventtype';
    }
}
