<?php

namespace Provip\UserBundle\Form\Type;

use Provip\EventsBundle\Form\Type\PictureType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CompanyStaffProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('phone', 'text', array('required' => false, 'label' => 'Phone Number'))
            ->add('jobDescription', 'textarea', array('required' => false, 'label' => 'Job description'))
            ->add('picture', new PictureType(), array('required' => false, 'label' => ''))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Provip\UserBundle\Entity\User',
            'intention' => 'profile'
        ));
    }

    public function getName()
    {
        return 'provip_userbundle_companystaffprofiletype';
    }
}
