<?php

namespace Provip\UserBundle\Factory;

use Provip\UserBundle\Form\Type\StudentRegistrationType;
use Provip\UserBundle\Form\Type\CompanyRegistrationType;
use Symfony\Component\Form\FormFactoryInterface;

class UserFormFactory
{

    protected $formFactory;

    public function __construct(FormFactoryInterface $formFactory)
    {
        $this->formFactory = $formFactory;
    }


    public function getStudentRegistrationForm()
    {
        return $this->formFactory->create(new StudentRegistrationType('User'));
    }

    public function getCompanyRegistrationForm()
    {
        return $this->formFactory->create(new CompanyRegistrationType('User'));
    }
}