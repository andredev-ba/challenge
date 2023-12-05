<?php

namespace Core\UseCase\Category\DTO;

class AddCategoryInputDto
{
    public function __construct(
        public string $name
    ) {}
}