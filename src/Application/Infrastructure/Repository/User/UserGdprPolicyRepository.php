<?php

namespace App\Infrastructure\Repository\User;

use App\Domain\Entity\User\User;
use App\Domain\Entity\User\UserGdprPolicy;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

class UserGdprPolicyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserGdprPolicy::class);
    }

    public function add(UserGdprPolicy $userGdprPolicy, bool $flush = false): void
    {
        $this->getEntityManager()->persist($userGdprPolicy);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(int $userId, string $type, bool $flush = false): void
    {
        $userGdprPolicyRepository = $this->getEntityManager()->getRepository(UserGdprPolicy::class);
        $entity = $userGdprPolicyRepository->findOneBy(['user' => $userId,'type' => $type]);

        if ($entity) {
            $this->getEntityManager()->remove($entity);
        }
        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param User $user
     * @return UserGdprPolicy[]
     */
    public function findByUser(User $user): array
    {
        $userGdprPolicyRepository = $this->getEntityManager()->getRepository(UserGdprPolicy::class);

        return $this->findBy(['user'=> $user->getId()]);
    }
}
