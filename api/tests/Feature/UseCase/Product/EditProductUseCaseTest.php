<?php

namespace Tests\Feature\UseCase\Product;

use App\Repositories\Eloquent\ProductEloquentRepository as Repository;
use Core\UseCase\Shared\Interfaces\FileStorageInterface;
use App\Models\Product as ProductModel;
use Core\UseCase\Product\EditProductUseCase;
use Core\UseCase\Product\DTO\{
    EditProductInputDto,
    EditProductOutputDto
};
use Faker\Factory as Faker;
use Illuminate\Http\UploadedFile;

use Mockery;

beforeEach(function () {
    $this->repository = new Repository(new ProductModel());
    
});



it('should execute update product usecase', function()
{
    $product = ProductModel::factory()->create();

    $faker = Faker::create();
    $fakeRequest = [
        'id' => $product->id,
        'name' => $faker->name,
        'description' => $faker->text(200),
        'price' => $faker->randomFloat(2, 1),
        'expirationDate' =>  date('Y-m-d'),
        'imageFile' => new UploadedFile(base_path('tests/Fixtures/test-image.jpg'), 'test-image.jpg', 'image/jpeg', null, true)
    ];

    $fileStorageMock = Mockery::mock(FileStorageInterface::class);  
    $fileStorageMock->shouldReceive('store')->andReturn($faker->imageUrl(50, 50));

    $usecase = new EditProductUseCase($this->repository, $fileStorageMock);

    $output = $usecase->execute(new EditProductInputDto(
        id: $fakeRequest['id'],
        name: $fakeRequest['name'],
        description: $fakeRequest['description'],
        price: $fakeRequest['price'],
        expirationDate: $fakeRequest['expirationDate'],
        imageFile: [
            'tmp_name' => $fakeRequest['imageFile']->getPathname(),
            'name' => $fakeRequest['imageFile']->getFilename(),
            'type' => $fakeRequest['imageFile']->getMimeType(),
            'error' => $fakeRequest['imageFile']->getError()
        ]
    ));

    expect($output)->toBeInstanceOf(EditProductOutputDto::class);

    $this->assertDatabaseHas('products', [
        'id' => $output->id,
        'name' => $fakeRequest['name']
    ]);
    
});