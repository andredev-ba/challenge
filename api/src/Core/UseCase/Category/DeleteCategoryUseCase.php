<?php

namespace Core\UseCase\Category;

use Core\Domain\Category\Repository\CategoryRepositoryInterface;

use Core\UseCase\Category\DTO\{
    DeleteCategoryInputDto as InputDto,
    DeleteCategoryOutputDto as OutPutDto
};

use DateTime;

class DeleteCategoryUseCase
{
    public function __construct(
        protected CategoryRepositoryInterface $repository
    ) {}

    public function execute(InputDto $input) {
        $deleted = $this->repository->delete($input->id);

        return new OutputDto(
            deleted: $deleted
        );
    }
}