<?php

namespace Tests\Feature\UseCase\Category;

use App\Repositories\Eloquent\CategoryEloquentRepository as Repository;
use App\Models\Category as Model;
use Core\UseCase\Category\FindCategoryUseCase;
use Core\UseCase\Category\DTO\{
    FindCategoryInputDto as InputDto,
    FindCategoryOutputDto as OutputDto
};
use Core\Domain\Shared\Exception\NotFoundException;
use DateTime;

beforeEach(function () {
    $this->repository = new Repository(new Model());
});

it('should execute find category usecase', function()
{
    $category = Model::factory()->create();

    $usecase = new FindCategoryUseCase($this->repository);

    $output = $usecase->execute(new InputDto(
        id: $category->id
    ));
    
    expect($output)->toBeInstanceOf(OutputDto::class);
});

it('should throw an error if the category not found', function()
{
    expect(function () {
        $category = Model::factory(10)->create();

        $usecase = new FindCategoryUseCase($this->repository);

        $usecase->execute(new InputDto(
            id: 'qualquer-id'
        ));
    })->toThrow(NotFoundException::class);

});