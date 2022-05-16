<x-app-layout>
    <div class="container" style="margin-top: 30px;">
        <div class="row titulo-pag">
            <div class="col-md-8">
                <h4><a class="link-default" href="{{route('startups.index')}}">Minhas startups</a> > <a class="link-default" href="{{route('startups.show', $startup)}}">{{mb_strimwidth($startup->nome, 0, 30, "...")}}</a> > Editando endereço</h4>
            </div>
        </div>
        <div class="card card-feature" style="margin-top:25px;">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 div-checks">
                        <div class="row mb-4 mt-4" style="text-align: center;">
                            <div class="col-md-12">
                                <a href="{{route('startups.show', $startup)}}" class="btn btn-success btn-padding border"><img src="{{asset('img/back.svg')}}" alt="Icone de voltar" style="padding-right: 5px; height: 22px;"> Voltar</a>
                            </div>  
                        </div>
                        <div class="row">
                            <div id ="left-div-create" class="col-md-12">
                                <div class="row">
                                    <div class="col-md-12 side-titulo"  style="text-align: center">
                                        Editando endereço de {{$startup->nome}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8 div-form">
                        <div class="card-body" >
                            <div style="margin-top: 15px; margin-bottom: 15px;">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h3 id="titulo-etapa" class="card-title">Endereço</h3>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="bg-[#F3F3F3]">
                                            <div class="row" style="text-align: right;">
                                                <div class="col-md-8"></div>
                                                <div class="col-md-4">
                                                    <label><span style="color: red;">*</span> Campo obrigatório</label>
                                                </div>
                                            </div>
                                            <form id="formulario" method="POST" action="{{route('enderecos.update', ['startup' => $startup, 'endereco' => $endereco])}}" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label for="cep" class="form-label pb-1 mt-2">CEP <span class="text-red">*</span></label>
                                                        <input type="cep" id="cep" name="cep" class="form-control border-ternary h-11 @error('cep') is-invalid @enderror" value="{{old('cep', $endereco->cep)}}" required onkeyup="pesquisacep(this.value);">
                                                        @error('cep')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="bairro" class="form-label pb-1 mt-2">Bairro <span class="text-red">*</span></label>
                                                        <input type="text" id="bairro" name="bairro" class="form-control border-ternary h-11 @error('bairro') is-invalid @enderror" value="{{old('bairro', $endereco->bairro)}}" required>
                                                        @error('bairro')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label for="rua" class="form-label pb-1 mt-2">Rua <span class="text-red">*</span></label>
                                                        <input type="text" id="rua" name="rua" class="form-control border-ternary h-11 @error('rua') is-invalid @enderror" value="{{old('rua', $endereco->rua)}}" required>
                                                        @error('rua')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="numero" class="form-label pb-1 mt-2" >Número <span class="text-red">*</span></label>
                                                        <input type="numero" id="numero" name="numero" class="form-control border-ternary h-11 @error('numero') is-invalid @enderror" value="{{old('numero', $endereco->numero)}}" required>
                                                        @error('numero')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label for="estado" class="form-label pb-1 mt-2">Estado <span class="text-red">*</span></label>
                                                        <select id="estado" name="estado" class="form-control border-ternary h-11 @error('estado') is-invalid @enderror" value="{{old('estado')}}" required onchange="buscaCidades(this.value)">
                                                            <option value="" disabled>--Selecione o estado--</option>
                                                            <option value="AC" @if($endereco->estado == 'AC') selected @endif>Acre</option>
                                                            <option value="AL" @if($endereco->estado == 'AL') selected @endif>Alagoas</option>
                                                            <option value="AP" @if($endereco->estado == 'AP') selected @endif>Amapá</option>
                                                            <option value="AM" @if($endereco->estado == 'AM') selected @endif>Amazonas</option>
                                                            <option value="BA" @if($endereco->estado == 'BA') selected @endif>Bahia</option>
                                                            <option value="CE" @if($endereco->estado == 'CE') selected @endif>Ceará</option>
                                                            <option value="DF" @if($endereco->estado == 'DF') selected @endif>Distrito Federal</option>
                                                            <option value="ES" @if($endereco->estado == 'ES') selected @endif>Espírito Santo</option>
                                                            <option value="GO" @if($endereco->estado == 'GO') selected @endif>Goiás</option>
                                                            <option value="MA" @if($endereco->estado == 'MA') selected @endif>Maranhão</option>
                                                            <option value="MT" @if($endereco->estado == 'MT') selected @endif>Mato Grosso</option>
                                                            <option value="MS" @if($endereco->estado == 'MS') selected @endif>Mato Grosso do Sul</option>
                                                            <option value="MG" @if($endereco->estado == 'MG') selected @endif>Minas Gerais</option>
                                                            <option value="PA" @if($endereco->estado == 'PA') selected @endif>Pará</option>
                                                            <option value="PB" @if($endereco->estado == 'PB') selected @endif>Paraíba</option>
                                                            <option value="PR" @if($endereco->estado == 'PR') selected @endif>Paraná</option>
                                                            <option value="PE" @if($endereco->estado == 'PE') selected @endif>Pernambuco</option>
                                                            <option value="PI" @if($endereco->estado == 'PI') selected @endif>Piauí</option>
                                                            <option value="RJ" @if($endereco->estado == 'RJ') selected @endif>Rio de Janeiro</option>
                                                            <option value="RN" @if($endereco->estado == 'RN') selected @endif>Rio Grande do Norte</option>
                                                            <option value="RS" @if($endereco->estado == 'RS') selected @endif>Rio Grande do Sul</option>
                                                            <option value="RO" @if($endereco->estado == 'RO') selected @endif>Rondônia</option>
                                                            <option value="RR" @if($endereco->estado == 'RR') selected @endif>Roraima</option>
                                                            <option value="SC" @if($endereco->estado == 'SC') selected @endif>Santa Catarina</option>
                                                            <option value="SP" @if($endereco->estado == 'SP') selected @endif>São Paulo</option>
                                                            <option value="SE" @if($endereco->estado == 'SE') selected @endif>Sergipe</option>
                                                            <option value="TO" @if($endereco->estado == 'TO') selected @endif>Tocantins</option>
                                                        </select>
                                                        @error('estado')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="cidade" class="form-label pb-1 mt-2">Cidade <span class="text-red">*</span></label>
                                                        <select id="cidade" name="cidade" class="form-control border-ternary h-11 @error('cidade') is-invalid @enderror" value="{{old('cidade')}}"></select>
                                                        @error('cidade')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <label for="complemento" class="form-label pb-1 mt-2">Complemento</label>
                                                        <textarea name="complemento" id="complemento" class="form-control border-ternary  @error('complemento') is-invalid @enderror" cols="30" rows="5">{{old('complemento', $endereco->complemento)}}</textarea>
                                                        @error('complemento')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="row" style="margin-top: 10px;">
                                                    <div class="grid justify-items-center">
                                                        <button type="submit" class="btn btn-secondary btn-padding border w-80 bg-verde submit-form-btn">Salvar</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" style="text-align: left;">
                    <div class="col-md-4"></div>
                    <div class="col-md-8" style="position: relative; left: -22px; padding-right: -200px;">
                        <div class="bottom-form" class="row mt-3" style="margin-left: 10px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/estado-cidade.js') }}"></script>
    <script>
        $(document).ready(function($) {
            buscaCidades(document.getElementById('estado').value);
            document.getElementById('cidade').value = {!! json_encode($endereco->cidade) !!};
        });
    </script>
</x-app-layout>
