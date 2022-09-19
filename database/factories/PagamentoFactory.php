<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class PagamentoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $data = $this->faker->dateTimeBetween('-5 years');
        return [
            'valor' => $this->faker->randomFloat(2, 1, 100),
            'status_transacao' => 6,
            'hash_pagamento' => Hash::make($this->faker->randomDigit),
            'codigo' => $this->faker->randomNumber,
            'created_at' => $data,
            'updated_at' => $data,
        ];
    }
}
