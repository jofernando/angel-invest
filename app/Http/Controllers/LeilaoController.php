<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Leilao;
use App\Models\Proposta;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\LeilaoRequest;
use App\Models\Lance;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class LeilaoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $leiloes = $this->leiloes_do_usuario();
        return view('leilao.index', compact('leiloes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Leilao::class);
        $produtos = $this->produto_do_usuario();
        $produto_parametro = Proposta::find($request->produto);

        return view('leilao.create', compact('produtos', 'produto_parametro'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LeilaoRequest $request)
    {
        $request->validate([
            'termo_de_porcentagem_do_produto' => 'required|file|max:5120|mimes:pdf',
        ]);

        $produto = Proposta::find($request->input('produto_do_leilão'));
        $this->authorize('userOwnsTheProposta', $produto);

        if ($this->viola_intervalo_tempo($produto, $request->input('data_de_início'), $request->input('data_de_fim'))) {
            return redirect(route('leilao.create'))->withErrors(['leilao_existente' => 'Já existe um leilão para esse produto que engloba o período escolhido.'])->withInput($request->all());
        }

        $leilao = new Leilao();
        $this->set_atributos_no_leilao($leilao, $request->all());
        $leilao->save();
        $leilao->porcetagem_caminho = $this->salvar_termo_porcetagem($leilao, $request->file('termo_de_porcentagem_do_produto'));
        $leilao->update();

        return redirect(route('leilao.index'))->with('message', 'Leilão salvo com sucesso!');
    }

    /**
     * Mostra o documento do termo ligado ao leilão.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show_termo($id)
    {
        $leilao = Leilao::find($id);
        if (Storage::disk()->exists('public/' . $leilao->porcetagem_caminho)) {
            return response()->file('storage/'.$leilao->porcetagem_caminho);
        }
        return abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $leilao = Leilao::find($id);
        $this->authorize('update', $leilao);
        $produtos = $this->produto_do_usuario();
        
        return view('leilao.edit', compact('leilao', 'produtos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(LeilaoRequest $request, $id)
    {
        $produto = Proposta::find($request->input('produto_do_leilão'));
        $leilao = Leilao::find($id);
        $this->authorize('update', $leilao);

        if ($this->viola_intervalo_tempo($produto, $request->input('data_de_início'), $request->input('data_de_fim'), $leilao)) {
            return redirect(route('leilao.edit', $leilao))->withErrors(['leilao_existente' => 'Já existe um leilão para esse produto que engloba o período escolhido.'])->withInput($request->all());
        }

        $this->set_atributos_no_leilao($leilao, $request->all());
        $leilao->porcetagem_caminho = $this->salvar_termo_porcetagem($leilao, $request->file('termo_de_porcentagem_do_produto'));
        $leilao->update();

        return redirect(route('leilao.index'))->with('message', 'Leilão atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $leilao = Leilao::find($id);
        $this->authorize('delete', $leilao);
        $this->deletar_arquivo_termo($leilao);
        $leilao->delete();

        return redirect(route('leilao.index'))->with('message', 'Leilão deletado com sucesso!');
    }

    /**
     * Retorna as propostas do empreendedor logado
     *
     * @return Collect $propostas : Propostas que o empreendedor criou
     */
    private function produto_do_usuario() 
    {
        $startups = auth()->user()->startups;
        return Proposta::whereIn('startup_id', $startups->pluck('id'))->orderBy('titulo')->get();
    }

    /**
     * Retorna os leilões do empreendedor logado
     *
     * @return Collect $leiloes : Leilões que o empreendedor criou
     */
    private function leiloes_do_usuario()
    {
        $produtos = $this->produto_do_usuario();
        return Leilao::whereIn('proposta_id', $produtos->pluck('id'))->orderBy('created_at')->get();
    }

    /**
     * Seta os atribudos do array passado no leilão
     *
     * @param Leilao $leilao : Leilão que terá os atributos setados
     * @param array $array_inputs : Array com os atributos do leilão 
     * @return void
     */
    private function set_atributos_no_leilao(Leilao $leilao, $array_inputs)
    {
        $leilao->valor_minimo = $array_inputs['valor_mínimo'];
        $leilao->data_inicio = $array_inputs['data_de_início'];
        $leilao->data_fim = $array_inputs['data_de_fim'];
        $leilao->numero_ganhadores = $array_inputs['número_de_ganhadores'];
        $leilao->proposta_id = $array_inputs['produto_do_leilão'];
    }

    /**
     * Salva o arquivo do termo de porcetagem e retorna o caminho
     *
     * @param Leilao $leilao : Leião que o arquivo será salvo
     * @param UploadetFile $file : Arquivo que será salvo
     * @return void
     */
    private function salvar_termo_porcetagem(Leilao $leilao, $file) 
    {
        if ($file != null) {
            $this->deletar_arquivo_termo($leilao);

            $path_completo = 'leiloes/' . $leilao->id . '/';
            $nome = $file->getClientOriginalName();
            Storage::putFileAs('public/'.$path_completo, $file, $nome);
            return $path_completo . $nome;
        }
        return $leilao->porcetagem_caminho;
    }

    /**
     * Checa se existe algum leilão que englobe aquele determinado período de tempo de um produto
     *
     * @param Proposta $produto : Produto que terá o leilão vinculado
     * @param date $data_inicio : Data de início do objeto que será criado
     * @param date $data_fim :  Data de fim do objeto que será criado
     * @param Leilao|null $leilao : Para ignorar o objeto leilão passado
     * @return boolean
     */
    private function viola_intervalo_tempo(Proposta $produto, $data_inicio, $data_fim, Leilao $leilao = null)
    {
        $inicio = new Carbon($data_inicio);
        $fim = new Carbon($data_fim);
        $query = Leilao::query();

        if ($leilao) {
            $query = $query->where([['id', '!=', $leilao->id], ['proposta_id', '=', $produto->id], ['data_inicio', '>=', $inicio], ['data_fim', '>=', $inicio], ['data_inicio', '<=', $fim], ['data_fim', '<=', $fim]]);
            $query = $query->orWhere([['id', '!=', $leilao->id], ['proposta_id', '=', $produto->id], ['data_inicio', '<=', $inicio], ['data_fim', '>=', $inicio], ['data_inicio', '<=', $fim], ['data_fim', '>=', $fim]]);
            $query = $query->orWhere([['id', '!=', $leilao->id], ['proposta_id', '=', $produto->id], ['data_inicio', '<=', $inicio], ['data_fim', '>=', $inicio], ['data_inicio', '<=', $fim], ['data_fim', '<=', $fim]]);
            $query = $query->orWhere([['id', '!=', $leilao->id], ['proposta_id', '=', $produto->id], ['data_inicio', '>=', $inicio], ['data_fim', '>=', $inicio], ['data_inicio', '<=', $fim], ['data_fim', '>=', $fim]]);
            return $query->first() ? true : false;
        }
        
        $query = $query->where([['data_inicio', '>=', $inicio], ['proposta_id', $produto->id], ['data_fim', '>=', $inicio], ['data_inicio', '<=', $fim], ['data_fim', '<=', $fim]]);
        $query = $query->orWhere([['data_inicio', '<=', $inicio], ['proposta_id', $produto->id], ['data_fim', '>=', $inicio], ['data_inicio', '<=', $fim], ['data_fim', '>=', $fim]]);
        $query = $query->orWhere([['data_inicio', '<=', $inicio], ['proposta_id', $produto->id], ['data_fim', '>=', $inicio], ['data_inicio', '<=', $fim], ['data_fim', '<=', $fim]]);
        $query = $query->orWhere([['data_inicio', '>=', $inicio], ['proposta_id', $produto->id], ['data_fim', '>=', $inicio], ['data_inicio', '<=', $fim], ['data_fim', '>=', $fim]]);
        return $query->first() ? true : false;
    }

    /**
     * Deleta o arquivo do termo de porcentagem do leilão caso exista
     *
     * @param Leilao $leilao
     * @return void
     */
    private function deletar_arquivo_termo(Leilao $leilao)
    {
        if ($leilao->porcetagem_caminho != null) {
            if (Storage::disk()->exists('public/' . $leilao->porcetagem_caminho)) {
                Storage::delete('public/' . $leilao->porcetagem_caminho);
            }
        }
    }

    /**
     * Recupera todos os lances realizados naquele leilão e exibe em uma tela única
     *
     * @param Leilao $leilao
     * @return void
     */

    public function leilaoLances(Leilao $leilao)
    {
        $this->authorize('create', Leilao::class);
        $lances = Lance::where('leilao_id', $leilao->id)->orderByDesc('valor')->paginate(20);
        return view('leiloes.lances.index', compact('lances', 'leilao'));
    }
}
