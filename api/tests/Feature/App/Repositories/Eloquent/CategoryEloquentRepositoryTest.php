<?php

namespace Tests\Feature\App\Repositories\Eloquent;

use App\Repositories\Eloquent\CategoryEloquentRepository as Repository;
use App\Models\Category as Model;
use Core\Domain\Category\Entity\CategoryEntity as Category;
use Faker\Factory as Faker;
use DateTime;
use Core\Domain\Shared\ValueObject\Uuid;

beforeEach(function () {
    $this->repository = new Repository(new Model());
});

it('should insert a category', function()
{
    $category = new Category(
        name: 'Categoria teste',
    );

    $this->repository->insert($category);

    $this->assertDatabaseHas('categories', [
        'id' => $category->id(),
        'name' => $category->name
    ]);
});

it('should update a category', function()
{
    $category = Model::factory()->create();
    
    $updatedCategory = new Category(
        id: new Uuid($category->id),
        name: 'Categoria atualizado'
    );

    $this->repository->update($updatedCategory);

    $this->assertDatabaseHas('categories', [
        'id' => $category->id,
        'name' => $updatedCategory->name,
    ]);
});
