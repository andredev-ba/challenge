<?php

namespace Tests\Feature\Api;

use App\Models\Product as ProductModel;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;

beforeEach(function () {
    $this->endpoint = 'api/products';
});

it('should execute products/index endpoint with empty return', function()
{
    $response = $this->getJson("$this->endpoint?page=1&sortBy=name&descending=false&rowsPerPage=20&search=");
    expect($response)->assertStatus(Response::HTTP_OK);
});

it('should execute products/index endpoint', function()
{
    ProductModel::factory(10)->create();
    $response = $this->getJson("$this->endpoint?page=1&sortBy=name&descending=false&rowsPerPage=20&search=");
    expect($response)->assertStatus(Response::HTTP_OK);
    expect($response)->assertJsonStructure([
        'items',
        'total',
        'current_page',
        'last_page',
        'first_page',
        'per_page',
        'to',
        'from'
    ]);

    expect($response)->assertJsonCount(10, 'items');
});

it('should execute products/index endpoint with outher page', function()
{
    ProductModel::factory(15)->create();
    $response = $this->getJson("$this->endpoint?page=2&sortBy=name&descending=false&rowsPerPage=10&search=");
    expect($response)->assertStatus(Response::HTTP_OK);
    expect($response)->assertJsonStructure([
        'items',
        'total',
        'current_page',
        'last_page',
        'first_page',
        'per_page',
        'to',
        'from'
    ]);

    expect($response)->assertJsonCount(5, 'items');
});

it('should execute products/store endpoint', function()
{
    $fakeRequest = [
        'name' => 'Produto 01',
        'description' => 'Descrição teste',
        'price' => 50.30,
        'expirationDate' => date('Y-m-d'),
        'imageFile' => new UploadedFile(base_path('tests/Fixtures/test-image.jpg'), 'test-image.jpg', 'image/jpeg', null, true),
        'categoryId' => ''
    ];
    $response = $this->postJson($this->endpoint, $fakeRequest);
    expect($response)->assertStatus(Response::HTTP_CREATED);
});

it('should execute products/{id} endpoint', function()
{
    $product = ProductModel::factory()->create();
    $response = $this->getJson("$this->endpoint/$product->id");
    expect($response)->assertStatus(Response::HTTP_OK);
});

it('should return status code 404 when not found product in products/{id} endpoint', function()
{
    $response = $this->getJson("$this->endpoint/qualque-id");
    expect($response)->assertStatus(Response::HTTP_NOT_FOUND);
});

it('should execute products/update endpoint', function()
{
    $product = ProductModel::factory()->create();
    $fakeRequest = [
        'name' => 'Produto 03',
        'description' => 'Descrição atualizada',
        'price' => 100.30,
        'expirationDate' => date('Y-m-d'),
        'imageFile' => new UploadedFile(base_path('tests/Fixtures/test-image.jpg'), 'test-image.jpg', 'image/jpeg', null, true),
        'categoryId' => ''
    ];
    $response = $this->putJson("$this->endpoint/$product->id", $fakeRequest);
    expect($response)->assertStatus(Response::HTTP_OK);
});

it('should return status code 404 when not found product in products/update endpoint', function()
{
    $fakeRequest = [
        'name' => 'Produto 03',
        'description' => 'Descrição atualizada',
        'price' => 100.30,
        'expirationDate' => date('Y-m-d'),
        'imageFile' => new UploadedFile(base_path('tests/Fixtures/test-image.jpg'), 'test-image.jpg', 'image/jpeg', null, true),
        'categoryId' => ''
    ];
    $response = $this->putJson("$this->endpoint/qualquer-id", $fakeRequest);
    expect($response)->assertStatus(Response::HTTP_NOT_FOUND);
});

it('should execute products/delete endpoint', function()
{
    $product = ProductModel::factory()->create();
    $response = $this->deleteJson("$this->endpoint/$product->id");
    expect($response)->assertStatus(Response::HTTP_OK);
});

it('should return status code 404 when not found product in products/delete endpoint', function()
{
    $response = $this->deleteJson("$this->endpoint/qualquer-id");
    expect($response)->assertStatus(Response::HTTP_NOT_FOUND);
});