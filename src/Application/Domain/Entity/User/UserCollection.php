<?php

namespace App\Domain\Entity\User;

use App\Domain\Entity\Collection;

/**
 * @author Bohdan Sinchuk <bohdan.sinchuk@mirko.in.ua>
 */
class UserCollection extends Collection
{
    public function __construct(User ...$items)
    {
        parent::__construct($items);
    }

    /**
     * @return User[]
     */
    public function getIterator(): \Traversable
    {
        return parent::getIterator();
    }
}