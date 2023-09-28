<?php

namespace App\UserInterface\Admin\Action\User;

use App\Domain\DTO\User\UserDTO;
use App\Domain\Entity\User\User;
use App\Domain\ValueObject\Email;
use App\Infrastructure\Service\Admin\UserEditService;
use App\UserInfrastructure\API\Response\ArrayResponse;
use App\UserInterface\Admin\Type\UserEditType;
use App\UserInterface\API\Action\AbstractAction;

/**
 * @author Bohdan Sinchuk <bohdan.sinchuk@mirko.in.ua>
 */
class UserEditAction extends AbstractAction
{
    public function __invoke(User $user, UserEditService $userEditService)
    {
       $data = $this->handleType(UserEditType::class, ['method' => 'PUT']);

       return $this->response(new ArrayResponse(), $userEditService->edit(
           $user,
           new UserDTO(
               new Email($data['email']),
               $data['password'],
               $data['first_name'],
               $data['last_name']
            )
       ));
    }
}