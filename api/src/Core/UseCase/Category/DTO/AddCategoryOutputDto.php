<?php

namespace Core\UseCase\Category\DTO;

class AddCategoryOutputDto
{
    public function __construct(
        public string $id
    ) {}
}