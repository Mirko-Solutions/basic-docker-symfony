<?php

namespace App\UserInterface\Admin\Action\User;

use App\Domain\DTO\User\UserDTO;
use App\Domain\Entity\User\User;
use App\Domain\Enum\User\UserAccessEnum;
use App\Infrastructure\Service\User\UpdateService;
use App\UserInfrastructure\API\Response\UserResponse;
use App\UserInterface\Admin\Type\UserEditType;
use App\UserInterface\API\Action\AbstractAction;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * @author Bohdan Sinchuk <bohdan.sinchuk@mirko.in.ua>
 */
class UserEditAction extends AbstractAction
{
    public function __invoke(User $user, UpdateService $userEditService, Security $security)
    {
        if(!$security->isGranted(UserAccessEnum::EDIT->name, $user)) {
            throw new AccessDeniedException();
        }
       $data = $this->handleType(UserEditType::class, new UserDTO(),  ['method' => 'PUT']);

       return $this->response(new UserResponse(), $userEditService->updateProfile($user, $data));
    }
}