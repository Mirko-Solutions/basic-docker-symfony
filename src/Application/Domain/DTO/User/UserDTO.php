<?php

namespace App\Domain\DTO\User;

use App\Domain\ValueObject\Email;

/**
 * @author Bohdan Sinchuk <bohdan.sinchuk@mirko.in.ua>
 */
class UserDTO
{
    private Email $email;
    private string $plainPassword;
    private string $firstName;
    private string $lastName;
    private string|null $recovery_token;
    public function __construct(Email $email, string $plainPassword, string $firstName, string $lastName, null|string $recovery_token = null)
    {
        $this->email = $email;
        $this->plainPassword = $plainPassword;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->recovery_token = $recovery_token;
    }

    public function getEmail(): Email
    {
        return new Email($this->email);
    }

    public function getPlainPassword(): string
    {
        return $this->plainPassword;
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
        return $this->recovery_token;
    }
}