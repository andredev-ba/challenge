<?php

namespace Tests\Feature\UseCase\Product;

use App\Repositories\Eloquent\ProductEloquentRepository as Repository;
use App\Models\Product as Model;
use Core\UseCase\Product\DeleteProductUseCase;
use Core\UseCase\Product\DTO\{
    DeleteProductInputDto as InputDto,
    DeleteProductOutputDto as OutputDto
};
use Core\Domain\Shared\Exception\NotFoundException;
use DateTime;

beforeEach(function () {
    $this->repository = new Repository(new Model());
});

it('should execute delete product usecase', function()
{
    $product = Model::factory()->create();

    $usecase = new DeleteProductUseCase($this->repository);

    $output = $usecase->execute(new InputDto(
        id: $product->id
    ));
    
    expect($output)->toBeInstanceOf(OutputDto::class);

    $this->assertDatabaseMissing('products', [
        'id' => $product->id
    ]);
});