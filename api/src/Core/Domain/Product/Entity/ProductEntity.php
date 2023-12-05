<?php

namespace Core\Domain\Product\Entity;

use Core\Domain\Shared\Validation\DomainValidation;
use Core\Domain\Shared\Traits\MethodsMagicsTrait;
use Core\Domain\Shared\ValueObject\Uuid;
use DateTime;

class ProductEntity
{
    use MethodsMagicsTrait;

    public function __construct(
        protected ?Uuid $id = null,
        protected ?string $name = '',
        protected ?string $description = '',
        protected ?float $price = 0,
        protected ?DateTime $expirationDate = null,
        protected ?string $imageUrl = '',
        protected ?Uuid $categoryId = null
    ) {
        $this->id = $this->id ?? Uuid::random();

        $this->validate();
    }

    public function update(
        ?string $name = '',
        ?string $description = '',
        ?float $price = 0,
        ?DateTime $expirationDate = null,
        ?string $imageUrl = '',
        ?Uuid $categoryId = null
    ) {
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->expirationDate = $expirationDate;
        $this->imageUrl = $imageUrl;
        $this->categoryId = $categoryId;

        $this->validate();
    }

    protected function validate()
    {
        DomainValidation::notNull($this->name, 'The product name must not be empty or null');
        DomainValidation::strMaxLength($this->name, 50, 'The product name must not be greater than 50 characters');
        DomainValidation::positiveNumber($this->price, 'The product price must not be null, less than or equals 0');
        DomainValidation::dateExpiration($this->expirationDate, 'The product expiration date must not be less than today');

        if($this->description) DomainValidation::strMaxLength($this->description, 200, 'The product description must not be greater than 200 characters');
    }
}
