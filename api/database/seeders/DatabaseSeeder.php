<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Core\Domain\Shared\ValueObject\Uuid;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\Product::query()->delete();
        \App\Models\Category::query()->delete();
        \App\Models\Category::factory()->create([
            'id' => Uuid::random(),
            'name' => 'Padrão'
        ]);
    }
}
