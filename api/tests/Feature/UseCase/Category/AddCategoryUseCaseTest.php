<?php

namespace Tests\Feature\UseCase\Category;

use App\Repositories\Eloquent\CategoryEloquentRepository as Repository;
use App\Models\Category as Model;
use Core\UseCase\Category\AddCategoryUseCase;
use Core\UseCase\Category\DTO\{
    AddCategoryInputDto,
    AddCategoryOutputDto
};
use Faker\Factory as Faker;
use DateTime;

beforeEach(function () {
    $this->repository = new Repository(new Model());
});

it('should execute add category usecase', function()
{
    $category = Model::factory()->create();

    $faker = Faker::create();
    $fakeRequest = [
        'name' => $faker->name
    ];

    $usecase = new AddCategoryUseCase($this->repository);

    $output = $usecase->execute(new AddCategoryInputDto(
        name: $fakeRequest['name']
    ));

    expect($output)->toBeInstanceOf(AddCategoryOutputDto::class);

    $this->assertDatabaseHas('categories', [
        'id' => $output->id
    ]);
    
});