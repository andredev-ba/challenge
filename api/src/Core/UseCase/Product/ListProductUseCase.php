<?php

namespace Core\UseCase\Product;

use Core\Domain\Product\Repository\ProductRepositoryInterface;
use Core\UseCase\Product\DTO\ListProductInputDto as InputDto;
use Core\UseCase\Shared\DTO\PaginationOutputDto as OutputDto;

class ListProductUseCase
{
    public function __construct(
        protected ProductRepositoryInterface $repository
    ) {}

    public function execute(InputDto $input)
    {

        $productPaginate = $this->repository->paginate($input->filters);

        foreach ($productPaginate->items() as $item) {
            $item->expiration_date = !empty($item->expiration_date) ? date('d/m/Y', strtotime($item->expiration_date)) : '';
            $item->price = number_format($item->price, 2, ',', '.');
        }

        return new OutputDto(
            items: $productPaginate->items(),
            total: $productPaginate->total(),
            current_page: $productPaginate->currentPage(),
            last_page: $productPaginate->lastPage(),
            first_page: $productPaginate->firstPage(),
            per_page: $productPaginate->perPage(),
            to: $productPaginate->to(),
            from: $productPaginate->from()
        );
    }
}
