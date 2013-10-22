<?php

namespace Provip\ProvipBundle\Form\Type;

use Provip\ProvipBundle\Form\Type\TaskType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DeliverableCompanyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('description', 'text', array(
                    'label' => 'Goal',
                    'attr' => array('placeholder' => 'Workplace interaction, Building a website, ...'),
                    'error_bubbling' => true,
                ))
            ->add('tasks', 'collection' , array(
                    'type' =>  new TaskType(),
                    'allow_add' => true,
                    'error_bubbling' => true,
                ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
                'data_class' => 'Provip\ProvipBundle\Entity\Deliverable',
            ));
    }

    public function getName()
    {
        return 'provip_provipbundle_deliverabletype';
    }
}