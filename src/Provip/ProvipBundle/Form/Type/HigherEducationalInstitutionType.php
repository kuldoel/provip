<?php

namespace Provip\ProvipBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class HigherEducationalInstitutionType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'name',
                'text',
                array(
                    'label' => 'HEI Name'
                )
            )
            ->add(
                'url',
                'text',
                array(
                    'label' => 'Homepage'
                )
            )
            ->add(
                'country',
                'country',
                array(
                    'label' => 'Country'
                )
            )
            ->add(
                'language',
                'entity',
                array(
                    'class' => 'ProvipProvipBundle:Language',
                    'property' => 'valueAttr',
                    'multiple' => false,
                    'label' => 'Company Language',
                    'required' => false,
                ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Provip\ProvipBundle\Entity\HigherEducationalInstitution'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'provip_provipbundle_highereducationalinstitution';
    }
}
