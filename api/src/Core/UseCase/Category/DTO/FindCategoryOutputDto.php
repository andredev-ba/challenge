<?php

namespace Core\UseCase\Category\DTO;

class FindCategoryOutputDto
{
    public function __construct(
        public string $id,
        public string $name
    ) {}
}