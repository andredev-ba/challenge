<?php

namespace Tests\Feature\UseCase\Category;

use App\Repositories\Eloquent\CategoryEloquentRepository as Repository;
use App\Models\Category as Model;
use Core\UseCase\Category\DeleteCategoryUseCase;
use Core\UseCase\Category\DTO\{
    DeleteCategoryInputDto as InputDto,
    DeleteCategoryOutputDto as OutputDto
};
use Core\Domain\Shared\Exception\NotFoundException;
use DateTime;

beforeEach(function () {
    $this->repository = new Repository(new Model());
});

it('should execute delete category usecase', function()
{
    $category = Model::factory()->create();

    $usecase = new DeleteCategoryUseCase($this->repository);

    $output = $usecase->execute(new InputDto(
        id: $category->id
    ));
    
    expect($output)->toBeInstanceOf(OutputDto::class);

    $this->assertDatabaseMissing('categories', [
        'id' => $category->id
    ]);
});