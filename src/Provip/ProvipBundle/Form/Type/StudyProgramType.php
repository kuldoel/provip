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
                new HigherEducationalInstitutionType(),
                array(
                    'label' => 'HEI'
                )
            )
            ->add(
                'admin',
                new StudyProgramAdminType(),
                array(
                    'label' => 'Study Program Administrator'
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
