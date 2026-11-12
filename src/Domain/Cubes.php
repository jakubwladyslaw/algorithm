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

    public function sortedBySizeDesc(): self
    {
        $sorted = $this->items;
        usort($sorted, static fn (Cube $a, Cube $b): int => $b->size <=> $a->size);

        return new self(...$sorted);
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
