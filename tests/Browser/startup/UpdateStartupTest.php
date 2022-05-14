<?php

namespace Tests\Browser\startup;

use App\Models\Documento;
use App\Models\Endereco;
use App\Models\Startup;
use App\Models\Telefone;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class UpdateStartupTest extends DuskTestCase
{
    public function test_redenrizar_edit_startup()
    {
        $this->browse(function (Browser $browser) {
            $startup = $this->criar_startup();
            Endereco::factory()->createEndereco($startup);
            Telefone::factory()->createTelefone($startup);
            Documento::factory()->createDocumento($startup);
            $this->login($browser, $startup->user);
            $browser->visitRoute('startups.edit', $startup)
                    ->assertSee('Editando');
            $this->resetar_session();
        });
    }

    public function test_editar_startup_de_outro_dono()
    {
        $this->browse(function (Browser $browser) {
            $outro_usuario = User::factory()->create();
            $startup = $this->criar_startup();
            $browser->loginAs($outro_usuario)
                    ->visit(route('startups.edit', $startup))
                    ->assertSee('UNAUTHORIZED');
            $this->resetar_session();
        });
    }
}
