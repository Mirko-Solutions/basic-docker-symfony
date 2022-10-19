<?php

namespace App\Domain\Entity\User;

use App\Domain\Enum\User\TokenType;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\SequenceGenerator;
use Doctrine\ORM\Mapping\Table;
use JetBrains\PhpStorm\Pure;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\GeneratedValue;
use App\Infrastructure\Repository\User\UserRepository;
use App\Infrastructure\Repository\User\UserTokenRepository;

/**
 * @author Mykhailo YATSYSHYN <mykhailo.yatsyshyn@mirko.in.ua>
 */
#[Entity(repositoryClass: UserTokenRepository::class)]
#[Table(name: 'user_token')]
class UserToken
{
    #[Id]
    #[GeneratedValue(strategy: 'SEQUENCE')]
    #[SequenceGenerator(sequenceName: 'id', allocationSize: 1, initialValue: 1)]
    #[Column(name: 'id')]
    private int $id;

    #[ManyToOne(targetEntity: User::class)]
    #[JoinColumn(name: 'user_id', referencedColumnName: 'id')]
    private User $user;

    #[Column(name: 'type', length: 255, nullable: false)]
    private string $type;

    #[Column(name: 'token', length: 255, nullable: false)]
    private string $token;

    #[Pure] public static function create(User $user, TokenType $type, string $token): self
    {
        $tokenEntity = new self();
        $tokenEntity->user = $user;
        $tokenEntity->type = $type->name;
        $tokenEntity->token = $token;

        return $tokenEntity;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function user(): User
    {
        return $this->user;
    }

    public function getType(): TokenType
    {
        return TokenType::from($this->type);
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function setToken(string $token): self
    {
        $this->token = $token;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

}
