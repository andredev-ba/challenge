<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Core\UseCase\Product\{
    ListProductUseCase,
    CreateProductUseCase,
    AddProductUseCase,
    FindProductUseCase,
    EditProductUseCase,
    DeleteProductUseCase
};

use Core\UseCase\Product\DTO\{
    ListProductInputDto,
    AddProductInputDto,
    FindProductInputDto,
    EditProductInputDto,
    DeleteProductInputDto
};

class ProductController extends Controller
{

    public function index(Request $request, ListProductUseCase $usecase)
    {
        ['search' => $search, 'sortBy' => $sortBy, 'descending' => $descending, 'rowsPerPage' => $rowsPerPage] = $request->all();
        $order = filter_var($descending, FILTER_VALIDATE_BOOLEAN) ? 'desc' : 'asc';
        $output = $usecase->execute(new ListProductInputDto(
            filters: compact('search', 'sortBy', 'order', 'rowsPerPage')
        ));

        return response()->json($output);
    }

    public function create(Request $request, CreateProductUseCase $usecase)
    {
        $output = $usecase->execute();
        return response()->json($output);
    }

    public function store(Request $request, AddProductUseCase $usecase)
    {
        $output = $usecase->execute(new AddProductInputDto(
            name: $request->name,
            description: $request->description,
            price: $request->price,
            expirationDate: $request->expirationDate,
            categoryId: $request->categoryId,
            imageFile: !empty($request->imageFile) ? [
                'tmp_name' => $request->imageFile->getPathname(),
                'name' => $request->imageFile->getFilename(),
                'type' => $request->imageFile->getMimeType(),
                'error' => $request->imageFile->getError()
            ] : null
        ));

        return response()->json($output)->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(FindProductUseCase $usecase, string $id)
    {
        $output = $usecase->execute(new FindProductInputDto(
            id: $id,
        ));

        return response()->json($output);
    }

    public function update(Request $request, EditProductUseCase $usecase, string $id)
    {
        $output = $usecase->execute(new EditProductInputDto(
            id: $id,
            name: $request->name,
            description: $request->description,
            price: $request->price,
            expirationDate: $request->expirationDate,
            categoryId: $request->categoryId,
            imageFile: !empty($request->imageFile) ? [
                'tmp_name' => $request->imageFile->getPathname(),
                'name' => $request->imageFile->getFilename(),
                'type' => $request->imageFile->getMimeType(),
                'error' => $request->imageFile->getError()
            ] : null
        ));
        return response()->json($output);
    }

    public function destroy(DeleteProductUseCase $usecase, string $id)
    {
        $output = $usecase->execute(new DeleteProductInputDto(
            id: $id
        ));
        return response()->json($output);
    }

}
