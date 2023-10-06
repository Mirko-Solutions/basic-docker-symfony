<?php

namespace App\UserInterface\API\Action\User;

use App\Domain\Enum\User\UserAccessEnum;
use App\Infrastructure\Service\User\UserService;
use App\UserInfrastructure\API\Response\GdprResponse;
use App\UserInterface\API\Action\AbstractAction;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class UserDataAction extends AbstractAction
{
    public function __invoke(UserService $userService, Security $security, string $dateFormat)
    {
        if(!$security->isGranted(UserAccessEnum::READ->name, $security->getUser())) {
            throw new AccessDeniedException();
        }

       return $this->response(new GdprResponse(), [
           'type' => 'Privacy policy',
           'acceptedAt' => $security->getUser()?->getCreatedAt()->format($dateFormat)
       ]);
    }
}