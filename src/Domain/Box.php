<?php

namespace App\Domain;

use InvalidArgumentException;

readonly class Box
{
    public function __construct(
        public int $width,
        public int $height,
        public int $depth,
    )
    {
        if ($width <= 0 || $height <= 0 || $depth <= 0) {
            throw new InvalidArgumentException('Dimensions must be positive.');
        }
    }

    public function volume(): int
    {
        return $this->width * $this->height * $this->depth;
    }

    public function capacityFor(Cube $cube): int
    {
        return intdiv($this->width, $cube->size)
            * intdiv($this->height, $cube->size)
            * intdiv($this->depth, $cube->size);
    }
}
