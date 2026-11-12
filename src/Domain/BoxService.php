<?php

namespace App\Domain;

final readonly class BoxService
{
    public const int NO_SOLUTION = -1;

    /**
     * Greedy, largest cubes first. Because every side is a power of two, the space
     * filled by bigger cubes always splits exactly into cubes of the next smaller size,
     * so using as many big cubes as fit never makes the result worse.
     */
    public function minimumCubesToFill(Box $box, Cubes $cubes): int
    {
        $filling = BoxFilling::start($box);

        foreach ($cubes->sortedBySizeDesc() as $cube) {
            $filling = $filling->fillWith($cube);
        }

        return $filling->isFull() ? $filling->usedCubes : self::NO_SOLUTION;
    }
}
