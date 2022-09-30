<?php

namespace App\Domain\ValueObject;

/**
 * @author Mykhailo YATSYSHYN <mykhailo.yatsyshyn@mirko.in.ua>
 */
abstract class AbstractValueObject implements ValueObjectInterface
{
    protected mixed $value;

    public function getValue(): mixed
    {
        return $this->value;
    }

    public function toString(): string
    {
        return $this->getValue();
    }

    public function __toString(): string
    {
        return $this->toString();
    }
}
