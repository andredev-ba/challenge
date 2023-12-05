<?php

namespace Core\UseCase\Category;

use Core\Domain\Category\Repository\CategoryRepositoryInterface;
use Core\Domain\Category\Entity\CategoryEntity as Category;

use Core\UseCase\Category\DTO\{
    AddCategoryInputDto as InputDto,
    AddCategoryOutputDto as OutPutDto
};

use Core\Domain\Shared\ValueObject\Uuid;

use DateTime;

class AddCategoryUseCase
{
    public function __construct(
        protected CategoryRepositoryInterface $repository
    ) {}

    public function execute(InputDto $input) {

        $category = new Category(
            name: $input->name,
        );

        $this->repository->insert($category);

        return new OutputDto(
            id: $category->id
        );
    }
}