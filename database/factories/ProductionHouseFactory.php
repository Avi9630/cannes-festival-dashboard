<?php

namespace Database\Factories;

use App\Models\ProductionHouse;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductionHouseFactory extends Factory
{
    protected $model = ProductionHouse::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
        ];
    }
}
