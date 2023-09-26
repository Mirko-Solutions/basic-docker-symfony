<?php

namespace App\UserInterface\API\Action\User;

use App\Domain\ValueObject\Email;
use App\Infrastructure\Service\User\UpdateService;
use App\Infrastructure\Service\User\UserService;
use App\UserInfrastructure\API\Response\ArrayResponse;
use App\UserInterface\API\Action\AbstractAction;
use App\UserInterface\API\Type\User\RecoveryType;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email as MimeEmail;

/**
 * @author Bohdan Sinchuk <bohdan.sinchuk@mirko.in.ua>
 */
class RecoveryAction extends AbstractAction
{
    public function __invoke(
        UserService $userService,
        UpdateService $updateService,
    )
    {
        $data = $this->handleType(RecoveryType::class);
        $user = $userService->findByEmail(new Email($data['email']));
        $token = $this->generateRecoveryToken();
        if ($user){
            $user = $user->setRecoveryToken($this->generateRecoveryToken());
            $updateService->update($user);
        }
        return $this->response(new ArrayResponse(), [
            'recovery_token' => $token,
        ]);
    }

    private function generateRecoveryToken()
    {
        return 'rc_'.bin2hex(random_bytes(32));
    }
}