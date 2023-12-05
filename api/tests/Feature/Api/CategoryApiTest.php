<?php

namespace Tests\Feature\Api;

use App\Models\Category as CategoryModel;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;

beforeEach(function () {
    $this->endpoint = 'api/categories';
});

it('should execute categories/index endpoint with empty return', function()
{
    $response = $this->getJson("$this->endpoint?page=1&sortBy=name&descending=false&rowsPerPage=20&search=");
    expect($response)->assertStatus(Response::HTTP_OK);
});

it('should execute categories/index endpoint', function()
{
    CategoryModel::factory(10)->create();
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

it('should execute categories/index endpoint with outher page', function()
{
    CategoryModel::factory(15)->create();
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

it('should execute categories/store endpoint', function()
{
    $fakeRequest = [
        'name' => 'Categoria 01',
    ];
    $response = $this->postJson($this->endpoint, $fakeRequest);
    expect($response)->assertStatus(Response::HTTP_CREATED);
});

it('should execute categories/{id} endpoint', function()
{
    $category = CategoryModel::factory()->create();
    $response = $this->getJson("$this->endpoint/$category->id");
    expect($response)->assertStatus(Response::HTTP_OK);
});

it('should return status code 404 when not found category in categories/{id} endpoint', function()
{
    $response = $this->getJson("$this->endpoint/qualque-id");
    expect($response)->assertStatus(Response::HTTP_NOT_FOUND);
});

it('should execute categories/update endpoint', function()
{
    $category = CategoryModel::factory()->create();
    $fakeRequest = [
        'name' => 'Categoria 03',
    ];
    $response = $this->putJson("$this->endpoint/$category->id", $fakeRequest);
    expect($response)->assertStatus(Response::HTTP_OK);
});

it('should return status code 404 when not found category in categories/update endpoint', function()
{
    $fakeRequest = [
        'name' => 'Categoria 03',
    ];
    $response = $this->putJson("$this->endpoint/qualquer-id", $fakeRequest);
    expect($response)->assertStatus(Response::HTTP_NOT_FOUND);
});

it('should execute categories/delete endpoint', function()
{
    $category = CategoryModel::factory()->create();
    $response = $this->deleteJson("$this->endpoint/$category->id");
    expect($response)->assertStatus(Response::HTTP_OK);
});

it('should return status code 404 when not found category in categories/delete endpoint', function()
{
    $response = $this->deleteJson("$this->endpoint/qualquer-id");
    expect($response)->assertStatus(Response::HTTP_NOT_FOUND);
});