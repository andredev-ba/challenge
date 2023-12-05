<?php

namespace Core\Domain\Product\Repository;

use Core\Domain\Shared\Repository\PaginationInterface;
use Core\Domain\Product\Entity\ProductEntity;

interface ProductRepositoryInterface
{
    public function paginate(array $filters): PaginationInterface;
    public function findById(string $productId): ProductEntity;
    public function insert(ProductEntity $product): void;
    public function update(ProductEntity $product): void;
    public function delete(string $productId): bool;
}