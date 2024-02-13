<?php

namespace App\Tests\Service;

use App\Service\XmlStorage;
use League\Flysystem\Filesystem;
use League\Flysystem\Local\LocalFilesystemAdapter;
use PHPUnit\Framework\TestCase;

class XmlStorageTest extends TestCase
{
    private XmlStorage $storage;

    protected function setUp(): void
    {
        $testStoragePath = 'tests/storage/xml';
        $adapter = new LocalFilesystemAdapter($testStoragePath);
        $storage = new Filesystem($adapter);
        $this->storage = new XmlStorage($storage);
    }

    public function testListFiles(): void
    {
        $files = $this->storage->listFiles();
        $arrayResult = $files->toArray();
        $this->assertSame(2, count($arrayResult));
        $this->assertSame('feed.xml', $arrayResult[0]->path());
    }

    public function testRead(): void
    {
        $files = $this->storage->listFiles()->toArray();
        $readResult = $this->storage->read($files[0]);
        $match = '<?xml version="1.0" encoding="utf-8"?>
<catalog>
    <item>
        <entity_id>340</entity_id>
        <CategoryName><![CDATA[Green Mountain Ground Coffee]]></CategoryName>
        <sku>20</sku>';
        $this->assertStringContainsString($match, $readResult);
    }
}
