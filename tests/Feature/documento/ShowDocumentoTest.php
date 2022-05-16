<?php

namespace Tests\Feature\documento;

use App\Models\Area;
use App\Models\Documento;
use App\Models\Startup;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ShowDocumentoTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    /*public function test_visualizar_documento_existente()
    {
        $startup = $this->criar_startup();
        $documento = $this->criar_documento($startup);
        $response = $this->get(route('documento.arquivo',$documento->id));
        //$response->assertStatus(200);
    }*/

    public function test_visualizar_documento_inexistente()
    {
        $startup = $this->criar_startup();
        $this->logar($startup->user);
        
        $documento = $this->criar_documento($startup);
        $response = $this->get(route('documento.arquivo',$documento->id+99999));
        $response->assertStatus(404);
    }
}
