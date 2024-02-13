<?php

namespace App\Service;

use App\Entity\DTO\ItemDTO;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;

class XmlDBImporter
{
    // error item exist already in the database
    const STATE_ERROR_DUPLICATE_ITEM = 'duplicate_item_error';

    // error while persisting new items to database
    const STATE_ERROR_PERSIST = 'persist_error';

    // item contains invalid data
    const STATE_ERROR_INVALID_ITEM = 'item_error';

    // item successfully imported to database
    const STATE_IMPORTED = 'imported';

    public function __construct(
        private EntityManagerInterface    $entityManager,
        private readonly ProductGenerator $generator,
        private readonly LoggerInterface  $importerLogger
    )
    {
    }

    public function import(ItemDTO $itemDTO): string
    {
        $product = $this->generator->generateProduct($itemDTO);
        try {
            if (!$product) {
                return self::STATE_ERROR_INVALID_ITEM;
            }
            $exist = $this->entityManager->getRepository(Product::class)
                ->findOneBy(['id' => $product->getId()]);
            if ($exist) {
                $message = sprintf('%s item[%d]',
                    self::STATE_ERROR_DUPLICATE_ITEM,
                    $product->getId()
                );

                $this->importerLogger->error($message);
                return self::STATE_ERROR_DUPLICATE_ITEM;
            }
            $this->entityManager->persist($product);
            $this->entityManager->flush();

        } catch (\Exception $exception) {
            $this->handleException($exception, $product);
            return self::STATE_ERROR_PERSIST;
        }
        return self::STATE_IMPORTED;
    }

    private function handleException(\Throwable $exception, Product $product): void
    {
        $this->importerLogger->error(
            sprintf('%s item[%d]: %s',
                self::STATE_ERROR_PERSIST,
                $product->getId(),
                $exception->getMessage()
            ));
        $this->entityManager->rollback();
    }

}