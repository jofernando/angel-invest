<?php

namespace Tests\Browser\leilao;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class CreateLeilaoTest extends DuskTestCase
{
    public function test_renderiza_view_criar_leilao()
    {
        $this->browse(function (Browser $browser) {
            $proposta = $this->criar_proposta();
            $this->login($browser, $proposta->startup->user);
            $browser->visitRoute('leilao.create')
                    ->assertSee('Adicionando nova exibição do produto');
            $this->resetar_session();
        });
    }

    public function test_criar_leilao_com_todas_as_informacoes()
    {
        $this->browse(function (Browser $browser) {
            $proposta = $this->criar_proposta();
            $this->login($browser, $proposta->startup->user);
            $browser->visitRoute('leilao.create')
                    ->select('produto_do_leilão', $proposta->id)
                    ->type('valor_mínimo', "2000")
                    ->type('número_de_ganhadores', 4)
                    ->script("document.querySelector('input[name=data_de_início]').value = '". date('Y-m-d', strtotime(now()->subDays(5))) . "'");
            $browser->script("document.querySelector('input[name=data_de_fim]').value = '". date('Y-m-d', strtotime(now()->addDays(5))) . "'");
            $browser->attach('termo_de_porcentagem_do_produto', __DIR__ . '/file/pdf-test.pdf')
                    ->click('#salvar')
                    ->waitForText('Criar um exibição do produto')
                    ->assertSee('Exibição do produto salvo com sucesso!');
            $this->resetar_session();
        });
    }

    public function test_criar_leilao_sem_todas_as_informacoes()
    {
        $this->browse(function (Browser $browser) {
            $proposta = $this->criar_proposta();
            $this->login($browser, $proposta->startup->user);
            $browser->visitRoute('leilao.create')
                    ->select('produto_do_leilão', $proposta->id)
                    ->type('valor_mínimo', "2000")
                    ->type('número_de_ganhadores', 4)
                    ->script("document.querySelector('input[name=data_de_início]').value = '". date('Y-m-d', strtotime(now()->subDays(5))) . "'");
            $browser->script("document.querySelector('input[name=data_de_fim]').value = '". date('Y-m-d', strtotime(now()->addDays(5))) . "'");
            $browser->click('#salvar')
                    ->waitForText('Adicionando nova exibição do produto')
                    ->assertSee('O campo termo de porcentagem do produto é obrigatório.');
            $this->resetar_session();
        });
    }

    public function test_criar_leiloes_para_mesmo_produto_com_mesmo_periodo()
    {
        $this->browse(function (Browser $browser) {
            $proposta = $this->criar_proposta();
            $this->login($browser, $proposta->startup->user);

            $browser->visitRoute('leilao.create')
                    ->select('produto_do_leilão', $proposta->id)
                    ->type('valor_mínimo', "2000")
                    ->type('número_de_ganhadores', 4)
                    ->script("document.querySelector('input[name=data_de_início]').value = '". date('Y-m-d', strtotime(now()->subDays(5))) . "'");
            $browser->script("document.querySelector('input[name=data_de_fim]').value = '". date('Y-m-d', strtotime(now()->addDays(5))) . "'");
            $browser->attach('termo_de_porcentagem_do_produto', __DIR__ . '/file/pdf-test.pdf')
                    ->click('#salvar')
                    ->waitForText('Criar uma exibição do produto')
                    ->assertSee('Exibição do produto salvo com sucesso!');

            $browser->visitRoute('leilao.create')
                    ->select('produto_do_leilão', $proposta->id)
                    ->type('valor_mínimo', "4000")
                    ->type('número_de_ganhadores', 5)
                    ->script("document.querySelector('input[name=data_de_início]').value = '". date('Y-m-d', strtotime(now()->subDays(4))) . "'");
            $browser->script("document.querySelector('input[name=data_de_fim]').value = '". date('Y-m-d', strtotime(now()->addDays(6))) . "'");
            $browser->attach('termo_de_porcentagem_do_produto', __DIR__ . '/file/pdf-test.pdf')
                    ->click('#salvar')
                    ->waitForText('Adicionando nova exibição do produto')
                    ->assertSee('Já existe um exibição para esse produto que engloba o período escolhido.');

            $this->resetar_session();
        });
    }

    public function test_criar_leiloes_para_mesmo_produto_com_periodos_diferentes()
    {
        $this->browse(function (Browser $browser) {
            $proposta = $this->criar_proposta();
            $this->login($browser, $proposta->startup->user);

            $browser->visitRoute('leilao.create')
                    ->select('produto_do_leilão', $proposta->id)
                    ->type('valor_mínimo', "2000")
                    ->type('número_de_ganhadores', 4)
                    ->script("document.querySelector('input[name=data_de_início]').value = '". date('Y-m-d', strtotime(now()->subDays(5))) . "'");
            $browser->script("document.querySelector('input[name=data_de_fim]').value = '". date('Y-m-d', strtotime(now()->addDays(5))) . "'");
            $browser->attach('termo_de_porcentagem_do_produto', __DIR__ . '/file/pdf-test.pdf')
                    ->click('#salvar')
                    ->waitForText('Criar uma exibição do produto')
                    ->assertSee('Exibição do produto salvo com sucesso!');

            $browser->visitRoute('leilao.create')
                    ->select('produto_do_leilão', $proposta->id)
                    ->type('valor_mínimo', "4000")
                    ->type('número_de_ganhadores', 5)
                    ->script("document.querySelector('input[name=data_de_início]').value = '". date('Y-m-d', strtotime(now()->addDays(10))) . "'");
            $browser->script("document.querySelector('input[name=data_de_fim]').value = '". date('Y-m-d', strtotime(now()->addDays(15))) . "'");
            $browser->attach('termo_de_porcentagem_do_produto', __DIR__ . '/file/pdf-test.pdf')
                    ->click('#salvar')
                    ->waitForText('Criar uma exibição do produto')
                    ->assertSee('Exibição do produto salvo com sucesso!');

            $this->resetar_session();
        });
    }

    public function test_criar_leilao_com_valores_negativos()
    {
        $this->browse(function (Browser $browser) {
            $proposta = $this->criar_proposta();
            $this->login($browser, $proposta->startup->user);
            $browser->visitRoute('leilao.create')
                    ->select('produto_do_leilão', $proposta->id)
                    ->type('valor_mínimo', "0")
                    ->type('número_de_ganhadores', -4)
                    ->script("document.querySelector('input[name=data_de_início]').value = '". date('Y-m-d', strtotime(now()->subDays(5))) . "'");
            $browser->script("document.querySelector('input[name=data_de_fim]').value = '". date('Y-m-d', strtotime(now()->addDays(5))) . "'");
            $browser->click('#salvar')
                    ->waitForText('Adicionando nova exibição do produto')
                    ->assertSee('O campo valor minímo deve ser pelo menos 0.01.')
                    ->assertSee('O campo número de ganhadores deve ser pelo menos 1.');
            $this->resetar_session();
        });
    }
}
