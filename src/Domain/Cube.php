<?php

namespace App\Domain;

use InvalidArgumentException;

readonly class Cube
{
    public function __construct(
        public int $size,
        public int $qty,
    )
    {
        if ($size <= 0) {
            throw new InvalidArgumentException('Dimensions must be positive.');
        }

        if (!self::isPowerOfTwo($size)) {
            throw new InvalidArgumentException('Size must be a power of two.');
        }

        if ($qty < 0) {
            throw new InvalidArgumentException('Quantity cannot be negative.');
        }
    }

    /**
     * Returns a cube with the next power-of-two side (size * 2) and the given quantity.
     */
    public function next(int $qty): self
    {
        return new self($this->size * 2, $qty);
    }

    private static function isPowerOfTwo(int $n): bool
    {
        return $n > 0 && ($n & ($n - 1)) === 0;
    }
}
