<?php

namespace Database\Seeders;

use App\Models\ProductionHouse;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductionHouseSeeder extends Seeder
{
    public function run(): void
    {
        ProductionHouse::factory()->count(10)->create();
    }
}
