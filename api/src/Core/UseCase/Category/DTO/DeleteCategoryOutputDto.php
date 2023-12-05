<?php

namespace Core\UseCase\Category\DTO;

class DeleteCategoryOutputDto
{
    public function __construct(
        public bool $deleted
    ) {}
}