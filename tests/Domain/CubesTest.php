<?php

namespace App\Tests\Domain;

use App\Domain\Cube;
use App\Domain\Cubes;
use PHPUnit\Framework\TestCase;

final class CubesTest extends TestCase
{
    public function testHoldsGivenCubesInOrder(): void
    {
        $small = new Cube(1, 5);
        $big = new Cube(4, 2);

        $cubes = new Cubes($small, $big);

        self::assertCount(2, $cubes);
        self::assertSame([$small, $big], $cubes->items);
        self::assertSame([$small, $big], iterator_to_array($cubes));
    }

    public function testCanBeEmpty(): void
    {
        self::assertCount(0, new Cubes());
    }
}
