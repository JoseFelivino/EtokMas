<?php

namespace Database\Factories;

use App\Models\Gold;
use Illuminate\Database\Eloquent\Factories\Factory;

class GoldFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Gold::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'weight' => $this->faker->randomFloat($nbMaxDecimals = NULL, $min = 0, $max = 2.00),
            'img_path' => $this->faker->name()
        ];
    }
}
