<?php

namespace Core\UseCase\Product;

use Core\Domain\Product\Repository\ProductRepositoryInterface;
use Core\UseCase\Shared\Interfaces\FileStorageInterface;
use Core\Domain\Product\Entity\ProductEntity as Product;

use Core\UseCase\Product\DTO\{
    AddProductInputDto as InputDto,
    AddProductOutputDto as OutPutDto
};

use Core\Domain\Shared\ValueObject\Uuid;

use DateTime;

class AddProductUseCase
{
    public function __construct(
        protected ProductRepositoryInterface $repository,
        protected FileStorageInterface $fileStorage
    ) {}

    public function execute(InputDto $input) {

        $imageUrl = 'https://placehold.co/50x50/CCC/FFF?text=sem\nimagem';
        if (!empty($input->imageFile)) $imageUrl = $this->fileStorage->store('images/products', $input->imageFile);

        $product = new Product(
            name: $input->name,
            description: $input->description,
            price: $input->price,
            expirationDate: new DateTime($input->expirationDate),
            imageUrl: $imageUrl,
            categoryId: $input->categoryId ? new Uuid($input->categoryId) : null
        );

        $this->repository->insert($product);

        return new OutputDto(
            id: $product->id
        );
    }
}
