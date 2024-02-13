<?php

namespace App\Command;

use App\Service\XmlDBImporter;
use App\Service\XmlParser;
use App\Service\XmlStorage;
use League\Flysystem\FilesystemException;
use League\Flysystem\StorageAttributes;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:xml-import',
    description: 'Import data from XML files to database',
)]
class XmlImportCommand extends Command
{
    public function __construct(
        private XmlParser     $parser,
        private XmlStorage    $storage,
        private XmlDBImporter $importer,
        private readonly LoggerInterface  $importerLogger
    )
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        // find xml files in the storage
        $xmlFiles = [];
        try {
            $xmlFiles = $this->storage->listFiles()->toArray();
            if (empty($xmlFiles)){
                $io->error('No xml files has been found.');
                return Command::FAILURE;
            }
        } catch (FilesystemException) {
            $io->error('Failure reading from xml storage');
            return Command::FAILURE;
        }

        // ask to choose one file if multiple files found
        $selectedFileIndex = 0;
        $selectedFileName = $xmlFiles[$selectedFileIndex]->path();

        if (count($xmlFiles) > 1) {
            // extract file names into list
            $fileNames = $this->extractFieNames($xmlFiles);

            // ask to choose file to import
            $question = new ChoiceQuestion(
                'Please select a file to import:',
                $fileNames,
                0
            );
            $selectedFileName = $io->askQuestion($question);
            $selectedFileIndex = array_search($selectedFileName, $fileNames);
        }

        $failMessage = sprintf('Import process for file[%s] failed. ',$selectedFileName);
        // try to read file contents
        try {
            $this->importerLogger->info(sprintf('Import process for file[%s] started',$selectedFileName));
            $xmlData = $this->storage->read($xmlFiles[$selectedFileIndex]);
        } catch (FilesystemException) {
            $message = sprintf('Invalid xml file [%s]',$selectedFileName);
            $io->error($message);
            $this->importerLogger->error(implode(', ',[$failMessage, $message]));
            return Command::FAILURE;
        }

        // try to parse file xml content into CatalogDTO object
        $catalogDTO = null;
        try {
            $catalogDTO = $this->parser->parse($xmlData);
        }catch (\Exception $exception)
        {
            $message = sprintf('Invalid xml contents: file[%s] %s',$selectedFileName, $exception->getMessage());
            $io->error($message);
            $this->importerLogger->error(implode(', ',[$failMessage, $message]));
            return Command::FAILURE;
        }

        if (empty($catalogDTO->item)) {
            $message = sprintf('No items has been found in[%s]',$selectedFileName);
            $io->warning($message);
            $io->error($message);
            $this->importerLogger->error(implode(', ',[$failMessage, $message]));
            return Command::FAILURE;
        }

        // prepare result infos
        $importResult = [
            XmlDBImporter::STATE_IMPORTED => [],
            XmlDBImporter::STATE_ERROR_DUPLICATE_ITEM => [],
            XmlDBImporter::STATE_ERROR_PERSIST => [],
            XmlDBImporter::STATE_ERROR_INVALID_ITEM => []
        ];

        // import the parsed xml contents to database
        foreach ($catalogDTO->item as $item) {
            $itemImportedState = $this->importer->import($item);
            $importResult[$itemImportedState][] = $item;
        }

        // print import result
        $successMessage = sprintf(
            'Success[%d] ',
            count($importResult[XmlDBImporter::STATE_IMPORTED])
        );

        $duplicateMessage = sprintf(
            'Duplicate items[%d]',
            count($importResult[XmlDBImporter::STATE_ERROR_DUPLICATE_ITEM])
        );

        $invalidMessage = sprintf(
            'Invalid items[%d]',
            count($importResult[XmlDBImporter::STATE_ERROR_INVALID_ITEM])
        );

        $doneMessage = sprintf('Import process for file[%s] done', $selectedFileName);
        $io->success($doneMessage);

        $io->text($successMessage);
        $io->text($duplicateMessage);
        $io->text($invalidMessage);

        $persistErrorCounts = count($importResult[XmlDBImporter::STATE_ERROR_PERSIST]);
        $persistErrorMessage = sprintf(
            'Persist Errors[%d]',
            $persistErrorCounts
        );
        if ($persistErrorCounts !== 0){
            $io->text($persistErrorMessage);
        }

        $this->importerLogger->info(implode(', ',
            [$doneMessage,
            $successMessage,
            $duplicateMessage,
            $invalidMessage,
            $persistErrorMessage]
        ));
        return Command::SUCCESS;
    }

    /**
     * @param array<int, StorageAttributes> $xmlFiles
     * @return array<int, string>
     */
    private function extractFieNames(array $xmlFiles): array
    {
        $nameList = [];
        foreach ($xmlFiles as $file) {
            $nameList[] = $file->path();
        }
        return $nameList;
    }
}
