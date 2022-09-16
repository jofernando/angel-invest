<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStartupRequest;
use App\Http\Requests\UpdateStartupRequest;
use App\Models\Area;
use App\Models\Startup;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;

class StartupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $startups = Auth::user()->startups;
        return view('startups.index', compact('startups'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $startup = Auth::user()->startups->last();
        if(!is_null($startup)){
            if(!is_null($startup->endereco) && !is_null($startup->documentos->first()) && !is_null($startup->telefones->first())){
                $startup = null;
            }
        }

        if(is_null($startup)){
            $etapa = "Informações básicas";
        }
        elseif(is_null($startup->endereco)){
            $etapa = "Endereço";
        }
        elseif(is_null($startup->telefones->first())){
            $etapa = "Telefone";
        }
        elseif(is_null($startup->documentos->first())){
            $etapa = "Documentos";
        }

        $areas = Area::pluck('nome', 'id');

        return view('startups.cadastro', compact('etapa', 'startup', 'areas'));
    }

    /**
     * Show the component for creating a new startup.
     *
     * @return \Illuminate\Support\Facades\View
     */
    public function startupGetComponent(Request $request)
    {
        $startup = Auth::user()->startups->last();
        if(!is_null($startup)){
            if(!is_null($startup->endereco) && !is_null($startup->documentos->first()) && !is_null($startup->telefones->first())){
                $startup = null;
            }
        }
        switch($request->etapa_nome){
            case "Informações básicas":
                $areas = Area::pluck('nome', 'id');

                if(is_null($startup)){
                    return View::make("components.startup.create", compact('areas'))
                    ->render();
                }else{
                    return View::make("components.startup.edit", compact('startup', 'areas'))
                    ->render();
                }
            case "Endereço":
                if(!is_null($startup) && $startup->endereco == null){
                    return View::make('components.endereco.create', compact('startup'))
                    ->render();
                }elseif(!is_null($startup) && $startup->endereco != null){
                    $endereco = $startup->endereco;
                    return View::make("components.endereco.edit", compact('startup', 'endereco'))
                    ->render();
                }
            case "Telefone":
                if(!is_null($startup) && is_null($startup->telefones->first())){
                    return View::make('components.telefone.create', compact('startup'))
                    ->render();
                }elseif(!is_null($startup) && !is_null($startup->telefones->first())){
                    $telefones = $startup->telefones;
                    return View::make("components.telefone.edit", compact('startup', 'telefones'))
                    ->render();
                }
            case "Documentos":
                if(!is_null($startup) && is_null($startup->documentos->first())){
                    return View::make('components.documentos.create', compact('startup'))
                    ->render();
                }elseif(!is_null($startup) && !is_null($startup->documentos->first())){
                    $documentos = $startup->documentos;
                    return View::make("components.documentos.edit", compact('startup', 'documentos'))
                    ->render();
                }
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreStartupRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreStartupRequest $request)
    {
        $validated = $request->validated();
        $path = $request->file('logo')->store("/startups/logos", 'public');
        if(!$path) {
            return redirect()->back()->withInput()->with('error', 'Não foi possível realizar o uploud da logo.');
        }
        $validated['logo'] = $path;
        $startup = new Startup($validated);
        $startup->user()->associate(Auth::user());
        $startup->area()->associate($validated['area']);
        $startup->save();
        return redirect()->back()->with(['message' => 'Informações básicas salvas com sucesso!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Startup  $startup
     * @return \Illuminate\Http\Response
     */
    public function show(Startup $startup)
    {
        return view('startups.show', compact('startup'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Startup  $startup
     * @return \Illuminate\Http\Response
     */
    public function edit(Startup $startup)
    {
        $this->authorize('update', $startup);
        $areas = Area::pluck('nome', 'id');
        return view('startups.edit', compact('startup', 'areas'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateStartupRequest  $request
     * @param  \App\Models\Startup  $startup
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateStartupRequest $request, Startup $startup)
    {
        $validated = $request->validated();
        if($request->hasFile('logo')) {
            $oldLogo = $startup->logo;
            $path = $request->file('logo')->store("/startups/logos", 'public');
            if(!$path) {
                return redirect()->back()->withInput()->with('error', 'Não foi possível realizar o uploud da logo.');
            }
            $validated['logo'] = $path;
            Storage::disk('public')->delete($oldLogo);
        }
        if($validated['area'] != $startup->area_id) {
            $startup->area()->dissociate();
            $startup->area()->associate($validated['area']);
        }
        $startup->fill($validated);
        $startup->save();

        if(is_null($startup->endereco) || is_null($startup->documentos->first())){
            return redirect()->back()->with(['message' => 'Informações básicas atualizadas com sucesso!']);
        }

        return redirect(route('startups.show', $startup))->with(['message' => 'Informações básicas atualizadas com sucesso!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Startup  $startup
     * @return \Illuminate\Http\Response
     */
    public function destroy(Startup $startup)
    {
        $startup->delete();
        return redirect()->back();
    }
}
