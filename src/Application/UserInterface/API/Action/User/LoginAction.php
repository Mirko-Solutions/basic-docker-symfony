<?php

namespace App\UserInterface\API\Action\User;

use App\UserInterface\API\Action\AbstractAction;
use App\UserInterface\API\Type\User\AuthType;

/**
 * @author Mykhailo YATSYSHYN <mykhailo.yatsyshyn@mirko.in.ua>
 */
class LoginAction extends AbstractAction
{
    public function __invoke()
    {
        $data = $this->handleType(AuthType::class);
    }
}
