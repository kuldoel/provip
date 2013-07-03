<?php

namespace Provip\ProvipBundle\Form\Type;

use Doctrine\ORM\EntityRepository;
use Provip\UserBundle\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ApplicationRejectType extends AbstractType
{



    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('rejectionReason','text',array(
                'label' => 'Reason for rejection',
                'error_bubbling' => true,
            ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Provip\ProvipBundle\Entity\Application'
        ));
    }

    public function getName()
    {
        return 'provip_provipbundle_applicationrejectiontype';
    }
}
