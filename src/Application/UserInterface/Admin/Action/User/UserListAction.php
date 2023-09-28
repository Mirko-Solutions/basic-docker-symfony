<?php

namespace App\UserInterface\Admin\Action\User;

use App\Infrastructure\Service\Admin\UserListService;
use App\UserInfrastructure\API\Response\ArrayResponse;
use App\UserInterface\API\Action\AbstractAction;

/**
 * @author Bohdan Sinchuk <bohdan.sinchuk@mirko.in.ua>
 */
class UserListAction extends AbstractAction
{
    public function __invoke(UserListService $userListService)
    {
        $users = $userListService->findAll();

        return $this->responseCollection(new ArrayResponse(), $users);
    }
}
