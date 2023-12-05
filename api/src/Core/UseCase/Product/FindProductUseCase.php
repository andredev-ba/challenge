<?php

namespace Core\UseCase\Product;

use Core\Domain\Product\Repository\ProductRepositoryInterface;
use Core\Domain\Category\Repository\CategoryRepositoryInterface;

use Core\UseCase\Product\DTO\{
    FindProductInputDto as InputDto,
    FindProductOutputDto as OutputDto
};

use DateTime;

class FindProductUseCase
{
    public function __construct(
        protected ProductRepositoryInterface $repository,
        protected CategoryRepositoryInterface $categoryRepository
    ) {}

    public function execute(InputDto $input) {
        $product = $this->repository->findById($input->id);
        $createData = $this->categoryRepository->findAll();

        return new OutputDto(
            id: $product->id,
            name: $product->name,
            description: $product->description,
            price: $product->price * 100,
            expirationDate: $product->expirationDate->format('Y-m-d'),
            imageUrl: $product->imageUrl,
            categoryId: $product->categoryId,
            options: [
                'categories' => $createData->toQuasarFormSelect()
            ]
        );
    }
}
