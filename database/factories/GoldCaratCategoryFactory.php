<?php

namespace Database\Factories;

use App\Models\GoldCaratCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class GoldCaratCategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = GoldCaratCategory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'carat' => $this->faker->numberBetween($min = 1, $max = 50),
            'price' => $this->faker->numberBetween($min = 100000, $max = 900000),
            'fee' => $this->faker->numberBetween($min = 1000, $max = 9000)
        ];
    }
}
