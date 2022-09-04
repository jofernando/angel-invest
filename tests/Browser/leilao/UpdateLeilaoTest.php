<?php

namespace Tests\Browser\leilao;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class UpdateLeilaoTest extends DuskTestCase
{
    public function test_renderiza_view_editar_leilao()
    {
        $this->browse(function (Browser $browser) {
            $leilao = $this->criar_leilao();
            $this->login($browser, $leilao->proposta->startup->user);
            $browser->visitRoute('leilao.edit', $leilao)
                    ->assertSee('Editando a exibição #'.$leilao->id.' do produto '.$leilao->proposta->titulo);
            $this->resetar_session();
        });
    }

    public function test_editar_leilao_alterando_todos_os_campos()
    {
        $this->browse(function (Browser $browser) {
            $leilao = $this->criar_leilao();
            $novo_produto = $this->criar_proposta($leilao->proposta->startup->user);
            $this->login($browser, $leilao->proposta->startup->user);
            $browser->visitRoute('leilao.edit', $leilao)
                    ->select('produto_do_leilão', $novo_produto->id)
                    ->type('valor_mínimo', "3000")
                    ->type('número_de_ganhadores', 5)
                    ->script("document.querySelector('input[name=data_de_início]').value = '". date('Y-m-d', strtotime(now()->subDays(10))) . "'");
            $browser->script("document.querySelector('input[name=data_de_fim]').value = '". date('Y-m-d', strtotime(now()->addDays(10))) . "'");
            $browser->attach('termo_de_porcentagem_do_produto', __DIR__ . '/file/pdf-test.pdf')
                    ->click('#salvar')
                    ->waitForText('Criar uma exibição do produto')
                    ->assertSee('Exibição do produto atualizado com sucesso!');
            $this->resetar_session();
        });

    }

    public function test_editar_leilao_alterando_alguns_campos()
    {
        $this->browse(function (Browser $browser) {
            $leilao = $this->criar_leilao();
            $novo_produto = $this->criar_proposta($leilao->proposta->startup->user);
            $this->login($browser, $leilao->proposta->startup->user);
            $browser->visitRoute('leilao.edit', $leilao)
                    ->select('produto_do_leilão', $novo_produto->id)
                    ->type('valor_mínimo', "3000")
                    ->type('número_de_ganhadores', 5)
                    ->click('#salvar')
                    ->waitForText('Criar uma exibição do produto')
                    ->assertSee('Exibição do produto atualizado com sucesso!');
            $this->resetar_session();
        });
    }

    public function test_editar_leilao_para_um_produto_com_mesmo_periodo()
    {
        $this->browse(function (Browser $browser) {
            $leilao1 = $this->criar_leilao();
            $leilao2 = $this->criar_leilao($leilao1->proposta->startup->user);
            $this->login($browser, $leilao1->proposta->startup->user);

            $data_inicio = $leilao1->data_inicio;
            $data_fim = $leilao1->data_fim;

            $browser->visitRoute('leilao.edit', $leilao2)
                    ->select('produto_do_leilão', $leilao1->proposta->id)
                    ->type('valor_mínimo', "3000")
                    ->type('número_de_ganhadores', 5)
                    ->script("document.querySelector('input[name=data_de_início]').value = '". $data_inicio . "'");
            $browser->script("document.querySelector('input[name=data_de_fim]').value = '". $data_fim . "'");
            $browser->click('#salvar')
                    ->waitForText('Editando o exibição do produto #'.$leilao2->id.' do produto '.$leilao2->proposta->titulo)
                    ->assertSee('Já existe uma exibição para esse produto que engloba o período escolhido.');
            $this->resetar_session();
        });
    }

    public function test_editar_leilao_para_um_produto_com_periodo_diferente()
    {
        $this->browse(function (Browser $browser) {
            $leilao1 = $this->criar_leilao();
            $leilao2 = $this->criar_leilao($leilao1->proposta->startup->user);
            $this->login($browser, $leilao1->proposta->startup->user);

            $data_inicio = date('Y-m-d', strtotime(now()->addDays(20)));
            $data_fim = date('Y-m-d', strtotime(now()->addDays(30)));

            $browser->visitRoute('leilao.edit', $leilao2)
                    ->select('produto_do_leilão', $leilao1->proposta->id)
                    ->type('valor_mínimo', "3000")
                    ->type('número_de_ganhadores', 5)
                    ->script("document.querySelector('input[name=data_de_início]').value = '". $data_inicio . "'");
            $browser->script("document.querySelector('input[name=data_de_fim]').value = '". $data_fim . "'");
            $browser->click('#salvar')
                    ->waitForText('Criar um exibição do produto')
                    ->assertSee('Exibição do produto atualizado com sucesso!');
            $this->resetar_session();
        });
    }
}
