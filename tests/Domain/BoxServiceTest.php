<?php

namespace App\Tests\Domain;

use App\Domain\Box;
use App\Domain\BoxService;
use App\Domain\Cube;
use App\Domain\Cubes;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class BoxServiceTest extends TestCase
{
    #[DataProvider('problems')]
    public function testMinimumCubesToFill(Box $box, Cubes $cubes, int $expected): void
    {
        $result = (new BoxService())->minimumCubesToFill($box, $cubes);

        self::assertSame($expected, $result);
    }

    /**
     * expected = smallest number of cubes that fill the box, -1 when it can't be filled.
     */
    public static function problems(): iterable
    {
        yield 'not enough cubes' => [
            'box' => new Box(width: 10, height: 10, depth: 10),
            'cubes' => new Cubes(
                new Cube(size: 1, qty: 1),
                new Cube(size: 2, qty: 2),
            ),
            'expected' => -1,
        ];

        yield 'only 2x2x2 cubes fill the box' => [
            'box' => new Box(width: 10, height: 10, depth: 10),
            'cubes' => new Cubes(
                new Cube(size: 2, qty: 125)
            ),
            'expected' => 125,
        ];

        yield 'extra 1x1x1 cube is not needed' => [
            'box' => new Box(width: 10, height: 10, depth: 10),
            'cubes' => new Cubes(
                new Cube(size: 1, qty: 1),
                new Cube(size: 2, qty: 125)
            ),
            'expected' => 125,
        ];

        yield '2 2 2 8 1' => [
            'box' => new Box(width: 2, height: 2, depth: 2),
            'cubes' => new Cubes(
                new Cube(size: 1, qty: 8),
                new Cube(size: 2, qty: 1),
            ),
            'expected' => 1,
        ];

        yield '1 2 4 8 1' => [
            'box' => new Box(width: 1, height: 2, depth: 4),
            'cubes' => new Cubes(
                new Cube(size: 1, qty: 8),
                new Cube(size: 2, qty: 1),
            ),
            'expected' => 8,
        ];

        yield '10 10 10 2000' => [
            'box' => new Box(width: 10, height: 10, depth: 10),
            'cubes' => new Cubes(
                new Cube(size: 1, qty: 2000),
            ),
            'expected' => 1000,
        ];

        yield '10 10 10 900' => [
            'box' => new Box(width: 10, height: 10, depth: 10),
            'cubes' => new Cubes(
                new Cube(size: 1, qty: 900),
            ),
            'expected' => -1,
        ];

        yield '4 4 8 10 10 1' => [
            'box' => new Box(width: 4, height: 4, depth: 8),
            'cubes' => new Cubes(
                new Cube(size: 1, qty: 10),
                new Cube(size: 2, qty: 10),
                new Cube(size: 4, qty: 1),
            ),
            'expected' => 9,
        ];

        yield '5 5 5 61 7 1' => [
            'box' => new Box(width: 5, height: 5, depth: 5),
            'cubes' => new Cubes(
                new Cube(size: 1, qty: 61),
                new Cube(size: 2, qty: 7),
                new Cube(size: 4, qty: 1),
            ),
            'expected' => 62,
        ];

        yield '5 5 6 61 4 1' => [
            'box' => new Box(width: 5, height: 5, depth: 6),
            'cubes' => new Cubes(
                new Cube(size: 1, qty: 61),
                new Cube(size: 2, qty: 4),
                new Cube(size: 4, qty: 1),
            ),
            'expected' => 59,
        ];

        yield '1000 1000 1000 0 0 0 46501 0 2791 631 127 19 1' => [
            'box' => new Box(width: 1000, height: 1000, depth: 1000),
            'cubes' => new Cubes(
                new Cube(size: 1, qty: 0),
                new Cube(size: 2, qty: 0),
                new Cube(size: 4, qty: 0),
                new Cube(size: 8, qty: 46501),
                new Cube(size: 16, qty: 0),
                new Cube(size: 32, qty: 2791),
                new Cube(size: 64, qty: 631),
                new Cube(size: 128, qty: 127),
                new Cube(size: 256, qty: 19),
                new Cube(size: 512, qty: 1),
            ),
            'expected' => 50070,
        ];

        yield '1 1 9 9 1' => [
            'box' => new Box(width: 1, height: 1, depth: 9),
            'cubes' => new Cubes(
                new Cube(size: 1, qty: 9),
                new Cube(size: 2, qty: 1),
            ),
            'expected' => 9,
        ];
    }
}
