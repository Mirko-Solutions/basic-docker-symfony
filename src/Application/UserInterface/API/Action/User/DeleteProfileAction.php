<?php

namespace App\UserInterface\API\Action\User;

use App\Domain\Entity\User\User;
use App\Domain\Enum\User\UserAccessEnum;
use App\Infrastructure\Service\User\DeleteService;
use App\UserInfrastructure\API\Response\ArrayResponse;
use App\UserInfrastructure\API\Response\SuccessResponse;
use App\UserInterface\API\Action\AbstractAction;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class DeleteProfileAction extends AbstractAction
{
    public function __invoke(User $user, DeleteService $deleteService, Security $security)
    {
        if(!$security->isGranted(UserAccessEnum::DELETE->name, $user)) {
            throw new AccessDeniedException();
        }

        $deleteService->softDelete($user);
        return $this->response(new SuccessResponse(), 'User has been deleted', 202);
    }
}