<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Core\UseCase\Category\{
    ListCategoryUseCase,
    AddCategoryUseCase,
    FindCategoryUseCase,
    EditCategoryUseCase,
    DeleteCategoryUseCase
};

use Core\UseCase\Category\DTO\{
    ListCategoryInputDto,
    AddCategoryInputDto,
    FindCategoryInputDto,
    EditCategoryInputDto,
    DeleteCategoryInputDto
};

class CategoryController extends Controller
{

    public function index(Request $request, ListCategoryUseCase $usecase)
    {
        ['search' => $search, 'sortBy' => $sortBy, 'descending' => $descending, 'rowsPerPage' => $rowsPerPage] = $request->all();
        $order = filter_var($descending, FILTER_VALIDATE_BOOLEAN) ? 'desc' : 'asc';
        $output = $usecase->execute(new ListCategoryInputDto(
            filters: compact('search', 'sortBy', 'order', 'rowsPerPage')
        ));

        return response()->json($output);
    }

    public function store(Request $request, AddCategoryUseCase $usecase)
    {
        $output = $usecase->execute(new AddCategoryInputDto(
            name: $request->name,
        ));

        return response()->json($output)->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(FindCategoryUseCase $usecase, string $id)
    {
        $output = $usecase->execute(new FindCategoryInputDto(
            id: $id,
        ));

        return response()->json($output);
    }


    public function update(Request $request, EditCategoryUseCase $usecase, string $id)
    {
        $output = $usecase->execute(new EditCategoryInputDto(
            id: $id,
            name: $request->name,
        ));
        return response()->json($output);
    }

    public function destroy(DeleteCategoryUseCase $usecase, string $id)
    {
        $output = $usecase->execute(new DeleteCategoryInputDto(
            id: $id
        ));
        return response()->json($output);
    }

}
