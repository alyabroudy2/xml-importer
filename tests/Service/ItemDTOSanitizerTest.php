<?php

namespace App\Tests\Service;

use App\Entity\DTO\ItemDTO;
use App\Service\ItemDTOSanitizer;
use PHPUnit\Framework\TestCase;

class ItemDTOSanitizerTest extends TestCase
{
    public function testSanitize(): void
    {
        $sanitizer = new ItemDTOSanitizer();

        $itemDTO = new ItemDTO([
            'entity_id' => '340',
            'price' =>'"66"',
            'link' =>'
            http://www.coffeeforless.com/tazo-om-tea-24ct-box.html  ',
            'image' =>'   http://mcdn.#coffeeforless.com/media/catalog/product/images/coffeepods/tazo-om-tea-24ct-box.jpg',
       ]);

        $sanitizedItem = $sanitizer->sanitize($itemDTO);

        $this->assertEquals('http://www.coffeeforless.com/tazo-om-tea-24ct-box.html',
            $sanitizedItem->link);
        $this->assertEquals("http://mcdn.#coffeeforless.com/media/catalog/product/images/coffeepods/tazo-om-tea-24ct-box.jpg",
            $sanitizedItem->image);
        $this->assertEquals('66', $sanitizedItem->price);
    }
}
