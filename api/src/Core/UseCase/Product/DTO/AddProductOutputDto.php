<?php

namespace Core\UseCase\Product\DTO;

class AddProductOutputDto
{
    public function __construct(
        public string $id
    ) {}
}