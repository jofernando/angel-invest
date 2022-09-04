<?php

namespace Tests\Feature\leilao;

use App\Models\Leilao;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;

class UpdateLeilaoTest extends LeilaoTest
{
    public function test_redenrizar_editar_leilao()
    {
        $leilao = $this->criar_leilao();
        $this->logar($leilao->proposta->startup->user);

        $response = $this->get(route('leilao.edit', $leilao));

        $response->assertStatus(200);
    }

    public function test_editar_leilao_alterando_todos_os_campos()
    {
        $leilao = $this->criar_leilao();
        $this->logar($leilao->proposta->startup->user);

        $produto = $this->criar_produto($leilao->proposta->startup->user);
        $data_inicio = date('Y-m-d', strtotime(now()->subDays(5)));
        $data_fim = date('Y-m-d', strtotime(now()->addDays(5)));
        $termo = UploadedFile::fake()->create('teste.pdf');

        $response = $this->put(route('leilao.update', $leilao), $this->get_array_request($produto, 3000, 8, $data_inicio, $data_fim, $termo));

        $response->assertStatus(302);
        $response->assertSessionHas('message', 'Exibição do produto atualizado com sucesso!');

        $leilao = Leilao::find($leilao->id);
        $this->assertEquals($produto->id, $leilao->proposta_id);
        $this->assertEquals(3000, $leilao->valor_minimo);
        $this->assertEquals(8, $leilao->numero_ganhadores);
        $this->assertEquals($data_inicio, $leilao->data_inicio);
        $this->assertEquals($data_fim, $leilao->data_fim);
    }

    public function test_editar_leilao_alterando_alguns_campos()
    {
        $leilao = $this->criar_leilao();
        $this->logar($leilao->proposta->startup->user);

        $data_inicio = date('Y-m-d', strtotime($leilao->data_inicio));
        $data_fim = date('Y-m-d', strtotime($leilao->data_fim));

        $response = $this->put(route('leilao.update', $leilao), $this->get_array_request($leilao->proposta, 4000, 2, $data_inicio, $data_fim, null));

        $response->assertStatus(302);
        $response->assertSessionHas('message', 'Exibição do produto atualizado com sucesso!');

        $leilao = Leilao::find($leilao->id);

        $this->assertEquals(4000, $leilao->valor_minimo);
        $this->assertEquals(2, $leilao->numero_ganhadores);
    }

    public function test_editar_leilao_para_um_produto_com_mesmo_periodo()
    {
        $leilao1 = $this->criar_leilao();
        $this->logar($leilao1->proposta->startup->user);

        $leilao2 = $this->criar_leilao($leilao1->proposta->startup->user);

        $data_inicio = $leilao1->data_inicio;
        $data_fim = $leilao1->data_fim;

        $response = $this->put(route('leilao.update', $leilao2), $this->get_array_request($leilao1->proposta, 4000, 2, $data_inicio, $data_fim, null));

        $response->assertStatus(302);
        $response->assertInvalid([
            'leilao_existente' => 'Já existe uma exibição para esse produto que engloba o período escolhido.',
        ]);
    }

    public function test_editar_leilao_para_um_produto_com_periodo_diferente()
    {
        $leilao1 = $this->criar_leilao();
        $this->logar($leilao1->proposta->startup->user);
        $leilao2 = $this->criar_leilao($leilao1->proposta->startup->user);

        $data_inicio = date('Y-m-d', strtotime(now()->addDays(20)));
        $data_fim = date('Y-m-d', strtotime(now()->addDays(30)));

        $response = $this->put(route('leilao.update', $leilao2), $this->get_array_request($leilao1->proposta, 4000, 2, $data_inicio, $data_fim, null));

        $response->assertStatus(302);
        $response->assertSessionHas('message', 'Exibição do produto atualizado com sucesso!');

        $leilao = Leilao::find($leilao2->id);
        $this->assertEquals($data_inicio, $leilao->data_inicio);
        $this->assertEquals($data_fim, $leilao->data_fim);
    }
}
