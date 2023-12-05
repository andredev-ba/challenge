<?php

namespace Tests\Feature\UseCase\Category;

use App\Repositories\Eloquent\CategoryEloquentRepository as Repository;
use App\Models\Category as Model;
use Core\UseCase\Category\ListCategoryUseCase;
use Core\UseCase\Category\DTO\ListCategoryInputDto as InputDto;
use Core\UseCase\Shared\DTO\PaginationOutputDto as OutputDto;
use DateTime;

beforeEach(function () {
    $this->repository = new Repository(new Model());
});

it('should execute list category usecase', function()
{
    Model::factory(10)->create();

    $usecase = new ListCategoryUseCase($this->repository);

    $output = $usecase->execute(new InputDto(
        filters: [
            'search' => '',
            'sortBy' => 'name',
            'order' => 'asc',
            'rowsPerPage' => 20
        ]
    ));

    expect($output)->toBeInstanceOf(OutputDto::class);
    
});