<?php

namespace Database\Factories;

use App\Models\Telefone;
use App\Models\Startup;
use Illuminate\Database\Eloquent\Factories\Factory;

class TelefoneFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'numero' => $this->faker->phoneNumber,
        ];
    }
     /**
     * Criar telefone de uma startup.
     * @param Startup $startup : Startup para cadastro do telefone
     * @return Telefone $telefone: retorna um telefone
     */
    public function createTelefone(Startup $startup)
    {
        $telefone = new Telefone();
        $telefone->numero =  $this->faker->phoneNumber();
        $telefone->startup_id = $startup->id;
        $telefone->save();
        return $telefone;
    }
}
