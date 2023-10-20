<?php

namespace App\Infrastructure\Response;

use App\Infrastructure\Exception\ResponseException;

/**
 * @author Mykhailo YATSYSHYN <mykhailo.yatsyshyn@mirko.in.ua>
 */
abstract class Response implements ResponseInterface
{
    protected bool $renderMeta = false;
    protected string $dateFormat;

    public function __construct(string $dateFormat = 'Y-m-d H:i:s', bool $renderMeta = false)
    {
        $this->dateFormat = $dateFormat;
        $this->renderMeta = $renderMeta;
    }

    public function getType(mixed $object): string
    {
        if(is_object($object)) {
            return get_class($object);
        } elseif (is_array($object)) {
            return 'CustomArray';
        }

        throw new ResponseException("Invalid detected type for Response Object");
    }

    public function hasMeta(): bool
    {
        return $this->renderMeta;
    }

    public function getMeta(mixed $object): array
    {
        return [];
    }
}
