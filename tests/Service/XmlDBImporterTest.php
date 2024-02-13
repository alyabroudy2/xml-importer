<?php

namespace App\Tests\Service;

use App\Entity\DTO\ItemDTO;
use App\Entity\Product;
use App\Repository\ProductRepository;
use App\Service\ProductGenerator;
use App\Service\XmlDBImporter;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class XmlDBImporterTest extends TestCase
{
    private XmlDBImporter $importer;
    private EntityManagerInterface $entityManager;
    private ProductGenerator $generator;
    private LoggerInterface $importerLogger;

    protected function setUp(): void
    {

        $this->entityManager = $this->createMock(EntityManagerInterface::class);
        $this->generator = $this->createMock(ProductGenerator::class);
        $this->importerLogger = $this->createMock(LoggerInterface::class);


        $this->importer = new XmlDBImporter($this->entityManager, $this->generator, $this->importerLogger);

    }

    public function testImport(): void
    {
        // Prepare test data
        $itemDTO = new ItemDTO([
            'entity_id' => '340',
            'CategoryName' => '![CDATA[Green Mountain Ground Coffee]]',
            'sku' => '20',
            'name' => '![CDATA[Green Mountain Coffee French Roast Ground Coffee 24 2.2oz Bag]]',
            'description' => '',
            'shortdesc' =>
                '![CDATA[Green Mountain Coffee French Roast Ground Coffee 24 2.2oz Bag steeps cup after cup of smoky-sweet, complex dark roast coffee from Green Mountain Ground Coffee.]]',
            'price' => '41.6000'
        ]);

        $product = new Product();
        $product->setId(340);
        $product->setCategoryName('Green Mountain Ground Coffee');
        $product->setSku(20);
        $product->setName('Green Mountain Coffee French Roast Ground Coffee 24 2.2oz Bag');
        $product->setDescription('');
        $product->setShortdesc('');
        $product->setPrice(41.6000);

        // Define expectations for the mocks
        $this->generator->expects($this->once())
            ->method('generateProduct')
            ->with($itemDTO)
            ->willReturn($product);

        $productRepo = $this->createMock(ProductRepository::class);
        $this->entityManager->expects($this->once())
            ->method('getRepository')
            ->willReturn($productRepo);

        $productRepo->expects($this->once())
            ->method('findOneBy')
            ->willReturn(null);

        $this->entityManager->expects($this->once())
            ->method('persist');

        $this->entityManager->expects($this->once())
            ->method('flush');

        $result = $this->importer->import($itemDTO);

        $this->assertEquals(XmlDBImporter::STATE_IMPORTED, $result);
    }
}
