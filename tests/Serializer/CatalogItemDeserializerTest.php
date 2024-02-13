<?php

namespace App\Tests\Serializer;

use App\Entity\DTO\ItemDTO;
use App\Serializer\CatalogItemDeserializer;
use App\Service\ItemDTOSanitizer;
use PHPUnit\Framework\TestCase;

class CatalogItemDeserializerTest extends TestCase
{
    private CatalogItemDeserializer $deserializer;
    private ItemDTOSanitizer $dtoSanitizer;

    protected function setUp(): void
    {
        $this->dtoSanitizer = $this->createMock(ItemDTOSanitizer::class);
        $this->deserializer = new CatalogItemDeserializer($this->dtoSanitizer);
    }

    public function testDenormalize(): void
    {
        $data = [
            'id' => 1,
            'name' => 'Testname',
        ];

        $expectedDTO = new ItemDTO($data);

        // Define expectations for the mock
        $this->dtoSanitizer->expects($this->once())
            ->method('sanitize')
            ->with($expectedDTO)
            ->willReturn($expectedDTO);

        $result = $this->deserializer->denormalize($data, ItemDTO::class);

        $this->assertEquals($expectedDTO, $result);
    }

    public function testSupportsDenormalization(): void
    {
        // Create an instance of the class under test
        $deserializer = new CatalogItemDeserializer($this->createMock(ItemDTOSanitizer::class));

        // Test with supported type
        $this->assertTrue($deserializer->supportsDenormalization([], ItemDTO::class));

        // Test with unsupported type
        $this->assertFalse($deserializer->supportsDenormalization([], 'Product'));
    }

}