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

    public function test_editar_uma_startup()
    {
        $this->browse(function (Browser $browser) {
            $startup = $this->criar_startup();
            $endereco = Endereco::factory()->createEndereco($startup);
            $telefone = Telefone::factory()->createTelefone($startup);
            $doc = Documento::factory()->createDocumento($startup);
            $this->login($browser, $startup->user);
            $browser->visitRoute('startups.show',$startup)
                    ->click('#ed-info')
                    ->assertRouteIs('startups.edit',$startup)
                    ->type ('nome', 'Novo nome startup')
                    ->type ('descricao', 'Nova descrição startup')
                    ->select('area')
                    ->attach('logo', __DIR__ . '/img/teste_logo.jpg')
                    ->press('Salvar')
                    ->assertRouteIs('startups.show',$startup)
                    ->assertSee('Informações básicas');
            $browser->click('#ed-endereco')
                    ->assertSee('Editando endereço')
                    ->type('cep', '55293-040')
                    ->type('numero', '40')
                    ->select('estado','Pernambuco')
                    ->type('complemento', 'Teste de complemento')
                    ->press('Salvar')
                    ->assertRouteIs('startups.show',$startup)
                    ->assertSee('Informações básicas');
            $browser->visitRoute('telefones.edit', ['startup' => $startup])
                    ->assertSee('Editando telefones')
                    ->type('numeros[]', '(12)22223-3333')
                    ->press('Salvar')
                    ->assertRouteIs('startups.show',$startup)
                    ->assertSee('Informações básicas');
            $browser->visitRoute('documentos.edit', ['startup' => $startup])
                    ->assertSee('Editando documentos')
                    ->type('nomes[]', 'documento teste')
                    ->attach('documentos[]', __DIR__ . '/doc/arquivo_teste.pdf')
                    ->press('Salvar')
                    ->assertRouteIs('startups.show',$startup)
                    ->assertSee('Informações básicas');
             $this->resetar_session();

        });
    }

    public function test_editar_uma_startup_com_campos_obrigatorios_nulos()
    {
        $this->browse(function (Browser $browser) {
            $startup = $this->criar_startup();
            $endereco = Endereco::factory()->createEndereco($startup);
            $telefone = Telefone::factory()->createTelefone($startup);
            $doc = Documento::factory()->createDocumento($startup);
            $this->login($browser, $startup->user);
            $browser->visitRoute('startups.show',$startup)
                    ->click('#ed-info')
                    ->assertRouteIs('startups.edit',$startup)
                    ->type ('nome', 'Novo nome startup')
                    ->type ('descricao', 'Nova descrição startup')
                    ->type ('email', null)
                    ->select('area')
                    ->attach('logo', __DIR__ . '/img/teste_logo.jpg')
                    ->press('Salvar')
                    ->assertRouteIs('startups.edit',$startup)
                    ->assertSee('O campo e-mail é obrigatório.');
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
