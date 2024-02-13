<?php

namespace App\Service;

use App\Entity\DTO\CatalogDTO;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * parse xml contents into CatalogDTO
 */
class XmlParser
{
    public function __construct(
        private readonly SerializerInterface $serializer
    )
    {
    }

    public function parse(string $data):CatalogDTO
    {
        return $this->serializer->deserialize(
            $data,
            CatalogDTO::class,
            XmlEncoder::FORMAT,
        );
    }

}