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
}
