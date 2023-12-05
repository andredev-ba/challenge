<?php

namespace Tests\Unit\Domain\Category\Entity;

use Core\Domain\Category\Entity\CategoryEntity as Category;
use Core\Domain\Shared\ValueObject\Uuid;
use Core\Domain\Shared\Exception\EntityValidationException;
use DateTime;
use Faker\Factory as Faker;
use Carbon\Carbon;

it('should create a category', function()
{
    $faker = Faker::create();

    $category = new Category(
        name: $faker->name,
    );
    
    expect($category)->toBeInstanceOf(Category::class);

});

it('should update a category', function()
{
    $faker = Faker::create();

    $category = new Category(
        name: $faker->name,
    );
    
    $category->update(
        name: 'updated name',
    );

    expect($category)->toBeInstanceOf(Category::class);
    expect($category->name)->toBe('updated name');
});

it('should throw an error if the name has more than 100 characters', function()
{
    $faker = Faker::create();
    expect(function () use($faker) {
        new Category(
            name: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer maximus mi non sollicitudin viverra.',
        );
    })->toThrow(EntityValidationException::class, 'The category name must not be greater than 100 characters');
});
