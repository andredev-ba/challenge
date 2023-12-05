<?php

namespace Core\UseCase\Product\DTO;

class EditProductInputDto
{
    public function __construct(
        public string $id,
        public string $name,
        public ?string $description = '',
        public float $price = 0,
        public string $expirationDate,
        public ?array $imageFile = [],
        public ?string $categoryId = null
    ) {}
}