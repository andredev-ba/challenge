<?php

namespace Tests\Feature\UseCase\Category;

use App\Repositories\Eloquent\CategoryEloquentRepository as Repository;
use App\Models\Category as CategoryModel;
use Core\UseCase\Category\EditCategoryUseCase;
use Core\UseCase\Category\DTO\{
    EditCategoryInputDto,
    EditCategoryOutputDto
};
use Faker\Factory as Faker;
use DateTime;

beforeEach(function () {
    $this->repository = new Repository(new CategoryModel());
});

it('should execute update category usecase', function()
{
    $category = CategoryModel::factory()->create();

    $faker = Faker::create();
    $fakeRequest = [
        'id' => $category->id,
        'name' => $faker->name
    ];

    $usecase = new EditCategoryUseCase($this->repository);

    $output = $usecase->execute(new EditCategoryInputDto(
        id: $fakeRequest['id'],
        name: $fakeRequest['name']
    ));

    expect($output)->toBeInstanceOf(EditCategoryOutputDto::class);

    $this->assertDatabaseHas('categories', [
        'id' => $output->id,
        'name' => $fakeRequest['name']
    ]);
    
});