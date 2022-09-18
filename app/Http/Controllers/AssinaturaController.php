<?php

namespace App\Http\Controllers;

use App\Models\Assinatura;
use App\Models\Plano;
use App\Models\User;
use Illuminate\Http\Request;

class AssinaturaController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, Plano $plano)
    {
        $user = auth()->user();
        if ($user->investidor()->exists()) {
            $valor_carteira = $user->investidor->carteira;
            if ($valor_carteira >= $plano->valor) {
                $user->investidor->carteira = $valor_carteira - $plano->valor;
                $user->investidor->save();
                return $this->assinar($plano, $user);
            }
            return redirect()->back()->with('error', 'Valor na carteira não é suficiente para realizar a compra, compre mais AngelCoins.');
        }
        return $this->assinar($plano, $user);
    }

    private function assinar($plano, $user)
    {
        Assinatura::create(['plano_id' => $plano->id, 'user_id' => $user->id, 'vencimento' => now()->addDays($plano->dias)]);
        return redirect()->back()->with('success', 'Plano assinado com sucesso.');
    }
}
