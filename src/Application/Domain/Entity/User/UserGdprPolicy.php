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
use App\Infrastructure\Repository\User\UserGdprPolicyRepository;

/**
 * @author Bohdan Sinchuk <bohdan.sinchuk@mirko.in.ua>
 */
#[Entity(repositoryClass: UserGdprPolicyRepository::class)]
#[Table(name: 'user_gdpr_policy')]
class UserGdprPolicy
{
    #[Id]
    #[GeneratedValue(strategy: 'SEQUENCE')]
    #[SequenceGenerator(sequenceName: 'id', allocationSize: 1, initialValue: 1)]
    #[Column(name: 'id')]
    private int $id;

    #[ManyToOne(targetEntity: User::class)]
    #[JoinColumn(name: 'user_id', referencedColumnName: 'id', nullable: false)]
    private User $user;

    #[Column(name: 'type', length: 255, nullable: false)]
    private string $type;

    #[Column(type: 'datetime')]
    private \DateTime|null $acceptedAt = null;

    #[Pure] public static function create(User $user, TokenType $type, \DateTime|null $acceptedAt): self
    {
        $tokenEntity = new self();
        $tokenEntity->user = $user;
        $tokenEntity->type = $type->name;
        $tokenEntity->acceptedAt = $acceptedAt;

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

    public function getAcceptedAt(): \DateTime|null
    {
        return $this->acceptedAt;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function setAcceptedAt(\DateTime|null $acceptedAt): self
    {
        $this->acceptedAt = $acceptedAt;

        return $this;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

}
