<?php

namespace App\Entity\DTO;

use Stringable;
use Symfony\Component\Validator\Constraints as Assert;

class ItemDTO implements Stringable
{
    #[Assert\Regex(pattern:"/^\d+$/")]
    public ?string $id;

    #[Assert\NotBlank]
    public ?string $categoryName;

    #[Assert\NotBlank]
    public ?string $sku;
    public ?string $name;
    public ?string $description;
    public ?string $shortdesc;

    #[Assert\Regex(pattern:"/^\d+(\.\d+)?$/")]
    public ?string $price;

    #[Assert\Url()]
    public ?string $link;

    #[Assert\Url()]
    public ?string $image;
    public ?string $brand;

    #[Assert\Regex(pattern:"/^\d+(\.\d+)?$/")]
    public ?string $rating;
    public ?string $caffeineType;

    #[Assert\Regex(pattern:"/^\d+$/")]
    public ?string $count;

    #[Assert\Regex(pattern:"/^(yes|no|)$/i")]
    public ?string $flavored;

    #[Assert\Regex(pattern:"/^(yes|no|)$/i")]
    public ?string $seasonal;

    #[Assert\Regex(pattern:"/^(yes|no|)$/i")]
    public ?string $instock;

    #[Assert\Choice(choices:['0', '1', ''])]
    public ?string $facebook;

    #[Assert\Choice(choices:['0', '1', ''])]
    public ?string $isKCup;

    /**
     * @param array<string, mixed> $data
     */
    public function __construct(array $data)
    {
       $this->id = $data['entity_id'] ?? null;
       $this->categoryName = $data['CategoryName'] ?? null;
       $this->sku = $data['sku'] ?? null;
       $this->name = $data['name'] ?? null;
       $this->description = $data['description'] ?? null;
       $this->shortdesc = $data['shortdesc'] ?? null;
       $this->price = $data['price'] ?? null;
       $this->link = $data['link'] ?? null;
       $this->image = $data['image'] ?? null;
       $this->brand = $data['Brand'] ?? null;
       $this->rating = $data['Rating'] ?? null;
       $this->caffeineType = $data['CaffeineType'] ?? null;
       $this->count = $data['Count'] ?? null;
       $this->flavored = $data['Flavored'] ?? null;
       $this->seasonal = $data['Seasonal'] ?? null;
       $this->instock = $data['Instock'] ?? null;
       $this->facebook = $data['Facebook'] ?? null;
       $this->isKCup = $data['IsKCup'] ?? null;
    }

    public function __toString()
    {
        return "Id: {$this->id}, CategoryName: {$this->categoryName}, SKU: {$this->sku}, Name: {$this->name}, Description: {$this->description}, ShortDesc: {$this->shortdesc}, Price: {$this->price}, Link: {$this->link}, Image: {$this->image}, Brand: {$this->brand}, Rating: {$this->rating}, CaffeineType: {$this->caffeineType}, Count: {$this->count}, Flavored: {$this->flavored}, Seasonal: {$this->seasonal}, Instock: {$this->instock}, Facebook: {$this->facebook}, IsKCup: {$this->isKCup}";
    }
}