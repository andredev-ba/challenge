<?php

namespace Core\UseCase\Product\DTO;

class EditProductOutputDto
{
    public function __construct(
        public string $id
    ) {}
}