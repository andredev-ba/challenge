<?php

namespace Tests\Feature\App\Repositories\Eloquent;

use App\Repositories\Eloquent\ProductEloquentRepository as Repository;
use App\Models\Product as Model;
use Core\Domain\Product\Entity\ProductEntity as Product;
use Faker\Factory as Faker;
use DateTime;
use Core\Domain\Shared\ValueObject\Uuid;

beforeEach(function () {
    $this->repository = new Repository(new Model());
});

it('should insert a product', function()
{
    $product = new Product(
        name: 'Produto teste',
        description: 'Esse é um produto de teste',
        price: 50.25,
        expirationDate: new DateTime(),
        imageUrl: 'caminho/image.jpg',
        categoryId: null
    );

    $this->repository->insert($product);

    $this->assertDatabaseHas('products', [
        'id' => $product->id(),
        'name' => $product->name,
        'description' => $product->description,
        'price' => $product->price,
        'expiration_date' => $product->expirationDate->format('Y-m-d'),
        'image_url' => $product->imageUrl
    ]);
});

it('should update a product', function()
{
    $product = Model::factory()->create();
    
    $updatedProduct = new Product(
        id: new Uuid($product->id),
        name: 'Produto atualizado',
        description: 'Esse é um produto de teste atualizado',
        price: 22222.15,
        expirationDate: new DateTime(),
        imageUrl: 'caminho-novo/image.jpg',
        categoryId: null
    );

    $this->repository->update($updatedProduct);

    $this->assertDatabaseHas('products', [
        'id' => $product->id,
        'name' => $updatedProduct->name,
        'description' => $updatedProduct->description,
        'price' => $updatedProduct->price,
        'expiration_date' => $updatedProduct->expirationDate->format('Y-m-d'),
        'image_url' => $updatedProduct->imageUrl
    ]);
});
