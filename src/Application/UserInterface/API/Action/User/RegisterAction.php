<?php

namespace App\UserInterface\API\Action\User;

use App\Domain\DTO\User\UserDTO;
use App\Infrastructure\Service\User\CreateService;
use App\UserInfrastructure\API\Response\ErrorResponse;
use App\UserInfrastructure\API\Response\UserResponse;
use App\UserInterface\API\Action\AbstractAction;
use App\UserInterface\API\Type\User\RegisterType;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @author Bohdan Sinchuk <bohdan.sinchuk@mirko.in.ua>
 */
class RegisterAction extends AbstractAction
{
    public function __invoke(
        CreateService $createService
    )
    {
        $data = $this->handleType(RegisterType::class,  new UserDTO());
        try {
            $user = $createService->create($data);
        } catch (NotFoundHttpException $e) {
            return $this->response(new ErrorResponse(), $e->getMessage(), $e->getStatusCode());
        }
        return $this->response(new UserResponse(), $user);
    }
}
