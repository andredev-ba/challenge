<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;
use DateTime;
use Core\Domain\Shared\ValueObject\Uuid;

class ProductFactory extends Factory
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
            'description' => $this->faker->text(200),
            'price' => $this->faker->randomFloat(2, 1),
            'expiration_date' => new DateTime(),
            'image_url' => $this->faker->imageUrl(300, 300)
        ];
    }
}
