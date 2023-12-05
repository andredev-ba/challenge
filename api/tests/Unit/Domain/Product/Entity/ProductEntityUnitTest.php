<?php

namespace Tests\Unit\Domain\Product\Entity;

use Core\Domain\Product\Entity\ProductEntity as Product;
use Core\Domain\Shared\ValueObject\Uuid;
use Core\Domain\Shared\Exception\EntityValidationException;
use DateTime;
use Faker\Factory as Faker;
use Carbon\Carbon;

it('should create a product', function()
{
    $faker = Faker::create();

    $product = new Product(
        name: $faker->name,
        description: $faker->text(200),
        price: $faker->randomFloat(2, 1),
        expirationDate: new DateTime(),
        imageUrl: $faker->imageUrl(300, 300),
        categoryId: Uuid::random()
    );

    expect($product)->toBeInstanceOf(Product::class);

});

it('should update a product', function()
{
    $faker = Faker::create();

    $product = new Product(
        name: $faker->name,
        description: $faker->text(200),
        price: $faker->randomFloat(2, 1),
        expirationDate: new DateTime(),
        imageUrl: $faker->imageUrl(300, 300),
        categoryId: Uuid::random()
    );

    $newExpirationDate = new DateTime(Carbon::now()->addDay()->toDateString());
    $newCategory = Uuid::random();
    
    $product->update(
        name: 'updated name',
        description: 'updated description',
        price: 90.25,
        expirationDate: $newExpirationDate,
        imageUrl: 'updated/img.jpg',
        categoryId: $newCategory
    );

    expect($product)->toBeInstanceOf(Product::class);
    expect($product->name)->toBe('updated name');
    expect($product->description)->toBe('updated description');
    expect($product->price)->toBe(90.25);
    expect($product->expirationDate)->toBe($newExpirationDate);
    expect($product->imageUrl)->toBe('updated/img.jpg');
    expect($product->categoryId)->toBe($newCategory);
});


it('should throw an error if the name has empty or null', function()
{
    $faker = Faker::create();
    expect(function () use($faker) {
        new Product(
            name: '',
            description: $faker->text(200),
            price: $faker->randomFloat(2, 1),
            expirationDate: new DateTime(),
            imageUrl: $faker->imageUrl(300, 300),
            categoryId: Uuid::random()
        );
    })->toThrow(EntityValidationException::class, 'The product name must not be empty or null');

    expect(function () use($faker) {
        new Product(
            description: $faker->text(200),
            price: $faker->randomFloat(2, 1),
            expirationDate: new DateTime(),
            imageUrl: $faker->imageUrl(300, 300),
            categoryId: Uuid::random()
        );
    })->toThrow(EntityValidationException::class, 'The product name must not be empty or null');

});

it('should throw an error if the name has more than 50 characters', function()
{
    $faker = Faker::create();
    expect(function () use($faker) {
        new Product(
            name: 'Lorem ipsum dolor sit amet, consectetur erat curae.',
            description: $faker->text(200),
            price: $faker->randomFloat(2, 1),
            expirationDate: new DateTime(),
            imageUrl: $faker->imageUrl(300, 300),
            categoryId: Uuid::random()
        );
    })->toThrow(EntityValidationException::class, 'The product name must not be greater than 50 characters');
});

it('should throw an error if the description has more than 200 characters', function()
{
    $faker = Faker::create();
    expect(function () use($faker) {
        new Product(
            name: $faker->name,
            description: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed sapien ligula, pulvinar quis erat in, egestas laoreet nulla. Sed ut facilisis urna, id malesuada mi. Maecenas lobortis, libero consequat id.',
            price: $faker->randomFloat(2, 1),
            expirationDate: new DateTime(),
            imageUrl: $faker->imageUrl(300, 300),
            categoryId: Uuid::random()
        );
    })->toThrow(EntityValidationException::class, 'The product description must not be greater than 200 characters');
});

it('should throw an error if the price has less and equals 0 or null', function()
{
    $faker = Faker::create();
    expect(function () use($faker) {
        new Product(
            name: $faker->name,
            description: $faker->text(200),
            expirationDate: new DateTime(),
            imageUrl: $faker->imageUrl(300, 300),
            categoryId: Uuid::random()
        );
    })->toThrow(EntityValidationException::class, 'The product price must not be null, less than or equals 0');

    expect(function () use($faker) {
        new Product(
            name: $faker->name,
            description: $faker->text(200),
            price: 0,
            expirationDate: new DateTime(),
            imageUrl: $faker->imageUrl(300, 300),
            categoryId: Uuid::random()
        );
    })->toThrow(EntityValidationException::class, 'The product price must not be null, less than or equals 0');

    expect(function () use($faker) {
        new Product(
            name: $faker->name,
            description: $faker->text(200),
            price: -1,
            expirationDate: new DateTime(),
            imageUrl: $faker->imageUrl(300, 300),
            categoryId: Uuid::random()
        );
    })->toThrow(EntityValidationException::class, 'The product price must not be null, less than or equals 0');

});

it('should throw an error if the expiration date has less than today', function()
{
    $faker = Faker::create();
    
    expect(function () use($faker) {
        $dateExpired = new DateTime(Carbon::now()->subDay()->toDateString());

        new Product(
            name: $faker->name,
            description: $faker->text(200),
            price: $faker->randomFloat(2, 1),
            expirationDate: $dateExpired,
            imageUrl: $faker->imageUrl(300, 300),
            categoryId: Uuid::random()
        );
    })->toThrow(EntityValidationException::class, 'The product expiration date must not be less than today');
});