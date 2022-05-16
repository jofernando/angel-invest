<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class BuscaStartupTest extends DuskTestCase
{
    public function test_renderizando_view_busca()
    {
        $this->browse(function (Browser $browser) {
            $browser->visitRoute('produto.search')
                    ->assertSee('Produtos expostos na Angel Invest');
        });
    }

    public function test_busca_startup_pelo_nome()
    {
        $this->browse(function (Browser $browser) {
            $leilao = $this->criar_leilao();

            $browser->visitRoute('produto.search')
                    ->type('nome', $leilao->proposta->startup->nome)
                    ->click('#btnbuscasubmit')
                    ->assertSee($leilao->proposta->startup->nome);
        });
    }

    public function test_busca_startup_sem_informar_o_nome()
    {
        $this->browse(function (Browser $browser) {
            $leilao = $this->criar_leilao();

            $browser->visitRoute('produto.search')
                    ->type('nome', "")
                    ->click('#btnbuscasubmit')
                    ->assertSee($leilao->proposta->startup->nome);
        });
    }

    public function test_busca_startup_nao_cadastrada()
    {
        $this->browse(function (Browser $browser) {
            $browser->visitRoute('produto.search')
                    ->type('nome', "Apresentando Angel Invest")
                    ->click('#btnbuscasubmit')
                    ->assertSee("Não foram encontrados produtos com leilão para essa busca :(");
        });
    }
}
