<?php

namespace Tests\Feature\UseCase\Product;

use App\Repositories\Eloquent\ProductEloquentRepository as Repository;
use App\Models\Product as Model;
use Core\UseCase\Product\ListProductUseCase;
use Core\UseCase\Product\DTO\ListProductInputDto as InputDto;
use Core\UseCase\Shared\DTO\PaginationOutputDto as OutputDto;
use DateTime;

beforeEach(function () {
    $this->repository = new Repository(new Model());
});

it('should execute list product usecase', function()
{
    Model::factory(10)->create();

    $usecase = new ListProductUseCase($this->repository);

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