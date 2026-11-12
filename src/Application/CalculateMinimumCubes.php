<?php

namespace App\Application;

use App\Domain\Box;
use App\Domain\BoxService;
use App\Domain\Cubes;

final readonly class CalculateMinimumCubes
{
    public function __construct(
        private BoxService $boxService,
    ) {
    }

    public function execute(Box $box, Cubes $cubes): int
    {
        return $this->boxService->minimumCubesToFill($box, $cubes);
    }
}
