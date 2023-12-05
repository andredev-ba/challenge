<?php

namespace Core\UseCase\Product\DTO;

class DeleteProductOutputDto
{
    public function __construct(
        public bool $deleted
    ) {}
}