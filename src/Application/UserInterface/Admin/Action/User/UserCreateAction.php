<?php

namespace App\UserInterface\Admin\Action\User;

use App\Domain\DTO\User\UserDTO;
use App\Domain\ValueObject\Email;
use App\Infrastructure\Service\Admin\UserCreateService;
use App\UserInfrastructure\API\Response\ArrayResponse;
use App\UserInterface\Admin\Type\UserCreateType;
use App\UserInterface\API\Action\AbstractAction;

/**
 * @author Bohdan Sinchuk <bohdan.sinchuk@mirko.in.ua>
 */
class UserCreateAction extends AbstractAction
{
    public function __invoke(UserCreateService $userCreateService)
    {
       $data = $this->handleType(UserCreateType::class);
       return $this->response(new ArrayResponse(),
           $userCreateService->create(
           new UserDTO(
               new Email($data['email']),
               $data['password'],
               $data['first_name'],
               $data['last_name']
           ))
       );
    }
}