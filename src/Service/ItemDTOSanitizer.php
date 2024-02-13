<?php

namespace App\Service;

use App\Entity\DTO\ItemDTO;

class ItemDTOSanitizer
{

    public function sanitize(ItemDTO $item):ItemDTO
    {
        $item->image = $this->cleanUrlField($item->image);
        $item->link = $this->cleanUrlField($item->link);
        $item->price = $this->cleanUrlField($item->price);
        return $item;
    }

    private function cleanUrlField(?string $contents): ?string
    {
        // Check if the image URL is not null or empty
        if (!empty($contents)) {
            // Trim whitespace and remove newlines
            $cleanedContents = trim($contents);

            // Remove extra spaces
            $cleanedContents = preg_replace('/\s+/', ' ', $cleanedContents);
            // Remove double quotes
            $cleanedContents = str_replace('"', '', (string)$cleanedContents);
            return $cleanedContents;
        }

        return null;
    }
}