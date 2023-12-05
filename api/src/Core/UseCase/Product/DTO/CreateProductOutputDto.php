<?php

namespace Core\UseCase\Product\DTO;

class CreateProductOutputDto
{
    public function __construct(
        public array $options
    ) {}
}
