<?php

namespace App\Infrastructure\Security\Voter;

use App\Domain\Entity\User\User;
use App\Domain\Enum\User\Role;
use App\Domain\Enum\User\UserAccessEnum;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class UserVoter extends Voter
{
    private $security;

    public function __construct(AuthorizationCheckerInterface $security)
    {
        $this->security = $security;
    }

    /**
     * @param UserInterface $subject
     */
    protected function supports(string $attribute, mixed $subject): bool
    {
        return (UserAccessEnum::tryFrom($attribute) !== null);
    }

    /**
     * @param UserInterface $subject
     */
    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        if (!$user instanceof UserInterface) {
            return false;
        }

        if ($user->getDeletedAt()) {
            return false;
        }

        return match ($attribute) {
            UserAccessEnum::READ->name => $this->canRead($subject, $user),
            UserAccessEnum::LIST->name => $this->canList($subject, $user),
            UserAccessEnum::CREATE->name => $this->canCreate($subject, $user),
            UserAccessEnum::EDIT->name => $this->canEdit($subject, $user),
            UserAccessEnum::DELETE->name => $this->canDelete($subject, $user),
            default => false
        };
    }

    private function canRead(User $owner, UserInterface $user): bool
    {
        return ($this->security->isGranted(Role::ROLE_ADMIN->name, $user) || $user->getUserIdentifier() === $owner->getUserIdentifier());
    }

    private function canList(User $owner, UserInterface $user): bool
    {
        return ($this->security->isGranted(Role::ROLE_ADMIN->name, $user));
    }

    private function canCreate(User $owner, UserInterface $user): bool
    {
        return ($this->security->isGranted(Role::ROLE_ADMIN->name, $user));
    }

    private function canEdit(User $owner, UserInterface $user): bool
    {
        return ($this->security->isGranted(Role::ROLE_ADMIN->name, $user) || $user->getUserIdentifier() === $owner->getUserIdentifier());
    }

    private function canDelete(User $owner, UserInterface $user): bool
    {
        return ($this->security->isGranted(Role::ROLE_ADMIN->name, $user) || $user->getUserIdentifier() === $owner->getUserIdentifier());
    }
}