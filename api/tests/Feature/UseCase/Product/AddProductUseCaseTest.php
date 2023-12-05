<?php

namespace Tests\Feature\UseCase\Product;

use App\Repositories\Eloquent\ProductEloquentRepository as Repository;
use Core\UseCase\Shared\Interfaces\FileStorageInterface;
use App\Models\Category as CategoryModel;
use App\Models\Product as Model;
use Core\UseCase\Product\AddProductUseCase;
use Core\UseCase\Product\DTO\{
    AddProductInputDto,
    AddProductOutputDto
};
use Faker\Factory as Faker;
use DateTime;
use Illuminate\Http\UploadedFile;

use Mockery;

beforeEach(function () {
    $this->repository = new Repository(new Model());
});

it('should execute add product usecase', function()
{
    $category = CategoryModel::factory()->create();

    $faker = Faker::create();

    $fakeRequest = [
        'name' => $faker->name,
        'description' => $faker->text(200),
        'price' => $faker->randomFloat(2, 1),
        'expirationDate' =>  date('Y-m-d'),
        'imageFile' => new UploadedFile(base_path('tests/Fixtures/test-image.jpg'), 'test-image.jpg', 'image/jpeg', null, true),
        'categoryId' => $category->id
    ];

    $fileStorageMock = Mockery::mock(FileStorageInterface::class);  
    $fileStorageMock->shouldReceive('store')->andReturn($faker->imageUrl(50, 50));

    $usecase = new AddProductUseCase($this->repository, $fileStorageMock);

    $output = $usecase->execute(new AddProductInputDto(
        name: $fakeRequest['name'],
        description: $fakeRequest['description'],
        price: $fakeRequest['price'],
        expirationDate: $fakeRequest['expirationDate'],
        imageFile: [
            'tmp_name' => $fakeRequest['imageFile']->getPathname(),
            'name' => $fakeRequest['imageFile']->getFilename(),
            'type' => $fakeRequest['imageFile']->getMimeType(),
            'error' => $fakeRequest['imageFile']->getError()
        ],
        categoryId: $fakeRequest['categoryId']
    ));

    expect($output)->toBeInstanceOf(AddProductOutputDto::class);

    $this->assertDatabaseHas('products', [
        'id' => $output->id
    ]);
    
});