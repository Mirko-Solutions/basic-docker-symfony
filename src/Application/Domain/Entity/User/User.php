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
    private int $id;

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
    private \DateTime|null $deletedAt = null;

    #[Column(type: 'boolean', nullable: false)]
    private bool $isAccepted;

    #[Pure] public static function create(string $firstName, string $lastName, Email $email, string $password): User
    {
        $user = new self();
        $user->setFirstName($firstName);
        $user->setLastName($lastName);
        $user->setEmail($email);
        $user->setPassword($password);
        $user->setRoles([Role::ROLE_USER->name]);
        $user->setCreatedAt();
        $user->setUpdatedAt();
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

    public function setDeletedAt(): void
    {
        $this->deletedAt = new \DateTime('now');
    }
    public function setRecoveryToken(?string $recoveryToken): self
    {
        $this->recoveryToken = $recoveryToken;

        return $this;
    }

    public function getEmail(): Email
    {
        return new Email($this->email);
    }
    public function setEmail(Email $email): void
    {
        $this->email = $email;
    }

    public function isAccepted(): bool
    {
        return $this->isAccepted;
    }

    public function setIsAccepted(bool $isAccepted): void
    {
        $this->isAccepted = $isAccepted;
    }

    private function setRoles(array $roles): void
    {
        $this->roles = $roles;
    }
}
