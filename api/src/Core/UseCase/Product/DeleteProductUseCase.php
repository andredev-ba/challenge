<?php

namespace Core\UseCase\Product;

use Core\Domain\Product\Repository\ProductRepositoryInterface;

use Core\UseCase\Product\DTO\{
    DeleteProductInputDto as InputDto,
    DeleteProductOutputDto as OutputDto
};

use DateTime;

class DeleteProductUseCase
{
    public function __construct(
        protected ProductRepositoryInterface $repository
    ) {}

    public function execute(InputDto $input) {
        $deleted = $this->repository->delete($input->id);

        return new OutputDto(
            deleted: $deleted
        );
    }
}
