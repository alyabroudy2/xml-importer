<?php

namespace App\Service;

use App\Entity\DTO\ItemDTO;
use App\Entity\Product;
use Psr\Log\LoggerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ProductGenerator
{
    public function __construct(
        private readonly ValidatorInterface $validator,
        private readonly LoggerInterface $importerLogger
    )
    {
    }

    public function generateProduct(ItemDTO $itemDTO): ?Product
    {
        // Validate the entity
        $violations = $this->validator->validate($itemDTO);
        if ($violations->count() > 0){
            foreach ($violations as $violation){
                $message = sprintf('item_error: item[%s] invalid value [%s] for property [%s]',
                    $itemDTO->id,
                    $violation->getInvalidValue(), $violation->getPropertyPath());
                $this->importerLogger->error($message);
            }
            return null;
        }
        $product = new Product();
        $product->setId((int)$itemDTO->id);
        $product->setCategoryName($itemDTO->categoryName);
        $product->setSku($itemDTO->sku);
        $product->setName($itemDTO->name);
        $product->setDescription($itemDTO->description);
        $product->setShortdesc($itemDTO->shortdesc);
        $product->setPrice((float)$itemDTO->price);
        $product->setLink($itemDTO->link);
        $product->setImage($itemDTO->image);
        $product->setBrand($itemDTO->brand);
        $product->setRating((float)$itemDTO->rating);
        $product->setCaffeineType($itemDTO->caffeineType);
        $product->setCount((int)$itemDTO->count);
        $product->setFlavored($this->getStringsBoolean((string)$itemDTO->flavored));
        $product->setSeasonal($this->getStringsBoolean((string)$itemDTO->seasonal));
        $product->setInstock($this->getStringsBoolean((string)$itemDTO->instock));
        $product->setFacebook((int)$itemDTO->facebook);
        $product->setIsKCup((int)$itemDTO->isKCup);

        return $product;
    }

    private function getStringsBoolean(string $value):bool
    {
        $value = strtolower($value);
        if ($value === 'yes')
        {
            return true;
        }
        return false;
    }
}