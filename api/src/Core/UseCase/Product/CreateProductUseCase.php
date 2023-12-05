<?php

namespace Core\UseCase\Product;

use Core\Domain\Category\Repository\CategoryRepositoryInterface;

use Core\UseCase\Product\DTO\CreateProductOutputDto as OutputDto;

use DateTime;

class CreateProductUseCase
{
    public function __construct(
        protected CategoryRepositoryInterface $categoryRepository
    ) {}

    public function execute() {
        $createData = $this->categoryRepository->findAll();

        return new OutputDto(
            options: [
                'categories' => $createData->toQuasarFormSelect()
            ]
        );
    }
}
