<?php

namespace App\Domain;

/**
 * Cubes must be added from the largest size to the smallest: the volume taken by bigger
 * cubes then always splits exactly into cubes of the smaller size.
 */
readonly class BoxFilling
{
    public function __construct(
        public Box $box,
        public int $usedVolume = 0,
        public int $usedCubes = 0,
    ) {
    }

    public static function start(Box $box): self
    {
        return new self($box);
    }

    public function fillWith(Cube $cube): self
    {
        $alreadyTaken = intdiv($this->usedVolume, $cube->volume());
        $taken = min($cube->qty, $this->box->capacityFor($cube) - $alreadyTaken);

        return new self(
            $this->box,
            $this->usedVolume + $taken * $cube->volume(),
            $this->usedCubes + $taken,
        );
    }

    public function isFull(): bool
    {
        return $this->usedVolume === $this->box->volume();
    }
}
