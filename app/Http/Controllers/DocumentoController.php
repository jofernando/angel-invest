<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDocumentoRequest;
use App\Models\Documento;
use App\Models\Startup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class DocumentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($startup)
    {
        $startup = Startup::find($startup);
        $this->authorize('update',$startup);
        return view('documentos.create',compact('startup'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDocumentoRequest $request, $startup)
    {
        $startup = Startup::find($startup);
        $this->authorize('update',$startup);
        if ($request->documentos != null) {
            foreach ($request->documentos as $indice => $arquivo) {
                if ($arquivo != null) {
                    $documento = new Documento();
                    $documento->setAttributes($request->nomes[$indice], $startup);
                    $documento->save();
                    $documento->caminho = $documento->salvarArquivo($arquivo, $documento->caminho);
                    $documento->update();
                }
            }
        }

        if(is_null($startup->endereco) || is_null($startup->telefones->first())){
            return redirect()->back()->with(['message' => 'Documentos salvos com sucesso!']);
        }

        return redirect()->route('startups.index')->with('message', 'Startup criada com sucesso!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Documento  $documento
     * @return \Illuminate\Http\Response
     */
    public function show(Documento $documento)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Documento  $documento
     * @return \Illuminate\Http\Response
     */
    public function edit($startup)
    {
        $startup = Startup::find($startup);
        $this->authorize('update',$startup);
        $documentos = $startup->documentos;
        return view('documentos.edit',compact('startup', 'documentos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Documento  $documento
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $startup)
    {

        $startup = Startup::find($startup);
        $this->authorize('update',$startup);
        if($request->nomes != null){
            $input_data = $request->all();

            $validator = Validator::make(
                $input_data, [
                    'documentos.*' => ['file','max:5120','mimes:pdf'],
                    'nomes.*' => ['required','max:255']
                ],[
                    'documentos.*.required' => 'O arquivo é obrigatório.',
                    'documentos.*.max' => 'O tamanho máximo do arquivo é 5MB.',
                    'documentos.*.mimes' => 'O arquivo só pode ser um PDF.',
                    'nomes.*.required' => 'O nome do arquivo é obrigatório.',
                    'nomes.*.max' => 'O tamanho máximo do nome do arquivo é de 255 caracteres.'
                ]
            );

            if ($validator->fails()) {
                return redirect()->back()->withInput();
            }
        }

        if($request->docsID != null){
            $docsEditados = Documento::whereIn('id', $request->docsID)->get();
            $indice = count($request->docsID);
        }else{
            $docsEditados = collect();
            $indice = 0;
        }
        $docsExcluidos = $startup->documentos->diff($docsEditados);
        if($request->nomes != null){
            if(count($request->nomes) - $docsEditados->count()!= 0){
                $docsNovos = array_slice($request->nomes, -(count($request->nomes) - $docsEditados->count()));
            }else{
                $docsNovos = collect();
            }
        }else{
            $docsNovos = collect();
            $indice = 0;
        }

        foreach($docsNovos as $i => $nome){
            $doc = new Documento();
            $doc->setAttributes($nome, $startup);
            $doc->save();
            $doc->caminho = $doc->salvarArquivo($request->documentos[$indice+$i], $nome);
            $doc->update();
        }

        //Editando docs//
        if ($docsEditados != null && $docsEditados->count() > 0) {
            foreach($request->docsID as $i => $id) {
                $doc = Documento::find($id);
                $doc->nome = $request->nomes[$i];
                if($request->documentos != null && array_key_exists($i, $request->documentos)){
                    $doc->caminho = $doc->salvarArquivo($request->documentos[$i], $doc->caminho);
                }
                $doc->update();
            }
        }

        //Excluindo docs
        if ($docsExcluidos != null && $docsExcluidos->count() > 0) {
            foreach ($docsExcluidos as $doc) {
                $doc->deletarArquivo($doc->caminho);
                $doc->delete();
            }
        }

        if(is_null($startup->endereco) || is_null($startup->telefones->first())){
            return redirect()->back()->with(['message' => 'Documentos atualizados com sucesso!']);
        }

        return redirect(route('startups.show', $startup))->with(['message' => 'Documentos atualizados com sucesso!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Documento  $documento
     * @return \Illuminate\Http\Response
     */
    public function destroy($startup, $documento)
    {
        $documento = Documento::find($documento);
        $this->authorize('delete',$documento);
        $startup = Startup::find($startup);
        $this->authorize('update', $startup);
        $documento->deletarArquivo($documento->caminho);
        $documento->delete();

        return redirect(route('startups.index', $startup))->with(['message' => 'Documento deletado com sucesso!']);
    }

    /**
     * Get the document file from storage.
     *
     * @param  \App\Models\Documento  $documento
     * @return \Illuminate\Http\Response
     */

    public function arquivo($documento)
    {
        $documento = Documento::find($documento);
        //$this->authorize('view',$documento);
        if($documento != null){
            return Storage::disk()->exists('public/'.$documento->caminho) ? response()->file(storage_path('app/public/'.$documento->caminho)) : abort(404);
        }
        return abort(404);
    }


}
