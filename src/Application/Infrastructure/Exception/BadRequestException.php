<?php

namespace App\Infrastructure\Exception;

/**
 * @author Mykhailo YATSYSHYN <mykhailo.yatsyshyn@mirko.in.ua>
 */
class BadRequestException extends \Exception
{
    private array $errors = [];

    public function __construct($message)
    {
        $messageText = '';
        if(is_string($message)) {
            $messageText = $message;
            $this->errors[] = $messageText;
        } elseif (is_array($message)) {
            $this->errors = $message;
            $messageText = end($message);
        }

        parent::__construct($messageText, 400);
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

}
