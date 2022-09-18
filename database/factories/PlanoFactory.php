<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PlanoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'titulo' => $this->faker->realText(50),
            'descricao' => $this->faker->realText(500),
            'dias' => 30,
            'valor' => $this->faker->randomFloat(2, 50, 500),
        ];
    }
}
