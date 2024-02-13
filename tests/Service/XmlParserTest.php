<?php

namespace App\Tests\Service;

use App\Entity\DTO\CatalogDTO;
use App\Entity\DTO\ItemDTO;
use App\Service\XmlParser;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\SerializerInterface;

class XmlParserTest extends TestCase
{
    private XmlParser $parser;
    private SerializerInterface $serializer;
    protected function setUp(): void
    {
        $this->serializer = $this->createMock(SerializerInterface::class);

        $this->parser = new XmlParser($this->serializer);
    }

    public function testParse(): void
    {
        $xmlData = <<<XML
<?xml version="1.0" encoding="utf-8"?>
<catalog>
    <item>
        <entity_id>340</entity_id>
        <CategoryName><![CDATA[Green Mountain Ground Coffee]]></CategoryName>
        <sku>20</sku>
        <name><![CDATA[Green Mountain Coffee French Roast Ground Coffee 24 2.2oz Bag]]></name>
        <description></description>
        <shortdesc>
            <![CDATA[Green Mountain Coffee French Roast Ground Coffee 24 2.2oz Bag steeps cup after cup of smoky-sweet, complex dark roast coffee from Green Mountain Ground Coffee.]]></shortdesc>
        <price>41.6000</price>
        <link>http://www.coffeeforless.com/green-mountain-coffee-french-roast-ground-coffee-24-2-2oz-bag.html</link>
        <image>http://mcdn.coffeeforless.com/media/catalog/product/images/uploads/intro/frac_box.jpg</image>
        <Brand><![CDATA[Green Mountain Coffee]]></Brand>
        <Rating>0</Rating>
        <CaffeineType>Caffeinated</CaffeineType>
        <Count>24</Count>
        <Flavored>No</Flavored>
        <Seasonal>No</Seasonal>
        <Instock>Yes</Instock>
        <Facebook>1</Facebook>
        <IsKCup>0</IsKCup>
    </item>
</catalog>
XML;

        $itemDTO = new ItemDTO([
            'entity_id' => '340',
                'CategoryName' => '![CDATA[Green Mountain Ground Coffee]]',
                'sku' =>'20',
                'name' =>'![CDATA[Green Mountain Coffee French Roast Ground Coffee 24 2.2oz Bag]]',
                'description' => '',
        'shortdesc' =>
            '![CDATA[Green Mountain Coffee French Roast Ground Coffee 24 2.2oz Bag steeps cup after cup of smoky-sweet, complex dark roast coffee from Green Mountain Ground Coffee.]]',
        'price' =>'41.6000'
        ]);

        $catalogDTO = new CatalogDTO();
        $catalogDTO->item = [$itemDTO];

        $this->serializer
            ->method('deserialize')
            ->willReturn($catalogDTO);

        $result = $this->parser->parse($xmlData);

        $this->assertSame($catalogDTO, $result);
    }
}
