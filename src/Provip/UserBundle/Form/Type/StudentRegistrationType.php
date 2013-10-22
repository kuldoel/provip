<?php

namespace Provip\UserBundle\Form\Type;

use FOS\UserBundle\Form\Type\RegistrationFormType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class StudentRegistrationType extends RegistrationFormType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
            ->remove('username')
            ->add('firstName', 'text', array('label' => 'First Name:'))
            ->add('lastName', 'text', array('label' => 'Last Name:'))
            ->add('hei', 'entity', array(
                'class' => 'ProvipProvipBundle:HigherEducationalInstitution',
                'label' => 'Select your institution:'
            ))
            ->add('studyProgram', 'entity', array(
                'class' => 'ProvipProvipBundle:StudyProgram',
                'label' => 'Select your Study Program:'
            ));

    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Provip\UserBundle\Entity\User',
            'intention' => 'registration'
        ));
    }

}
