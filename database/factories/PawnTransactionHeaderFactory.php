<?php

namespace Database\Factories;

use App\Models\PawnTransactionHeader;
use Illuminate\Database\Eloquent\Factories\Factory;

class PawnTransactionHeaderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PawnTransactionHeader::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'deadline_date' => $this->faker->dateTime($max = 'now', $timezone = null),
            'interest_total' => $this->faker->randomDigit()
        ];
    }
}
