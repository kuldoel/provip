<?php

namespace Provip\ProvipBundle\Form\Type;

use Doctrine\ORM\EntityRepository;
use Provip\UserBundle\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ApplicationType extends AbstractType
{

    protected $student;

    public function __construct(User $student)
    {
        $this->student = $student;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {



        $builder
            ->add('startDate','date',array(
                'widget' => 'single_text',
                'format' => 'dd-MM-yyyy',
                'attr' => array('class' => 'date', 'data-date-format' => 'dd-mm-yyyy'),
                'label' => 'Start of the internship',
                'error_bubbling' => true,
            ))
            ->add('endDate','date',array(
                'widget' => 'single_text',
                'format' => 'dd-MM-yyyy',
                'attr' => array('class' => 'date', 'data-date-format' => 'dd-mm-yyyy'),
                'label' => 'End of the internship',
                'error_bubbling' => true,
            ))
            ->add('coach', 'entity', array(
                    'label' => 'School Mentor',
                    'attr'  => array('class' => 'selectpicker'),
                    'class' => 'ProvipUserBundle:User',
                    'query_builder' => function(EntityRepository $er) {

                        $student = $this->student;

                        return $er->createQueryBuilder('u')
                            ->where('u.teachesAt = ?1')
                            ->orWhere('u.adminOf = ?2')
                            ->orderBy('u.firstName', 'ASC')
                            ->setParameters(array('1' => $student->getEnrollment()->getStudyProgram(), '2' => $student->getEnrollment()->getStudyProgram()))
                            ;
                    },)
            )
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Provip\ProvipBundle\Entity\Application'
        ));
    }

    public function getName()
    {
        return 'provip_provipbundle_applicationtype';
    }
}
