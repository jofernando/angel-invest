<?php

namespace Database\Factories;

use App\Models\Documento;
use App\Models\Startup;
use Illuminate\Database\Eloquent\Factories\Factory;

class DocumentoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nome' => $this->faker->word,
            'caminho' => 'documentos/startups/'.$this->faker->file(storage_path('app/test/pdfs'), storage_path('app/public/documentos/startups'), false),
        ];
    }
    /**
     * Criar documento de uma startup.
     * @param Startup $startup : Startup para cadastro do documento
     * @return Documento $documento: retorna um documento
     */
    public function createDocumento(Startup $startup)
    {
        $documento = new Documento();
        $documento->nome =  $this->faker->name();
        $documento->caminho = 'startups/1/documentos/'.$this->faker->file(storage_path('app/test'), storage_path('app/test/'), false);
        $documento->startup_id = $startup->id;
        $documento->save();
        return $documento;
    }
}
