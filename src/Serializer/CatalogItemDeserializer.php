<?php

namespace App\Serializer;

use App\Entity\DTO\ItemDTO;
use App\Service\ItemDTOSanitizer;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class CatalogItemDeserializer implements DenormalizerInterface
{
    public function __construct(private ItemDTOSanitizer $DTOSanitizer)
    {
    }

    /**
     * @param $data
     * @param $type
     * @param $format
     * @param array<int|string, mixed> $context
     * @return ItemDTO
     */
    public function denormalize($data, $type, $format = null, array $context = [])
    {
        return $this->DTOSanitizer->sanitize(new ItemDTO($data));
    }

    public function supportsDenormalization($data, $type, $format = null)
    {
        return $type === ItemDTO::class;
    }
}
