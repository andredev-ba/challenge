<?php

namespace Core\UseCase\Product\DTO;

class FindProductOutputDto
{
    public function __construct(
        public string $id,
        public string $name,
        public ?string $description = '',
        public ?string $price = '0,00',
        public string $expirationDate,
        public ?string $imageUrl = '',
        public ?string $categoryId = null,
        public ?array $options = []
    ) {}
}
