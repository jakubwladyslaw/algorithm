<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\Argument;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(name: 'boxes:calculate', description: 'Reads a problems file and prints its content')]
final class BoxesCalculateCommand
{
    public function __invoke(
        SymfonyStyle $io,
        #[Argument(description: 'Path to the problems file')] string $file,
    ): int {
        if (!is_file($file) || !is_readable($file)) {
            $io->error(sprintf('File "%s" does not exist or is not readable.', $file));

            return Command::FAILURE;
        }

        $io->write((string) file_get_contents($file));

        return Command::SUCCESS;
    }
}
