<?php

namespace Tests\Feature\leilao;

use Illuminate\Http\UploadedFile;

class CreateLeilaoTest extends LeilaoTest
{
    public function test_renderizar_criar_leilao()
    {
        $this->logar();
        $response = $this->get(route('leilao.create'));

        $response->assertStatus(200);
    }

    public function test_criar_leilao_com_todas_as_informacoes()
    {
        $produto = $this->criar_produto();
        $this->logar($produto->startup->user);

        $data_inicio = date('Y-m-d', strtotime(now()->subDays(5)));
        $data_fim = date('Y-m-d', strtotime(now()->addDays(5)));
        $termo = UploadedFile::fake()->create('teste.pdf');

        $response = $this->post(route('leilao.store'), $this->get_array_request($produto, 2000.0, 4, $data_inicio, $data_fim, $termo));

        $response->assertStatus(302);
        $response->assertSessionHas('message', 'Exibição do produto salvo com sucesso!');
    }

    public function test_criar_leilao_sem_todas_as_informacoes()
    {
        $produto = $this->criar_produto();
        $this->logar($produto->startup->user);

        $data_inicio = date('Y-m-d', strtotime(now()->subDays(5)));
        $data_fim = date('Y-m-d', strtotime(now()->addDays(5)));
        $termo = UploadedFile::fake()->create('teste.pdf');;

        $response = $this->post(route('leilao.store'), $this->get_array_request($produto, null, null, $data_inicio, $data_fim, $termo));

        $response->assertStatus(302);
        $response->assertInvalid([
            'valor_mínimo' => 'O campo valor mínimo é obrigatório.',
            'número_de_ganhadores' => 'O campo número de ganhadores é obrigatório.',
        ]);
    }

    public function test_criar_leiloes_para_mesmo_produto_com_mesmo_periodo()
    {
        $produto = $this->criar_produto();
        $this->logar($produto->startup->user);

        $data_inicio = date('Y-m-d', strtotime(now()->subDays(5)));
        $data_fim = date('Y-m-d', strtotime(now()->addDays(5)));
        $termo = UploadedFile::fake()->create('teste.pdf');;

        $response = $this->post(route('leilao.store'), $this->get_array_request($produto, 2000.0, 4, $data_inicio, $data_fim, $termo));

        $response->assertStatus(302);
        $response->assertSessionHas('message', 'Exibição do produto salvo com sucesso!');

        $data_inicio = date('Y-m-d', strtotime(now()->subDays(3)));
        $data_fim = date('Y-m-d', strtotime(now()->addDays(3)));
        $response = $this->post(route('leilao.store'), $this->get_array_request($produto, 2000.0, 4, $data_inicio, $data_fim, $termo));

        $response->assertStatus(302);
        $response->assertInvalid([
            'leilao_existente' => 'Já existe uma exibição para esse produto que engloba o período escolhido.',
        ]);
    }

    public function test_criar_leiloes_para_mesmo_produto_com_periodos_diferentes()
    {
        $produto = $this->criar_produto();
        $this->logar($produto->startup->user);

        $data_inicio = date('Y-m-d', strtotime(now()->subDays(5)));
        $data_fim = date('Y-m-d', strtotime(now()->addDays(5)));
        $termo = UploadedFile::fake()->create('teste.pdf');;

        $response = $this->post(route('leilao.store'), $this->get_array_request($produto, 2000.0, 4, $data_inicio, $data_fim, $termo));

        $response->assertStatus(302);
        $response->assertSessionHas('message', 'Exibição do produto salvo com sucesso!');

        $data_inicio = date('Y-m-d', strtotime(now()->addDays(10)));
        $data_fim = date('Y-m-d', strtotime(now()->addDays(20)));
        $response = $this->post(route('leilao.store'), $this->get_array_request($produto, 3000.0, 5, $data_inicio, $data_fim, $termo));

        $response->assertStatus(302);
        $response->assertSessionHas('message', 'Exibição do produto salvo com sucesso!');
    }

    public function test_criar_leilao_com_valores_negativos()
    {
        $produto = $this->criar_produto();
        $this->logar($produto->startup->user);

        $data_inicio = date('Y-m-d', strtotime(now()->subDays(5)));
        $data_fim = date('Y-m-d', strtotime(now()->addDays(5)));
        $termo = UploadedFile::fake()->create('teste.pdf');

        $response = $this->post(route('leilao.store'), $this->get_array_request($produto, -2000.0, -4, $data_inicio, $data_fim, $termo));

        $response->assertStatus(302);
        $response->assertInvalid([
            'valor_mínimo' => 'O campo valor minímo deve ser pelo menos 0.01.',
            'número_de_ganhadores' => 'O campo número de ganhadores deve ser pelo menos 1.',
        ]);
    }
}
