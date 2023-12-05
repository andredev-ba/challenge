<?php

namespace Core\UseCase\Product;

use Core\Domain\Product\Repository\ProductRepositoryInterface;
use Core\UseCase\Shared\Interfaces\FileStorageInterface;
use Core\Domain\Product\Entity\ProductEntity as Product;

use Core\UseCase\Product\DTO\{
    EditProductInputDto as InputDto,
    EditProductOutputDto as OutputDto
};

use Core\Domain\Shared\ValueObject\Uuid;

use DateTime;

class EditProductUseCase
{
    public function __construct(
        protected ProductRepositoryInterface $repository,
        protected FileStorageInterface $fileStorage
    ) {}

    public function execute(InputDto $input) {

        $product = $this->repository->findById($input->id);

        $imageUrl = $product->imageUrl;
        if (!empty($input->imageFile)) $imageUrl = $this->fileStorage->store('images/products', $input->imageFile);

        $product->update (
            name: $input->name,
            description: $input->description,
            price: $input->price,
            expirationDate: new DateTime($input->expirationDate),
            imageUrl: $imageUrl,
            categoryId: $input->categoryId ? new Uuid($input->categoryId) : null
        );

        $this->repository->update($product);

        return new OutputDto(
            id: $product->id
        );
    }
}
