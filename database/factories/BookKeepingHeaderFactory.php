<?php

namespace Database\Factories;

use App\Models\BookKeepingHeader;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookKeepingHeaderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = BookKeepingHeader::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'scale_weight' => $this->faker->randomFloat($nbMaxDecimals = NULL, $min = 0, $max = 2.00),
            'calculation_weight' => $this->faker->randomFloat($nbMaxDecimals = NULL, $min = 0, $max = 2.00),
            'from_date' => $this->faker->dateTime($max = 'now', $timezone = null),
            'to_date' => $this->faker->dateTime($max = 'now', $timezone = null),
        ];
    }
}
