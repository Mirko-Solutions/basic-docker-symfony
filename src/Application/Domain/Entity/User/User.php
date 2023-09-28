<?php

namespace App\Domain\Entity\User;

use App\Domain\DTO\User\UserDTO;
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
    private int|null $id;

    #[Column(type: 'string', nullable: false)]
    private string $firstName;

    #[Column(type: 'string', nullable: false)]
    private string $lastName;

    #[Column(type: 'string', unique: true, nullable: false)]
    private string $email;

    #[Column(type: 'string', nullable: false)]
    private string $password;

    #[Column(type: 'simple_array', nullable: false)]
    private array $roles = [];

    #[Column(type: 'string', nullable: true)]
    private string|null $recoveryToken;

    #[Column(type: 'datetime', nullable: false)]
    private \DateTime $createdAt;

    #[Column(type: 'datetime', nullable: false)]
    private \DateTime $updatedAt;

    #[Column(type: 'datetime', nullable: true)]
    private \DateTime|null $deletedAt;

    public function __construct(int|null $id, string $firstName, string $lastName, string $email, string $password, array $roles)
    {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->password = $password;
        $this->roles = $roles;
    }


    #[Pure] public static function create(UserDTO $userDTO): User
    {
        $user = new self(
            null,
            $userDTO->getFirstName(),
            $userDTO->getLastName(),
            $userDTO->getEmail(),
            $userDTO->getPlainPassword(),
            [Role::ROLE_USER->name]
        );
        $user->setCreatedAt();
        $user->setUpdatedAt();
        return $user;
    }

    public function getId(): int|null
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
        $roles = $this->roles;
        $roles[] = Role::ROLE_USER->name;

        return array_unique($roles);
    }

    #[Pure] public function getUserIdentifier(): string
    {
        return $this->email()->toString();
    }

    public function eraseCredentials(): void
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

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(): void
    {
        $this->createdAt = new \DateTime('now');
    }

    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(): void
    {
        $this->updatedAt = new \DateTime('now');
    }

    public function getDeletedAt(): ?\DateTime
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(?\DateTime $deletedAt): void
    {
        $this->deletedAt = $deletedAt;
    }
    public function setRecoveryToken(?string $recoveryToken): self
    {
        $this->recoveryToken = $recoveryToken;

        return $this;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }
}
