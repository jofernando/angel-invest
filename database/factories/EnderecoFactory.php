<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Endereco;
use App\Models\Startup;

class EnderecoFactory extends Factory
{

     /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Endereco::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [

        ];
    }

    public function createEndereco(Startup $startup)
    {
        $ceps = array("75045-080", "93226-052", "88037-310", "87309-708","68555-410");
        $ruas = array("A", "B", "C", "D","E");
        $bairros = array("Cohab 1", "Cohab 2", "Cohab 3", "Cohab 4","Cohab 5");
        $cidades = array("Recife", "Caruaru", "Garanhuns", "Gravatá","Petrolina");
        $numeros = array("1A", "123", "56", "78","23");
        $estados = array("Pernambuco", "Paraíba", "São Paulo", "Rio de Janeiro","Bahia");
        $complementos = array("Apartamento", "Bloco F", "Casa", "Bloco A");

        $endereco = new Endereco();
        $endereco->cep = $ceps[array_rand($ceps)];
        $endereco->rua = $ruas[array_rand($ruas)];
        $endereco->bairro = $bairros[array_rand($bairros)];
        $endereco->numero = $numeros[array_rand($numeros)];
        $endereco->estado = $estados[array_rand($estados)];
        $endereco->cidade = $cidades[array_rand($cidades)];
        $endereco->complemento = $complementos[array_rand($complementos)];
        $endereco->startup_id = $startup->id;
        $endereco->save();

        return $endereco;
    }
}
