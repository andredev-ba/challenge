<?php

namespace Core\UseCase\Category\DTO;

class FindCategoryInputDto
{
    public function __construct(
        public string $id
    ) {}
}