<?php

namespace Tests\Browser\startup;

use App\Models\Startup;
use App\Models\User;
use App\Models\Telefone;
use App\Models\Endereco;
use App\Models\Documento;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ShowStartupTest extends DuskTestCase
{

    public function test_redenrizar_show_startup()
    {
        $this->browse(function (Browser $browser) {
            $startup = $this->criar_startup();
            Endereco::factory()->createEndereco($startup);
            Telefone::factory()->createTelefone($startup);
            Documento::factory()->createDocumento($startup);
            $this->login($browser, $startup->user);
            $browser->visitRoute('startups.show', $startup)
                    ->assertSee('Informações básicas');
            $this->resetar_session();
        });
    }

    public function test_view_show_startup_existente()
    {
        $this->browse(function (Browser $browser) {
            $startup = $this->criar_startup();
            Endereco::factory()->createEndereco($startup);
            Telefone::factory()->createTelefone($startup);
            Documento::factory()->createDocumento($startup);
            $this->login($browser, $startup->user);
            $browser->visitRoute('startups.show',  ['startup' => $startup])
                    ->assertSee($startup->nome)
                    ->assertSee($startup->descricao)
                    ->assertSee($startup->area->nome)
                    ->assertSee($startup->endereco->rua)
                    ->assertSee($startup->endereco->estado)
                    ->assertSee($startup->endereco->cidade)
                    ->assertSee($startup->telefones->first()->numero)
                    ->assertSee($startup->documentos->first()->nome);
            $this->resetar_session();
        });
    }

    public function test_view_show_startup_inexistente()
    {
        $this->browse(function (Browser $browser) {
            $startup = $this->criar_startup();
            $this->login($browser, $startup->user);
            $browser->visitRoute('startups.show', [$startup->id + 1])
                    ->assertSee(404);
            $this->resetar_session();
        });
    }
}
