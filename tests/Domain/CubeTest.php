<?php

namespace App\Tests\Domain;

use App\Domain\Cube;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class CubeTest extends TestCase
{
    public function testNextDoublesSizeAndSetsQuantity(): void
    {
        $cube = new Cube(2, 1);

        $next = $cube->next(3);

        self::assertSame(4, $next->size);
        self::assertSame(3, $next->qty);
        self::assertSame(2, $cube->size, 'Original cube must stay unchanged.');
    }

    public function testNextRejectsNegativeQuantity(): void
    {
        $this->expectException(InvalidArgumentException::class);

        (new Cube(4, 1))->next(-1);
    }

    #[DataProvider('invalidSizes')]
    public function testRejectsSizeThatIsNotPowerOfTwo(int $size): void
    {
        $this->expectException(InvalidArgumentException::class);

        new Cube($size, 1);
    }

    public static function invalidSizes(): iterable
    {
        yield [0];
        yield [-4];
        yield [3];
        yield [6];
        yield [12];
    }
}
