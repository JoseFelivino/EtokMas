<?php

namespace Database\Factories;

use App\Models\PawnTransactionStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

class PawnTransactionStatusFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PawnTransactionStatus::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'status' => $this->faker->name()
        ];
    }
}
