<?php

namespace App\UserInterface\API\Action\User;

use App\Domain\Entity\User\User;
use App\Infrastructure\Service\User\UpdateService;
use App\UserInfrastructure\API\Response\ArrayResponse;
use App\UserInterface\API\Action\AbstractAction;
use App\UserInterface\API\Type\User\EditProfileType;

/**
 * @author Bohdan Sinchuk <bohdan.sinchuk@mirko.in.ua>
 */
class EditProfileAction extends AbstractAction
{
    public function __invoke(User $user, UpdateService $updateService)
    {
        $data = $this->handleType(EditProfileType::class);
        $updateService->updateProfile($user, $data);
        return $this->response(new ArrayResponse(), [
            'message' => 'User updated has been successful',
        ]);
    }
}