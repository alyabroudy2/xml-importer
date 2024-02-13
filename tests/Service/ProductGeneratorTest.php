<?php

namespace App\Tests\Service;

use App\Entity\DTO\ItemDTO;
use App\Entity\Product;
use App\Service\ProductGenerator;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ProductGeneratorTest extends TestCase
{
    private ProductGenerator $generator;
    private ValidatorInterface $validator;
    private LoggerInterface $importerLogger;

    protected function setUp(): void
    {
        $this->validator = $this->createMock(ValidatorInterface::class);
        $this->importerLogger = $this->createMock(LoggerInterface::class);
        $this->generator = new ProductGenerator($this->validator, $this->importerLogger);
    }

    public function testGenerateProduct(): void
    {
        $itemDTO = new ItemDTO([
            'entity_id' => '340',
            'CategoryName' => 'Green Mountain Ground Coffee',
            'sku' =>'20',
            'name' =>'Green Mountain Coffee French Roast Ground Coffee 24 2.2oz Bag',
            'description' => '',
            'shortdesc' =>
                'Green Mountain Coffee French Roast Ground Coffee 24 2.2oz Bag steeps cup after cup of smoky-sweet, complex dark roast coffee from Green Mountain Ground Coffee.',
            'price' =>'41.6000'
        ]);

        $product = $this->generator->generateProduct($itemDTO);

        $expectedProduct = new Product();
        $expectedProduct->setId(340);
        $expectedProduct->setCategoryName('Green Mountain Ground Coffee');
        $expectedProduct->setSku(20);
        $expectedProduct->setName('Green Mountain Coffee French Roast Ground Coffee 24 2.2oz Bag');
        $expectedProduct->setDescription('');
        $expectedProduct->setShortdesc('Green Mountain Coffee French Roast Ground Coffee 24 2.2oz Bag steeps cup after cup of smoky-sweet, complex dark roast coffee from Green Mountain Ground Coffee.',);
        $expectedProduct->setPrice(41.6000);

        $this->assertEquals($product, $expectedProduct);
   }
}
