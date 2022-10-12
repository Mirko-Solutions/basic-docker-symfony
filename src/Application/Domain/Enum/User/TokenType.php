<?php

namespace App\Domain\Enum\User;

use App\Infrastructure\Exception\ValueObjectException;

/**
 * @author Mykhailo YATSYSHYN <mykhailo.yatsyshyn@mirko.in.ua>
 */
enum TokenType
{
    case LOGIN_PASSWORD;
    case BIOMETRY;

    public static function from(string $value): TokenType
    {
        foreach (self::cases() as $case) {
            if( $value === $case->name ){
                return $case;
            }
        }

        throw new ValueObjectException("Value is not valid for Enums");
    }
}
