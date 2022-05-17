<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLanceRequest;
use App\Http\Requests\UpdateLanceRequest;
use App\Models\Investidor;
use App\Models\Lance;
use App\Models\Leilao;

class LanceController extends Controller
{

    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(Lance::class, 'lance');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lances = auth()->user()->investidor->lances;
        return view('lances.index', compact('lances'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreLanceRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Leilao $leilao, StoreLanceRequest $request)
    {
        $investidor = auth()->user()->investidor;
        if (!$leilao->esta_no_periodo_de_lances()) {
            return redirect()->route('leiloes.lances.store', $leilao)->with('error', 'Lances não podem ser realizados fora do intervalo do leilão');
        }
        if($leilao->investidor_fez_lance($investidor)) {
            return redirect()->back()->with('message', 'Você já realizou um lance, para alterar o valor atualize-o.');
        }

        if($investidor->carteira < 10) {
            return redirect()->back()->with('message', 'Créditos insuficientes para realizar um lance.');
        }
        $lance = new Lance();
        $lance->leilao()->associate($leilao);

        $lance->investidor()->associate($investidor);
        $lance->valor = $request->validated()['valor'];
        $lance->save();

        $investidor->carteira -= 10;
        $investidor->update();
        return redirect()->back()->with('message', 'Lance realizado com sucesso');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateLanceRequest  $request
     * @param  \App\Models\Lance  $lance
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLanceRequest $request, Leilao $leilao, Lance $lance)
    {
        $investidor = auth()->user()->investidor;

        if (!$leilao->esta_no_periodo_de_lances()) {
            return redirect()->route('leiloes.lances.index', ['leilao' => $leilao, 'lance' => $lance])->with('error', 'Lances não podem ser realizados fora do intervalo do leilão');
        }

        if($investidor->carteira < 10) {
            return redirect()->back()->with('message', 'Créditos insuficientes para realizar um lance.');
        }

        $lance->valor = $request->validated()['valor'];
        $lance->save();
        $investidor->carteira -= 10;
        $investidor->update();
        return redirect()->back()->with('message', 'Lance realizado com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Lance  $lance
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lance $lance)
    {
        //
    }
}
