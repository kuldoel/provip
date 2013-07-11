<?php

namespace Provip\ProvipBundle\Form\Type;

use Provip\EventsBundle\Form\Type\PictureType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class StudyProgramProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('learningOutcomes', 'textarea', array('label' => 'Learning Outcomes'))

        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Provip\ProvipBundle\Entity\StudyProgram',

        ));
    }

    public function getName()
    {
        return 'provip_provipbundle_studyprogramprofiletype';
    }
}
