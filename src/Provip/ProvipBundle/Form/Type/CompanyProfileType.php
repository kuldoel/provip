<?php

namespace Provip\ProvipBundle\Form\Type;

use Provip\EventsBundle\Form\Type\PictureType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CompanyProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('country', 'country', array('label' => 'Country'))
            ->add('field', 'text', array('label' => 'Sector'))
            ->add('url', 'text', array('label' => 'Homepage'))
            ->add('description', 'textarea', array('label' => 'Description'))
            ->add('language', 'entity',
                array(
                    'class' => 'ProvipProvipBundle:Language',
                    'property' => 'valueAttr',
                    'multiple' => false,
                    'label' => 'Company Language',
                    'required' => false,
                ))
            ->add('supportedLanguages', 'entity',
                array(
                    'class' => 'ProvipProvipBundle:Language',
                    'property' => 'valueAttr',
                    'multiple' => true,
                    'label' => 'Other accepted languages',
                    'required' => false
                ))
            ->add('picture', new PictureType(), array('required' => false, 'label' => 'Company Logo'))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Provip\ProvipBundle\Entity\Company',

        ));
    }

    public function getName()
    {
        return 'provip_provipbundle_companyprofiletype';
    }
}
