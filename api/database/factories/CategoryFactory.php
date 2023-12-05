<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;
use Core\Domain\Shared\ValueObject\Uuid;

class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {   
        return [
            'id' => Uuid::random(),
            'name' => $this->faker->name,
        ];
    }
}
