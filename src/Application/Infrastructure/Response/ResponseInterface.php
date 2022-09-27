<?php

namespace App\Infrastructure\Response;

/**
 * @author Mykhailo YATSYSHYN <mykhailo.yatsyshyn@mirko.in.ua>
 */
interface ResponseInterface
{
    public function getType(mixed $object): string;

    public function hasMeta(): bool;

    public function getMeta(mixed $object): array;

    public function render(mixed $object): array;
}
