<?php

namespace App\Tests\Command;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;

final class BoxesCalculateCommandTest extends KernelTestCase
{
    private CommandTester $tester;

    protected function setUp(): void
    {
        $application = new Application(self::bootKernel());
        $this->tester = new CommandTester($application->find('boxes:calculate'));
    }

    public function testPrintsSolution(): void
    {
        $this->tester->setInputs(['2 2 2 8 1']);
        $this->tester->execute([]);

        $this->tester->assertCommandIsSuccessful();
        self::assertSame("1\n", $this->tester->getDisplay());
    }

    public function testFailsOnInvalidLine(): void
    {
        $this->tester->setInputs(['2 2 2 8 1', '2 2 x 8']);
        $this->tester->execute([], ['capture_stderr_separately' => true]);

        self::assertSame(Command::FAILURE, $this->tester->getStatusCode());
        self::assertSame("1\n", $this->tester->getDisplay(), 'Only answers go to stdout.');
        self::assertStringContainsString('Line 2', $this->tester->getErrorOutput());
    }
}
