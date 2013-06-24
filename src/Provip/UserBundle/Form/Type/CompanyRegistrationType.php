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
            ->add('firstName')
            ->add('lastName')
            ->add('hei', 'entity', array(
                'class' => 'ProvipProvipBundle:HigherEducationalInstitution',
                'label' => 'Higher Educational Institution'
            ));

    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Provip\UserBundle\Entity\User',
            'intention' => 'registration'
        ));
    }

    public function getName()
    {
        return 'pathway_student_registration';
    }
}
