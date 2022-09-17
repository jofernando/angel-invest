<?php

namespace Tests\Browser\welcome;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class VisualizarLeilaoNaoLogadoTest extends DuskTestCase
{
    public function test_renderizar_view_welcome()
    {
        $this->browse(function (Browser $browser) {
            $browser->visitRoute('home')
                    ->assertSee('Exibições de produto');
        });
    }

    public function test_click_link_leilao_existente_nao_logado()
    {
        $this->browse(function (Browser $browser) {
            $leilao = $this->criar_leilao();
            $browser->visitRoute('home')
                    ->assertSeeLink($leilao->proposta->titulo)
                    ->click("#idshowvideo".$leilao->id)
                    ->assertSee('Voltar');
        });
    }

    public function test_click_link_leilao_inexistente_nao_logado()
    {
        $this->browse(function (Browser $browser) {
            $proposta = $this->criar_proposta();
            $browser->visitRoute('home')
                    ->assertDontSeeLink($proposta->titulo);
        });
    }
}
