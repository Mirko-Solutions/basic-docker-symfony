<?php

namespace App\Domain\ValueObject;

/**
 * @author Mykhailo YATSYSHYN <mykhailo.yatsyshyn@mirko.in.ua>
 */
interface ValueObjectInterface
{
    public function getValue(): mixed;

    public function __toString(): string;
}
