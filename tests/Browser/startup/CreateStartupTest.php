<?php

namespace Tests\Browser\startup;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class CreateStartupTest extends DuskTestCase
{
    public function test_redenrizar_create_startup()
    {
        $this->browse(function (Browser $browser) {
            $startup = $this->criar_startup();
            $this->login($browser, $startup->user);
            $browser->visitRoute('startups.create')
                    ->assertSee('Adicionando nova startup');
            $this->resetar_session();
        });
    }

    public function test_criar_uma_startup()
    {
        $this->browse(function (Browser $browser) {
            $user = User::factory()->create();
            $this->login($browser, $user);
            $browser->visitRoute('startups.create')
                    ->type('nome', 'Teste')
                    ->type('descricao', 'Descrição teste')
                    ->type('cnpj', '14.302.047/0001-14')
                    ->select('area')
                    ->type('email', 'email.teste@gmail.com')
                    ->attach('logo', __DIR__ . '/img/teste_logo.jpg')
                    ->press('Salvar')
                    ->assertSee('Endereço')
                    ->assertSee('CEP');
            $browser->type('cep', '55293-040')
                    ->type('numero', '40')
                    ->select('estado','Pernambuco')
                    ->type('complemento', 'Teste de complemento')
                    ->press('Salvar')
                    ->assertSee('Novo telefone');
            $browser->type('numeros[]', '(12)22223-3333')
                    ->press('Salvar')
                    ->assertSee('Documentos')
                    ->assertSee('Novo documento')
                    ->type('nomes[]', 'documento teste')
                    ->attach('documentos[]', __DIR__ . '/doc/arquivo_teste.pdf')
                    ->press('Salvar')
                    ->assertSee('Startup criada com sucesso!')
                    ->assertSee('Minhas startups');
            $this->resetar_session();
        });
    }


    public function test_criar_uma_startup_com_campos_obrigatorios_nulos()
    {
        $this->browse(function (Browser $browser) {
            $user = User::factory()->create();
            $this->login($browser, $user);
            $browser->visitRoute('startups.create')
                    ->type('cnpj', '14.302.047/0001-14')
                    ->select('area')
                    ->type('email', 'email.teste@gmail.com');
            $browser->attach('logo', __DIR__ . '/img/teste_logo.jpg')
                    ->press('Salvar')
                    ->assertSee('Informações básicas')
                    ->assertSee('CNPJ');
            $this->resetar_session();
        });
    }
}
