<x-app-layout>
    <div class="container index-proposta" style="margin-top: 30px;">
        <div class="row titulo-pag">
            <div class="col-md-12">
                <h4><a class="link-default" href="{{route('startups.index')}}">Minhas startups</a> > {{mb_strimwidth($startup->nome, 0, 30, "...")}}</h4>
            </div>
        </div>
        @if(session('message'))
            <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                </symbol>
            </svg>
            <div class="alert alert-success d-flex align-items-center" role="alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
                <div>
                    {{session('message')}}
                </div>
            </div>
        @endif
        <div id="info">
            <div class="py-6">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="col-md-12">
                        <div class="d-flex align-items-center justify-content-between pt-3">
                            <div class="col-md-6">
                                <h2>Informações básicas</h2>
                            </div>
                            <div class="col-md-6">
                                <a id="ed-info" href="{{route('startups.edit', ['startup' => $startup])}}" class="btn btn-success btn-default btn-padding border"> <img src="{{asset('img/edit.svg')}}" alt="Icone de editar produto"> Editar</a>
                            </div>
                        </div>
                    </div>
                    <div class="pb-3" style="margin-top: 10px">
                        <label class="form-label" for="nome">Nome</label>
                        <input type="text"
                            class="form-control border-ternary h-11"
                            id="nome"
                            name="nome"
                            value="{{ old('nome', $startup->nome) }}"
                            disabled
                            >
                    </div>
                    <div class="pb-3">
                        <label class="form-label" for="descricao">Descrição</label>
                        <textarea name="descricao"
                            id="descricao"
                            class="form-control border-ternary"
                            cols="30"
                            rows="3"
                            disabled>{{ old('descricao', $startup->descricao) }}</textarea>
                    </div>
                    <div class="row">
                        <div class="pb-3 col-6">
                            <label class="form-label" for="cnpj">CNPJ</label>
                            <input type="text"
                                class="form-control border-ternary h-11"
                                id="cnpj"
                                name="cnpj"
                                value="{{ old('cnpj', $startup->cnpj) }}"
                                disabled>

                        </div>
                        <div class="pb-3 col-6">
                            <label class="form-label" for="area">Área</label>
                            <select id="area"
                                name="area"
                                class="form-select border-ternary h-11"
                                disabled>
                                    <option value="{{ $startup->area->id }}">
                                        {{ $startup->area->nome  }}
                                    </option selected>
                            </select>
                        </div>
                    </div>
                    <div class="pb-3">
                        <label class="form-label" for="email">E-mail</label>
                        <input type="email"
                            class="form-control border-ternary h-11"
                            id="email"
                            name="email"
                            value="{{ old('email', $startup->email) }}"
                            disabled>
                    </div>
                    <div class="pb-3">
                        <label class="form-label" for="logo">Logo</label>
                        <input type="file"
                            name="logo"
                            class="form-control-file d-none"
                            id="logo">
                        <div class="w-32 h-32">
                            <div class="w-full h-full bg-black rounded-full flex items-center justify-center align-middle relative overflow-hidden">
                                <img id="logo-display" src="{{ asset('storage/'.$startup->logo) }}" alt="" class="h-28 py-2">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="endereco">
            <div class="row titulo-pag">
            </div>
            <div class="py-2">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="col-md-12">
                        <div class="d-flex align-items-center justify-content-between pt-3">
                            <div class="col-md-6">
                                <h2>Endereço</h2>
                            </div>
                            <div class="col-md-6">
                                <a id='ed-endereco' href="{{route('enderecos.edit', ['startup' => $startup, 'endereco' => $startup->endereco])}}" class="btn btn-success btn-default btn-padding border"> <img src="{{asset('img/edit.svg')}}" alt="Icone de editar produto"> Editar</a>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="margin-top: 10px">
                        <div class="col-md-6">
                            <label for="cep" class="form-label pb-1">CEP</label>
                            <input type="text" id="cep" name="cep" class="form-control border-ternary h-11" value="{{old('cep', $startup->endereco->cep)}}" disabled>
                        </div>
                        <div class="col-md-6">
                            <label for="bairro" class="form-label pb-1">Bairro</label>
                            <input type="text" id="bairro" name="bairro" class="form-control border-ternary h-11" value="{{old('bairro', $startup->endereco->bairro)}}" disabled>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="rua" class="form-label pb-1">Rua</label>
                            <input type="text" id="rua" name="rua" class="form-control border-ternary h-11" value="{{old('rua', $startup->endereco->rua)}}" disabled>
                            @error('rua')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="numero" class="form-label pb-1" >Número</label>
                            <input type="numero" id="numero" name="numero" class="form-control border-ternary h-11" value="{{old('numero', $startup->endereco->numero)}}" disabled>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="estado" class="form-label pb-1">Estado</label>
                            <select id="estado" name="estado" class="form-control border-ternary h-11"  disabled>
                                <option value="AC" @if($startup->endereco->estado == 'AC') selected @endif>Acre</option>
                                <option value="AL" @if($startup->endereco->estado == 'AL') selected @endif>Alagoas</option>
                                <option value="AP" @if($startup->endereco->estado == 'AP') selected @endif>Amapá</option>
                                <option value="AM" @if($startup->endereco->estado == 'AM') selected @endif>Amazonas</option>
                                <option value="BA" @if($startup->endereco->estado == 'BA') selected @endif>Bahia</option>
                                <option value="CE" @if($startup->endereco->estado == 'CE') selected @endif>Ceará</option>
                                <option value="DF" @if($startup->endereco->estado == 'DF') selected @endif>Distrito Federal</option>
                                <option value="ES" @if($startup->endereco->estado == 'ES') selected @endif>Espírito Santo</option>
                                <option value="GO" @if($startup->endereco->estado == 'GO') selected @endif>Goiás</option>
                                <option value="MA" @if($startup->endereco->estado == 'MA') selected @endif>Maranhão</option>
                                <option value="MT" @if($startup->endereco->estado == 'MT') selected @endif>Mato Grosso</option>
                                <option value="MS" @if($startup->endereco->estado == 'MS') selected @endif>Mato Grosso do Sul</option>
                                <option value="MG" @if($startup->endereco->estado == 'MG') selected @endif>Minas Gerais</option>
                                <option value="PA" @if($startup->endereco->estado == 'PA') selected @endif>Pará</option>
                                <option value="PB" @if($startup->endereco->estado == 'PB') selected @endif>Paraíba</option>
                                <option value="PR" @if($startup->endereco->estado == 'PR') selected @endif>Paraná</option>
                                <option value="PE" @if($startup->endereco->estado == 'PE') selected @endif>Pernambuco</option>
                                <option value="PI" @if($startup->endereco->estado == 'PI') selected @endif>Piauí</option>
                                <option value="RJ" @if($startup->endereco->estado == 'RJ') selected @endif>Rio de Janeiro</option>
                                <option value="RN" @if($startup->endereco->estado == 'RN') selected @endif>Rio Grande do Norte</option>
                                <option value="RS" @if($startup->endereco->estado == 'RS') selected @endif>Rio Grande do Sul</option>
                                <option value="RO" @if($startup->endereco->estado == 'RO') selected @endif>Rondônia</option>
                                <option value="RR" @if($startup->endereco->estado == 'RR') selected @endif>Roraima</option>
                                <option value="SC" @if($startup->endereco->estado == 'SC') selected @endif>Santa Catarina</option>
                                <option value="SP" @if($startup->endereco->estado == 'SP') selected @endif>São Paulo</option>
                                <option value="SE" @if($startup->endereco->estado == 'SE') selected @endif>Sergipe</option>
                                <option value="TO" @if($startup->endereco->estado == 'TO') selected @endif>Tocantins</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="cidade" class="form-label pb-1">Cidade</label>
                            <select id="cidade" name="cidade" class="form-control border-ternary h-11" disabled>
                                <option value="">{{$startup->endereco->cidade}}</option>
                            </select>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label for="complemento" >Complemento</label>
                            <textarea name="complemento" id="complemento" class="form-control border-ternary" cols="30" rows="5" disabled>{{old('complemento', $startup->endereco->complemento)}}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="documentos">
            <div class="row titulo-pag" style="margin-top: 30px;">
            </div>
            <div class="py-2">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="col-md-12">
                        <div class="d-flex align-items-center justify-content-between pt-3">
                            <div class="col-md-6">
                                <h2>Documentos</h2>
                            </div>
                            <div class="col-md-6">
                                <a id="ed-docs" href="{{route('documentos.edit', ['startup' => $startup])}}" class="btn btn-success btn-default btn-padding border"> <img src="{{asset('img/edit.svg')}}" alt="Icone de editar produto"> Editar</a>
                            </div>
                        </div>
                    </div>
                    @foreach ($startup->documentos as $i => $documento)
                        <div class="row">
                            <div class="col-md-6">
                                <label for="nome_{{$i}}" class="form-label pb-1">{{$i+1}} - {{$documento->nome}}</label>
                                <a href="{{route('documento.arquivo', ['documento' => $documento->id])}}" target="_blank"><img src="{{asset('img/file-pdf-solid.svg')}}" alt="documento {{$documento->nome}}" style="width: 16px;"></a>
                            </div>
                            <div class="col-md-6">
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div id="telefones">
            <div class="row titulo-pag" style="margin-top: 30px;">
            </div>
            <div class="py-2">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="col-md-12">
                        <div class="d-flex align-items-center justify-content-between pt-3">
                            <div class="col-md-6">
                                <h2>Telefones</h2>
                            </div>
                            <div class="col-md-6">
                                <a id="ed-telefone" href="{{route('telefones.edit', ['startup' => $startup])}}" class="btn btn-success btn-default btn-padding border"> <img src="{{asset('img/edit.svg')}}" alt="Icone de editar proposta"> Editar</a>
                            </div>
                        </div>
                    </div>
                    @foreach ($startup->telefones as $i => $telefone)
                        <div class="row">
                            <div class="col-md-6">
                                <label for="nome_{{$i}}" class="form-label pb-1">{{$i+1}} - {{$telefone->numero}}</label>
                            </div>
                            <div class="col-md-6">
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
