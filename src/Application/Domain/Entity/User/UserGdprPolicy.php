<?php

namespace App\Domain\Entity\User;

use App\Domain\Enum\User\GdprTypeEnum;
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

    #[Column(name: 'type', length: 255, nullable: false, enumType: GdprTypeEnum::class)]
    private GdprTypeEnum $type;

    #[Column(type: 'datetime')]
    private \DateTimeInterface|null $acceptedAt = null;

    #[Pure] public static function create(User $user, GdprTypeEnum $type, \DateTimeInterface|null $acceptedAt): self
    {
        $tokenEntity = new self();
        $tokenEntity->user = $user;
        $tokenEntity->type = $type;
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

    public function getType(): GdprTypeEnum
    {
        return $this->type;
    }

    public function getAcceptedAt(): \DateTimeInterface|null
    {
        return $this->acceptedAt;
    }

    public function setType(GdprTypeEnum $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function setAcceptedAt(\DateTimeInterface|null $acceptedAt): self
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
