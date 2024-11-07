<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeFactory extends Factory
{
    public function definition(): array
    {
        return [
            'first_name' => $this->faker->firstName(),
            'second_name' => $this->faker->lastName(),
            'email' => $this->faker->email(),
            'phone' => $this->faker->e164PhoneNumber(),
            'company_id' => Company::all()->random()->id,
        ];
    }
}
