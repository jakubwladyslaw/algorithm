<?php

namespace App\Command;

use App\Application\CalculateMinimumCubes;
use App\Domain\Box;
use App\Domain\Cube;
use App\Domain\Cubes;
use InvalidArgumentException;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\StreamableInputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(name: 'boxes:calculate', description: 'Reads problems from stdin and prints the smallest number of cubes that fill each box (-1 if impossible)')]
final readonly class BoxesCalculateCommand
{
    public function __construct(
        private CalculateMinimumCubes $calculateMinimumCubes,
    ) {
    }

    public function __invoke(InputInterface $input, SymfonyStyle $io): int
    {
        $stdin = $this->stdinOf($input);

        $lineNumber = 0;
        while (false !== ($line = fgets($stdin))) {
            ++$lineNumber;

            if ('' === trim($line)) {
                continue;
            }

            try {
                [$box, $cubes] = $this->parse($line);
                $io->writeln((string) $this->calculateMinimumCubes->execute($box, $cubes));
            } catch (InvalidArgumentException $e) {
                $io->getErrorStyle()->error(sprintf('Line %d: %s', $lineNumber, $e->getMessage()));

                return Command::FAILURE;
            }
        }

        return Command::SUCCESS;
    }

    /**
     * Real stdin when run from the shell; CommandTester replaces it with
     * an in-memory stream (setInputs()), so tests can feed problems.
     *
     * @return resource
     */
    private function stdinOf(InputInterface $input)
    {
        if ($input instanceof StreamableInputInterface && null !== $input->getStream()) {
            return $input->getStream();
        }

        return STDIN;
    }

    /**
     * Line format: "width height depth qty0 qty1 ...", where qtyN is the number of cubes with side 2^N.
     *
     * @return array{Box, Cubes}
     */
    private function parse(string $line): array
    {
        $numbers = array_map('intval', explode(' ', trim($line)));

        if (count($numbers) < 4) {
            throw new InvalidArgumentException('Expected box dimensions and at least one cube quantity.');
        }

        [$width, $height, $depth] = array_splice($numbers, 0, 3);

        $cubes = [];
        /** @var Cube|null $cube */
        $cube = null;
        foreach ($numbers as $qty) {
            $cube = null === $cube ? new Cube(size: 1, qty: $qty) : $cube->next($qty);
            $cubes[] = $cube;
        }

        return [new Box(width: $width, height: $height, depth: $depth), new Cubes(...$cubes)];
    }
}
