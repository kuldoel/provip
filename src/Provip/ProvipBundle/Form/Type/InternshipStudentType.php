<?php

namespace Provip\ProvipBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class InternshipStudentType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('commentsByStudent', 'textarea',
                array(
                    'label' => 'Give some additional general feedback',
                    'attr' => array(
                        'rows' => 10
                    )
                )
            )
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Provip\ProvipBundle\Entity\Internship'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'provip_provipbundle_internship';
    }
}
