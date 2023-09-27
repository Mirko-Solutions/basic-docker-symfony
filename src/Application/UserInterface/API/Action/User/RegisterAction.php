<?php

namespace App\UserInterface\API\Action\User;

use App\Domain\DTO\User\UserDTO;
use App\Domain\ValueObject\Email;
use App\Infrastructure\Service\User\CreateService;
use App\UserInfrastructure\API\Response\ArrayResponse;
use App\UserInterface\API\Action\AbstractAction;
use App\UserInterface\API\Type\User\RegisterType;

/**
 * @author Bohdan Sinchuk <bohdan.sinchuk@mirko.in.ua>
 */
class RegisterAction extends AbstractAction
{
    public function __invoke(
        CreateService $createService
    )
    {
        $data = $this->handleType(RegisterType::class);
        $user = $createService->create(
            new UserDTO(
                new Email($data['email']),
                $data['password'],
                $data['first_name'],
                $data['last_name']
            ));
        return $this->response(new ArrayResponse(), [
            'message' => 'User registration has been successful',
        ]);
    }
}
