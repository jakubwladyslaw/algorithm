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

    public function testPrintsFileContent(): void
    {
        $file = tempnam(sys_get_temp_dir(), 'problems');
        file_put_contents($file, "3 4 5\n1 2 3\n");

        try {
            $this->tester->execute(['file' => $file]);
        } finally {
            unlink($file);
        }

        $this->tester->assertCommandIsSuccessful();
        self::assertSame("3 4 5\n1 2 3\n", $this->tester->getDisplay());
    }

    public function testFailsWhenFileIsMissing(): void
    {
        $this->tester->execute(['file' => '/nonexistent/problems.txt']);

        self::assertSame(Command::FAILURE, $this->tester->getStatusCode());
        self::assertStringContainsString('does not exist', $this->tester->getDisplay());
    }
}
