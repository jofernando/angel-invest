<?php

namespace Tests\Feature;

use App\Models\Documento;
use App\Models\Endereco;
use App\Models\Investidor;
use App\Models\Lance;
use App\Models\Leilao;
use App\Models\Proposta;
use App\Models\Startup;
use App\Models\User;
use DateTime;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class LanceTest extends TestCase
{
    use RefreshDatabase;

    public User $user;
    public User $userInvestidor;
    public Startup $startup;
    public Proposta $proposta;
    public Leilao $leilao;
    public $file_1;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
        $this->user = User::factory()->create();
        $this->userInvestidor = User::factory()->create(['tipo' => 2]);
        $this->file_1 = UploadedFile::fake()->image('logo_1.jpg');
        $file_path_1 = 'startups/logos/logo_1.jpg';
        $this->startup = Startup::factory()->for($this->user)->forArea()->create(['logo' => $file_path_1]);
        Endereco::factory()->createEndereco($this->startup);
        Documento::create([
            'nome' => 'comprovante',
            'caminho' => 'startups/documentos/logo_1.jpg',
            'startup_id' => $this->startup->id
        ]);
        $this->proposta = Proposta::factory()->createProposta($this->startup);
        $this->leilao = Leilao::factory()->createLeilao($this->proposta);
    }

    public function test_visualizar_historico_de_um_leilao_com_lances()
    {
        Lance::create(['valor' => $this->leilao->valor_minimo + 1, 'investidor_id' => $this->userInvestidor->investidor->id, 'leilao_id' => $this->leilao->id]);
        $response = $this->get(route('propostas.show', ['startup' => $this->startup, 'proposta' => $this->proposta]));
        $response->assertSee($this->userInvestidor->name);
    }

    public function test_visualizar_historico_de_um_leilao_sem_lances()
    {
        $response = $this->get(route('propostas.show', ['startup' => $this->startup, 'proposta' => $this->proposta]));
        $response->assertStatus(200);
        $response->assertSee('Nenhum lance realizado');

    }

    public function test_realizar_lance_tendo_o_valor_na_carteira()
    {
        $this->followingRedirects();
        $this->userInvestidor->investidor->update(['carteira' => $this->leilao->valor_minimo + 1]);
        $this->actingAs($this->userInvestidor)->get(route('propostas.show', ['startup' => $this->startup, 'proposta' => $this->proposta]));
        $response = $this->actingAs($this->userInvestidor)->post(
            route('leiloes.lances.store', ['leilao' => $this->leilao]),
            ['valor' => number_format(floatval($this->leilao->valor_minimo) + 1, 2,",",".")]
        );
        $this->followRedirects($response)->assertSee('Lance realizado com sucesso');
        $this->assertDatabaseHas('lances', [
            'valor' => floatval($this->leilao->valor_minimo) + 1,
            'leilao_id' => $this->leilao->id,
            'investidor_id' => $this->userInvestidor->investidor->id,
        ]);
    }

    public function test_tentar_realizar_lance_sem_ter_o_valor_na_carteira()
    {
        $this->userInvestidor->investidor->update(['carteira' => 0]);
        $response = $this->actingAs($this->userInvestidor)->post(
            route('leiloes.lances.store', ['leilao' => $this->leilao]),
            ['valor' => 5000]
        );
        $response->assertSessionHasErrors(['valor']);
    }

    public function test_tentar_realizar_lance_abaixo_do_minimo()
    {
        $this->userInvestidor->investidor->update(['carteira' => $this->leilao->valor_minimo + 1]);
        $response = $this->actingAs($this->userInvestidor)->post(
            route('leiloes.lances.store', ['leilao' => $this->leilao]),
            ['valor' => $this->leilao->valor_minimo - 1]
        );
        $response->assertSessionHasErrors(['valor']);
    }

    public function test_tentar_realizar_lance_sem_informar_o_valor()
    {
        $this->userInvestidor->investidor->update(['carteira' => $this->leilao->valor_minimo + 1]);
        $response = $this->actingAs($this->userInvestidor)->post(
            route('leiloes.lances.store', ['leilao' => $this->leilao]),
            ['valor' => null]
        );
        $response->assertSessionHasErrors(['valor']);
    }
}
