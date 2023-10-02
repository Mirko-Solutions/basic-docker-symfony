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
    public string $first_name;
    public string $last_name;
    public string|null $recoveryToken;

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
        return $this->first_name;
    }

    public function getLastName(): string
    {
        return $this->last_name;
    }

    public function getRecoveryToken(): ?string
    {
        return $this->recoveryToken;
    }
}