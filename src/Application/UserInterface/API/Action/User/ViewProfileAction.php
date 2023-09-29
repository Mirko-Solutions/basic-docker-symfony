<?php

namespace App\UserInterface\API\Action\User;

use App\Domain\Entity\User\User;
use App\Domain\Enum\User\UserAccessEnum;
use App\Infrastructure\Service\User\UserService;
use App\UserInfrastructure\API\Response\ArrayResponse;
use App\UserInterface\API\Action\AbstractAction;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class ViewProfileAction extends AbstractAction
{
    public function __invoke(User $user, UserService $userService, Security $security)
    {
        if(!$security->isGranted(UserAccessEnum::READ->name, $user)) {
            throw new AccessDeniedException();
        }
       return $this->response(new ArrayResponse(), $userService->getById($user->getId()));
    }
}