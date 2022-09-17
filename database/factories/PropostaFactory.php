<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Proposta;
use App\Models\Startup;

class PropostaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Proposta::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'titulo' => $this->faker->company,
            'descricao' =>  $this->faker->realText($maxNbChars = 2000),
            'video_caminho' => 'propostas/videos/'.$this->faker->file(storage_path('app/test/videos'), storage_path('app/public/propostas/videos/'), false),
            'thumbnail_caminho' => 'propostas/thumbnails/'.$this->faker->file(storage_path('app/test/imgs'), storage_path('app/public/propostas/thumbnails'), false),
        ];
    }

    /**
     * Cria uma proposta model passando uma startup
     *
     * @return Proposta $proposta
     */

    public function createProposta(Startup $startup)
    {
        $proposta = new Proposta();
        $proposta->titulo =  $this->faker->name();
        $proposta->descricao = $this->faker->realText($maxNbChars = 200);
        $proposta->startup_id = $startup->id;
        $proposta->video_caminho = 'propostas/'.$this->faker->file(storage_path('app/test'), storage_path('app/test/'), false);
        $proposta->thumbnail_caminho = 'propostas/'.$this->faker->image($dir = storage_path('app/test'), $width = 640, $height = 480, null, false);
        $proposta->save();


        return $proposta;
    }
}
