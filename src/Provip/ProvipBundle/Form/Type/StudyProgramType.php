<?php

namespace Provip\ProvipBundle\Form\Type;

use Provip\UserBundle\Form\Type\StudyProgramAdminType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class StudyProgramType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add(
                'higherEducationalInstitution',
                'entity',
                array(
                    'class' => 'ProvipProvipBundle:HigherEducationalInstitution',
                    'property' => 'name',
                    'multiple' => false,
                    'label' => 'HEI'
                )
            )
            ->add(
                'admins',
                'collection',
                array(
                    'type' => new StudyProgramAdminType(),
                    'label' => 'Study Program Administrator',
                    'allow_add' => true,
                    'allow_delete' => true
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
            'data_class' => 'Provip\ProvipBundle\Entity\StudyProgram'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'provip_provipbundle_studyprogram';
    }
}
