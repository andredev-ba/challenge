<?php

namespace Core\Domain\Shared\Traits;

use Exception;

trait MethodsMagicsTrait
{
    public function __get($property)
    {
        if (property_exists($this, $property)) {
            return $this->{$property};
        }
        $className = get_class($this);
        throw new Exception("The property {$property} not found in {$className} class");
    }

    public function id(): string
    {
        return (string) $this->id;
    }

    public function createdAt(): string
    {
        return $this->createdAt->format('Y-m-d H:i:s');
    }
}
