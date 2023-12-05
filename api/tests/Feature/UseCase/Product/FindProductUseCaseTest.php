<?php

namespace Tests\Feature\UseCase\Product;

use App\Repositories\Eloquent\ProductEloquentRepository as Repository;
use App\Models\Product as Model;
use App\Repositories\Eloquent\CategoryEloquentRepository as CategoryRepository;
use App\Models\Category as CategoryModel;
use Core\UseCase\Product\FindProductUseCase;
use Core\UseCase\Product\DTO\{
    FindProductInputDto as InputDto,
    FindProductOutputDto as OutputDto
};
use Core\Domain\Shared\Exception\NotFoundException;
use DateTime;

beforeEach(function () {
    $this->repository = new Repository(new Model());
    $this->categoryRepository = new CategoryRepository(new CategoryModel());
});

it('should execute find product usecase', function()
{
    $product = Model::factory()->create();

    $usecase = new FindProductUseCase($this->repository, $this->categoryRepository);

    $output = $usecase->execute(new InputDto(
        id: $product->id
    ));
    
    expect($output)->toBeInstanceOf(OutputDto::class);
});

it('should throw an error if the product not found', function()
{
    expect(function () {
        $product = Model::factory(10)->create();

        $usecase = new FindProductUseCase($this->repository, $this->categoryRepository);

        $usecase->execute(new InputDto(
            id: 'qualquer-id'
        ));
    })->toThrow(NotFoundException::class);

});