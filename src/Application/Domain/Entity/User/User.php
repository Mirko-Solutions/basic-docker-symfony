<?php

namespace App\Domain\Entity\User;

use Doctrine\ORM\Mapping\SequenceGenerator;
use Doctrine\ORM\Mapping\Table;
use JetBrains\PhpStorm\Pure;
use Doctrine\ORM\Mapping\Id;
use App\Domain\Enum\User\Role;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Column;
use App\Domain\ValueObject\Email;
use Doctrine\ORM\Mapping\GeneratedValue;
use App\Infrastructure\Repository\User\UserRepository;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

/**
 * @author Mykhailo YATSYSHYN <mykhailo.yatsyshyn@mirko.in.ua>
 */
#[Entity(repositoryClass: UserRepository::class)]
#[Table(name: 'users')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[Id]
    #[GeneratedValue(strategy: 'SEQUENCE')]
    #[SequenceGenerator(sequenceName: 'id', allocationSize: 1, initialValue: 1)]
    #[Column(name: 'id')]
    private int $id;

    #[Column(type: 'string', unique: true, nullable: false)]
    private string $email;

    #[Column(type: 'string', nullable: false)]
    private string $password;

    #[Column(type: 'simple_array', nullable: false)]
    private array $roles = [];

    #[Pure] public static function create(Email $email): User
    {
        $user = new self();

        $user->email = $email;
        $user->roles[] = Role::USER->name;

        return $user;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function email(): Email
    {
        return new Email($this->email);
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    #[Pure] public function getUserIdentifier(): string
    {
        return $this->email()->toString();
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function setPassword(string $password): User
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @param int $id
     * @return User
     */
    public function setId(int $id): User
    {
        $this->id = $id;
        return $this;
    }
}
