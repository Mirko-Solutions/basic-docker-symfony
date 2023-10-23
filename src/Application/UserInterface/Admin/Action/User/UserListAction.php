<?php

namespace App\UserInterface\Admin\Action\User;

use App\Domain\Enum\User\UserAccessEnum;
use App\Infrastructure\Repository\User\UserRepository;
use App\UserInfrastructure\API\Response\UserResponse;
use App\UserInterface\API\Action\AbstractAction;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * @author Bohdan Sinchuk <bohdan.sinchuk@mirko.in.ua>
 */
class UserListAction extends AbstractAction
{
    public function __invoke(UserRepository $userRepository, Security $security)
    {
        if(!$security->isGranted(UserAccessEnum::LIST->name, $security->getUser())) {
            throw new AccessDeniedException();
        }

        return $this->responseCollection(new UserResponse(), $userRepository->findAll());
    }
}
