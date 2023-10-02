<?php

namespace App\UserInterface\Admin\Action\User;

use App\Domain\Entity\User\User;
use App\Domain\Enum\User\UserAccessEnum;
use App\Infrastructure\Service\Admin\UserViewService;
use App\UserInfrastructure\API\Response\ArrayResponse;
use App\UserInfrastructure\API\Response\UserResponse;
use App\UserInterface\API\Action\AbstractAction;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * @author Bohdan Sinchuk <bohdan.sinchuk@mirko.in.ua>
 */
class UserViewAction extends AbstractAction
{
    public function __invoke(User $user, Security $security)
    {
        if(!$security->isGranted(UserAccessEnum::READ->name, $user)) {
            throw new AccessDeniedException();
        }
       return $this->response(new UserResponse(), $user);
    }
}