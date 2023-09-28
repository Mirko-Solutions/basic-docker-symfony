<?php

namespace App\Domain\Entity;

/**
 * @author Bohdan Sinchuk <bohdan.sinchuk@mirko.in.ua>
 */
class Collection implements \IteratorAggregate, \Countable, \JsonSerializable
{
    private array $items = [];

    public function __construct(?array $items)
    {
        if ($items !== null) {
            $this->setItems($items);
        }
    }

    public function count(): int
    {
        return count($this->items);
    }

    public function getIterator(): \Traversable
    {
        return new \ArrayIterator($this->items);
    }

    /**
     * @return static
     */
    public function filter(callable $callback): self
    {
        $copy = clone $this;
        $copy->setItems(array_values(array_filter(
            $this->items,
            $callback
        )));

        return $copy;
    }

    /**
     * @return static
     */
    public function sort(callable $callback): self
    {
        $copy = clone $this;

        $items = $copy->toArray();

        uasort($items, $callback);

        $copy->setItems(array_values($items));

        return $copy;
    }

    /**
     * @return static
     */
    public function map(callable $callback): self
    {
        $copy = clone $this;
        $copy->setItems(array_map(
            $callback,
            $this->items
        ));

        return $copy;
    }

    /**
     * @return static
     */
    public function splice(int $limit, int $offset = 0): self
    {
        $copy = clone $this;
        $copy->setItems(array_slice(
            $this->items,
            $offset,
            $limit
        ));

        return $copy;
    }

    public function first()
    {
        if (!$this->count()) {
            return null;
        }

        return $this->items[0];
    }

    public function last()
    {
        if (!$this->count()) {
            return null;
        }

        return $this->items[$this->count() - 1];
    }

    public function has(callable $callback): bool
    {
        foreach ($this->items as $item) {
            if ($callback($item)) {
                return true;
            }
        }

        return false;
    }

    public function toArray(): array
    {
        return $this->items;
    }

    public function jsonSerialize(): array
    {
        return $this->items;
    }

    protected function setItems(array $items): void
    {
        $this->items = $items;
    }

    /**
     * @return static
     */
    protected function append(...$items): self
    {
        $copy = clone $this;
        $copy->setItems(array_values(array_merge(
            $this->items,
            $items
        )));

        return $copy;
    }
}
