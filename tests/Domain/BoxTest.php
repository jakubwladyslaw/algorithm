<?php

namespace App\Tests\Domain;

use App\Domain\Box;
use App\Domain\Cube;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class BoxTest extends TestCase
{
    public function testVolume(): void
    {
        self::assertSame(150, (new Box(width: 5, height: 5, depth: 6))->volume());
    }

    public function testCapacityForCountsCubesOnGridFromCorner(): void
    {
        $box = new Box(width: 5, height: 5, depth: 6);

        self::assertSame(1, $box->capacityFor(new Cube(size: 4, qty: 0)));
        self::assertSame(12, $box->capacityFor(new Cube(size: 2, qty: 0)));
        self::assertSame(150, $box->capacityFor(new Cube(size: 1, qty: 0)));
        self::assertSame(0, $box->capacityFor(new Cube(size: 8, qty: 0)));
    }

    public function testRejectsNonPositiveDimensions(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new Box(width: 0, height: 1, depth: 1);
    }
}
