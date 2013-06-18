<?php

namespace Provip\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class ProvipUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
