<?php

namespace Database\Factories;

use App\Models\Farm;
use App\Models\MaintenanceFee;
use Illuminate\Database\Eloquent\Factories\Factory;

class MaintenanceFeeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = MaintenanceFee::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "farm_id" => function () {
                return Farm::inRandomOrder()->first()->id;
            },
            "reason" => $this->faker->sentence(),
            "expense_amount" => $this->faker->numberBetween(100, 2300),
            "date_of_incident" => $this->faker->dateTimeThisMonth(),
        ];
    }
}
