<?php

namespace Provip\UserBundle\Form\Type;

use Doctrine\ORM\EntityRepository;
use Provip\ProvipBundle\Entity\StudyProgram;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class NewCompanyStaffType extends AbstractType
{


    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $sp = $this->studyProgram;

        $builder
            ->add('email', 'email', array('error_bubbling' => true))
            ->add('firstName', 'text', array('error_bubbling' => true))
            ->add('lastName', 'text', array('error_bubbling' => true))
            ->add('responsibleFor', 'textarea', array('required' => false, 'label' => 'Contact for', 'attr' => array('placeholder' => 'This person can be contacted for...')))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Provip\UserBundle\Entity\User',
        ));
    }

    public function getName()
    {
        return 'provip_userbundle_usertype';
    }
}
