<?php

namespace Core\UseCase\Category;

use Core\Domain\Category\Repository\CategoryRepositoryInterface;
use Core\Domain\Category\Entity\CategoryEntity as Category;

use Core\UseCase\Category\DTO\{
    EditCategoryInputDto as InputDto,
    EditCategoryOutputDto as OutPutDto
};

use Core\Domain\Shared\ValueObject\Uuid;

use DateTime;

class EditCategoryUseCase
{
    public function __construct(
        protected CategoryRepositoryInterface $repository
    ) {}

    public function execute(InputDto $input) {

        $category = $this->repository->findById($input->id);
       
        $category->update (
            name: $input->name,
        );
   
        $this->repository->update($category);

        return new OutputDto(
            id: $category->id
        );
    }
}