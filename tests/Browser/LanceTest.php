<?php

namespace Tests\Browser;

use App\Models\Investidor;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LanceTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function test_visualizar_historico_de_lances()
    {
        $this->browse(function (Browser $browser) {
            $user = User::factory()->create(['tipo' => 2]);
            $leilao = $this->criar_leilao($user);
            $browser->loginAs($user)
                ->visit(route('propostas.show', ['proposta' => $leilao->proposta, 'startup' => $leilao->proposta->startup]))
                ->waitForText('Nenhum lance realizado',15)
                ->assertSee('Nenhum lance realizado');
            $this->resetar_session();
        });
    }

    public function test_realizar_lance_tendo_dinheiro_na_carteira()
    {
        $this->browse(function (Browser $browser) {
            $user = User::factory()->create(['tipo' => 2]);
            $leilao = $this->criar_leilao($user);
            Investidor::find($user->investidor->id)->update(['carteira' => $leilao->valor_minimo + 1000]);
            $browser->loginAs($user)
                ->visit(route('propostas.show', ['proposta' => $leilao->proposta, 'startup' => $leilao->proposta->startup]))
                ->press('Fazer lance')
                ->waitForText('Valor do lance')
                ->typeSlowly('valor', number_format($leilao->valor_minimo, 2,",","."))
                ->press('Fazer lance')
                ->waitForText('Lance realizado com sucesso',15)
                ->assertSee('Lance realizado com sucesso');
            $this->resetar_session();
        });
    }

    public function test_realizar_lance_sem_ter_dinheiro_na_carteira()
    {
        $this->browse(function (Browser $browser) {
            $user = User::factory()->create(['tipo' => 2]);
            $leilao = $this->criar_leilao($user);
            Investidor::find($user->investidor->id)->update(['carteira' => 0]);
            $browser->loginAs($user)
                ->visit(route('propostas.show', ['proposta' => $leilao->proposta, 'startup' => $leilao->proposta->startup]))
                ->press('Fazer lance')
                ->waitForText('Valor do lance')
                ->typeSlowly('valor', number_format($leilao->valor_minimo, 2,",","."))
                ->press('Fazer lance')
                ->waitForText('Você não possui AnjoCoins suficientes para realizar o lance',15)
                ->assertSee('Você não possui AnjoCoins suficientes para realizar o lance');
            $this->resetar_session();
        });
    }
}
