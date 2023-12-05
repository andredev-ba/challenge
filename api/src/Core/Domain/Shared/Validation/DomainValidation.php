<?php

namespace Core\Domain\Shared\Validation;

use Core\Domain\Shared\Exception\EntityValidationException;
use DateTime;

class DomainValidation
{
    public static function notNull(string|object $value, string $exceptMessage = null)
    {
        if (empty($value))
            throw new EntityValidationException($exceptMessage ?? 'Should not be empty or null');
    }

    public static function strMaxLength(string $value, int $length = 255, string $exceptMessage = null)
    {
        if (strlen($value) >= $length)
            throw new EntityValidationException($exceptMessage ?? "The value must not be greater than {$length} characters");
    }

    public static function strMinLength(string $value, int $length = 3, string $exceptMessage = null)
    {
        if (strlen($value) < $length)
            throw new EntityValidationException($exceptMessage ?? "The value must be at least {$length} characters");
    }

    public static function positiveNumber(int|float $value, string $exceptMessage = null)
    {
        if ($value <= 0)
            throw new EntityValidationException($exceptMessage ?? "The value must not be less than zero");
    }

    public static function dateExpiration(DateTime $value, string $exceptMessage = null)
    {

        if ($value < new DateTime(date('Y-m-d')))
            throw new EntityValidationException($exceptMessage ?? "The date must not be less than today");
    }
}
