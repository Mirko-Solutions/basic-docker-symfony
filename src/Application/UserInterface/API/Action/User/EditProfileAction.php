<?php

namespace App\UserInterface\API\Action\User;

use App\Domain\DTO\User\UserDTO;
use App\Domain\Entity\User\User;
use App\Domain\ValueObject\Email;
use App\Infrastructure\Service\User\UpdateService;
use App\UserInfrastructure\API\Response\ArrayResponse;
use App\UserInterface\API\Action\AbstractAction;
use App\UserInterface\API\Type\User\EditProfileType;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * @author Bohdan Sinchuk <bohdan.sinchuk@mirko.in.ua>
 */
class EditProfileAction extends AbstractAction
{
    public function __invoke(User $user, UpdateService $updateService, Security $security)
    {
        if($security->getUser()?->getId() !== $user->getId()) {
            throw new AccessDeniedException();
        }
        $data = $this->handleType(EditProfileType::class, ['method' => 'PUT']);
        $updateService->updateProfile(
            $user,
            new UserDTO(
                new Email($data['email']),
                $data['password'],
                $data['first_name'],
                $data['last_name']
            ),
            $data['old_password']
        );
        return $this->response(new ArrayResponse(), [
            'message' => 'User updated has been successful',
        ]);
    }
}