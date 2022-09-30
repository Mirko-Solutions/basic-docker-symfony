<?php

namespace App\Domain\ValueObject;

use App\Infrastructure\Exception\ValueObjectException;

/**
 * @author Mykhailo YATSYSHYN <mykhailo.yatsyshyn@mirko.in.ua>
 */
class Email extends AbstractValueObject
{
    public function __construct(string $email)
    {
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new ValueObjectException("String: <{$email}> incorrect email format");
        }

        $this->value = $email;
    }
}
