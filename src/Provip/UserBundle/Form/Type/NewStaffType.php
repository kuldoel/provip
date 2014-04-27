<?php

namespace Provip\UserBundle\Form\Type;

use Doctrine\ORM\EntityRepository;
use Provip\ProvipBundle\Entity\StudyProgram;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class NewStaffType extends AbstractType
{
    protected $studyProgram;

    public function __construct(StudyProgram $sp) {
        $this->studyProgram = $sp;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $sp = $this->studyProgram;

        $builder
            ->add('email', 'email', array('error_bubbling' => true))
            ->add('firstName', 'text', array('error_bubbling' => true))
            ->add('lastName', 'text', array('error_bubbling' => true))
            ->add('teachesAt', 'entity', array(
                    'label' => 'Study Program',
                    'class' => 'ProvipProvipBundle:StudyProgram',
                    'query_builder' => function(EntityRepository $er) use ($sp) {

                            $hei = $sp->getHigherEducationalInstitution();

                            return $er->createQueryBuilder('sps')
                                ->where('sps.higherEducationalInstitution = ?1')
                                ->orderBy('sps.name', 'ASC')
                                ->setParameters(
                                    array(
                                        '1' => $hei,
                                    )
                                ) ;
                        })
            )
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
