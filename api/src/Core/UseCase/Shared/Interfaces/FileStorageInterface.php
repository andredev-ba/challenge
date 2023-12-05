<?php

namespace Core\UseCase\Shared\Interfaces;

interface FileStorageInterface
{
    public function store(string $path, array $file): string;
    public function delete(string $path): bool;
}
