<?php

namespace Core\UseCase\Category\DTO;

class EditCategoryInputDto
{
    public function __construct(
        public string $id,
        public string $name
    ) {}
}