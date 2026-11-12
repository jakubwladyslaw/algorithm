<?php

namespace App\Domain;

/**
 * @implements \IteratorAggregate<int, Cube>
 */
readonly class Cubes implements \IteratorAggregate, \Countable
{
    /** @var list<Cube> */
    public array $items;

    public function __construct(Cube ...$cubes)
    {
        $this->items = array_values($cubes);
    }

    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this->items);
    }

    public function count(): int
    {
        return count($this->items);
    }
}
