<?php

namespace Provip\UserBundle\Form\Type;

use FOS\UserBundle\Form\Type\ProfileFormType;
use Provip\EventsBundle\Entity\Picture;
use Provip\EventsBundle\Form\Type\PictureType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class StudentProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('missionStatement', 'textarea', array('required' => false))
            ->add('nationality', 'country', array('required' => false, 'label' => 'Country'))
            ->add('url', 'text', array('label' => 'Homepage', 'required' => false))
            ->add('language', 'entity',
                array(
                    'class' => 'ProvipProvipBundle:Language',
                    'property' => 'valueAttr',
                    'multiple' => false,
                    'label' => 'Language',
                    'required' => false,
                ))
            ->add('supportedLanguages', 'entity',
                array(
                    'class' => 'ProvipProvipBundle:Language',
                    'property' => 'valueAttr',
                    'multiple' => true,
                    'label' => 'Other proficient languages',
                    'required' => false
                ))
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
        return 'provip_userbundle_profilestudenttype';
    }
}
