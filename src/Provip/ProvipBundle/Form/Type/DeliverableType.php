<?php

namespace Provip\ProvipBundle\Form\Type;

use Doctrine\ORM\EntityRepository;
use Provip\ProvipBundle\Entity\StudyProgram;
use Provip\ProvipBundle\Form\Type\TaskType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DeliverableType extends AbstractType
{

    private $studyProgram;

    public function __construct(StudyProgram $sp) {
        $this->studyProgram = $sp;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $studyProgram = $this->studyProgram;

        $builder
            ->add('enrollment', 'entity', array(
                    'class' => 'ProvipProvipBundle:Enrollment',
                    'query_builder' => function(EntityRepository $er) use ($studyProgram) {
                        return $er->createQueryBuilder('e')
                            ->where('e.studyProgram = :studyProgram')
                            ->orderBy('e.id', 'ASC')
                            ->setParameter('studyProgram', $studyProgram);
                    },
                    'label' => 'Student',
                    'error_bubbling' => true,
                ))
            ->add('tasks', 'collection' , array(
                'type' =>  new TaskType(),
                'allow_add' => true,
                'error_bubbling' => true,
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Provip\ProvipBundle\Entity\Deliverable',
        ));
    }

    public function getName()
    {
        return 'provip_provipbundle_deliverabletype';
    }
}
