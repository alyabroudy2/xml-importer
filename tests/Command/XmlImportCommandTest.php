<?php

namespace App\Tests\Command;

use App\Command\XmlImportCommand;
use App\Service\XmlDBImporter;
use App\Service\XmlParser;
use App\Service\XmlStorage;
use League\Flysystem\DirectoryListing;
use League\Flysystem\FileAttributes;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

class XmlImportCommandTest extends TestCase
{

    public function testExecute(): void
    {
        // Create mocks for the dependencies
        $parser = $this->createMock(XmlParser::class);
        $storage = $this->createMock(XmlStorage::class);
        $importer = $this->createMock(XmlDBImporter::class);
        $importerLogger = $this->createMock(LoggerInterface::class);

        $storageAttribute = new FileAttributes('test/storage/feed.xml');
        $directoryListing = $this->createMock(DirectoryListing::class);
        $directoryListing->method('toArray')->willReturn([$storageAttribute]);
        $storage->expects($this->once())->method('listFiles')->willReturn($directoryListing);
        $command = new XmlImportCommand($parser, $storage, $importer, $importerLogger);

        $application = new Application();
        $application->add($command);

        $commandTester = new CommandTester($command);

        $commandTester->execute([]);
        $this->assertStringContainsString('[WARNING] No items has been found in[test/storage/feed.xml] ', $commandTester->getDisplay());
    }
}