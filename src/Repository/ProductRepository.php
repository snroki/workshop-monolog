<?php

declare(strict_types=1);

namespace App\Repository;

use App\Dto\ProductDto;

class ProductRepository
{
    public function create(ProductDto $productDto): void
    {
        // Persist it to the database
        if ('boom' === $productDto->name) {
            throw new \Exception('Error while persisting product');
        }
    }

    public function getExpiredProducts(): array
    {
        return range(0, 100);
    }

    public function remove(int $id): void
    {
        // Remove it from the database
        if (50 === $id) {
            throw new \Exception('Error while removing product');
        }
    }
}
