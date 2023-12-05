<?php

namespace Core\UseCase\Shared\Interfaces;

interface TransactionInterface
{
    public function commit();
    public function rollback();
}
