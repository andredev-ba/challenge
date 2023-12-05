<?php

namespace Core\UseCase\Product\DTO;

class DeleteProductInputDto
{
    public function __construct(
        public string $id
    ) {}
}