<?php

namespace Core\Domain\Category\Presenter;

interface CategoryPresenterInterface
{
    public function items(): array;
    public function toQuasarFormSelect(): array;
}