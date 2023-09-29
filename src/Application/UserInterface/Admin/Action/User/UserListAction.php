<?php

namespace App\UserInterface\Admin\Action\User;

use App\Domain\Enum\User\UserAccessEnum;
use App\Infrastructure\Service\Admin\UserListService;
use App\UserInfrastructure\API\Response\ArrayResponse;
use App\UserInterface\API\Action\AbstractAction;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * @author Bohdan Sinchuk <bohdan.sinchuk@mirko.in.ua>
 */
class UserListAction extends AbstractAction
{
    public function __invoke(UserListService $userListService, Security $security)
    {
        if(!$security->isGranted(UserAccessEnum::LIST->name, $security->getUser())) {
            throw new AccessDeniedException();
        }
        $users = $userListService->findAll();

        return $this->responseCollection(new ArrayResponse(), $users);
    }
}
