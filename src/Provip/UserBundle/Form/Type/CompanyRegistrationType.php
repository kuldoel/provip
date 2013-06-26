<?php

namespace Provip\UserBundle\Form\Type;

use FOS\UserBundle\Form\Type\RegistrationFormType;
use Provip\ProvipBundle\Form\Type\CompanyNewType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CompanyRegistrationType extends RegistrationFormType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
            ->remove('username')
            ->add('firstName', 'text', array('label' => 'First Name:'))
            ->add('lastName', 'text', array('label' => 'Last Name:'))
            ->add('company', new CompanyNewType());

    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Provip\UserBundle\Entity\User',
            'intention' => 'registration',
            'error_bubbling' => true,
        ));
    }

}
