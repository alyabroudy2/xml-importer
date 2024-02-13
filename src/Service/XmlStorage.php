<?php

namespace App\Service;

use League\Flysystem\DirectoryListing;
use League\Flysystem\FilesystemException;
use League\Flysystem\FilesystemOperator;
use League\Flysystem\StorageAttributes;

/**
 * manage xml files storage => list and read xml files
 */
class XmlStorage
{
    public const XML_EXTENSION = 'xml';

    public function __construct(private readonly FilesystemOperator $xmlStorage)
    {
    }

    /**
     * @throws FilesystemException
     * @return DirectoryListing<StorageAttributes>
     */
    public function listFiles(): DirectoryListing
    {
        return $this->xmlStorage
            ->listContents('')
            ->filter(fn(StorageAttributes $item) => $item->isFile())
            ->filter(fn(StorageAttributes $item) => $this->support($item));
    }

    private function support(StorageAttributes $item):bool
    {
        return str_ends_with($item->path(), '.'.self::XML_EXTENSION);
    }

    /**
     * @param StorageAttributes $item
     * @return string
     * @throws FilesystemException
     */
    public function read(StorageAttributes $item): string
    {
        return $this->xmlStorage->read($item->path());
    }
}