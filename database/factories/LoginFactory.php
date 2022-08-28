<?php

namespace Database\Factories;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class LoginFactory extends Factory {

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $randomDateTime = $this->faker->dateTimeBetween('-6 hours', 'now');

        return [
            'tenant_id' => Tenant::factory(),
            'user_id' => User::factory(),
            'created_at' => $randomDateTime,
            'updated_at' => $randomDateTime,

        ];
    }
}
