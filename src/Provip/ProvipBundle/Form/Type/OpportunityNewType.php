<?php

namespace Provip\ProvipBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class OpportunityNewType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text', array('label' => 'Title'))
            ->add('startDate', 'data', array('label' => 'Start of the internship'))
            ->add('endDate', 'date', array('label' => 'End of the internship'))
            ->add('nbrOfPositions', 'integer', array('label' => 'Available positions'))
            ->add('mentor')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Provip\ProvipBundle\Entity\Opportunity'
        ));
    }

    public function getName()
    {
        return 'provip_provipbundle_opportunitytype';
    }
}
