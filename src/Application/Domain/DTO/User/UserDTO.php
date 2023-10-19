<?php

namespace App\Domain\DTO\User;

use App\Domain\ValueObject\Email;

/**
 * @author Bohdan Sinchuk <bohdan.sinchuk@mirko.in.ua>
 */
class UserDTO
{
    public string $email;
    public string $password;
    public string $firstName;
    public string $lastName;
    public string|null $recoveryToken;
    public bool $isAccepted = true;

    public function getEmail(): Email
    {
        return new Email($this->email);
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getRecoveryToken(): ?string
    {
        return $this->recoveryToken;
    }

    public function isAccepted(): bool
    {
        return $this->isAccepted;
    }
}