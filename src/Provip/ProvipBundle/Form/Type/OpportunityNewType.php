<?php

namespace Provip\ProvipBundle\Form\Type;

use Doctrine\ORM\EntityRepository;
use Provip\ProvipBundle\Entity\Company;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class OpportunityNewType extends AbstractType
{

    protected $company;

    public function __construct(Company $company = null)
    {
        $this->company = $company;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $company = $this->company;


        $builder
            ->add('title', 'text', array('label' => 'Title', 'error_bubbling' => true))
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
            ->add('nbrOfPositions', 'integer', array(
                'label' => 'Available positions',
                'data' => 1,
                'error_bubbling' => true))
            ->add('mentor', 'entity', array(
                'class' => 'ProvipUserBundle:User',
                'query_builder' => function(EntityRepository $er) use ($company) {
                    return $er->createQueryBuilder('u')
                        ->where('u.company = :company')
                        ->orderBy('u.firstName', 'ASC')
                        ->setParameter('company', $company);
                },
                'label' => 'Mentor for this internship',
                'attr' => array('class' => 'selectpicker'),
                'error_bubbling' => true,
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Provip\ProvipBundle\Entity\Opportunity'
        ));
    }

    public function getName()
    {
        return 'provip_provipbundle_opportunitytype';
    }
}
