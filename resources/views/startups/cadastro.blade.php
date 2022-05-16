<x-app-layout>
    <div id="container-home" class="container" style="margin-top: 40px;">
        <div class="row titulo-pag">
            <div class="col-md-8">
                <h4><a class="link-default" href="{{route('startups.index')}}">Minhas startups</a> > Adicionando nova startup </h4>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card card-register mb-3" style="max-width: 100%; margin-top:25px;">
                <div id="card-container" class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="row">
                                    <div id ="left-div-create" class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-12 side-titulo"  style="text-align: center">
                                                Etapas
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
                                        <div class="col-md-12">
                                            <div class="d-flex align-items-center justify-content-between pt-3">
                                                <div class="col-md-1">
                                                    @if(is_null($startup))
                                                        <div class="circulo-selected">
                                                            <div class="numero-selected">
                                                                1
                                                            </div>
                                                        </div>
                                                    @else
                                                        <img width="30" id="completo-info" src="{{asset('img/etapa-completa.svg')}}" alt="Ícone de etapa concluída">
                                                    @endif
                                                </div>
                                                <div class="col-md-11" >
                                                    <button id="botao-info" class="etapa-nome-selected" onclick=" alterarEtapa(this, 'Informações básicas', false)">Informações básicas</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="d-flex align-items-center justify-content-between pt-3">
                                                <div class="col-md-1">
                                                    @if(is_null($startup) || is_null($startup->endereco))
                                                        <div class="circulo">
                                                            <div class="numero">
                                                                2
                                                            </div>
                                                        </div>
                                                    @else
                                                        <img id="completo-endereco" width="30" src="{{asset('img/etapa-completa.svg')}}" alt="Ícone de etapa concluída">
                                                    @endif
                                                </div>
                                                <div class="col-md-11">
                                                    <button id="botao-endereco" class="etapa-nome" @if(is_null($startup)) disabled @endif onclick=" alterarEtapa(this, 'Endereço', false)">Endereço</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="d-flex align-items-center justify-content-between pt-3">
                                                <div class="col-md-1">
                                                    @if(is_null($startup) || is_null($startup->telefones->first()))
                                                        <div class="circulo">
                                                            <div class="numero">
                                                                3
                                                            </div>
                                                        </div>
                                                    @else
                                                        <img id="completo-telefone" width="30" src="{{asset('img/etapa-completa.svg')}}" alt="Ícone de etapa concluída">
                                                    @endif
                                                </div>
                                                <div class="col-md-11">
                                                    <button id="botao-telefone" class="etapa-nome" @if(is_null($startup)) disabled @endif onclick=" alterarEtapa(this, 'Telefone')">Telefone</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="d-flex align-items-center justify-content-between pt-3">
                                                <div class="col-md-1">
                                                    @if(is_null($startup) || is_null($startup->documentos->first()))
                                                        <div class="circulo">
                                                            <div class="numero">
                                                                4
                                                            </div>
                                                        </div>
                                                    @else
                                                        <img id="completo-docs" width="30" src="{{asset('img/etapa-completa.svg')}}" alt="Ícone de etapa concluída">
                                                    @endif
                                                </div>
                                                <div class="col-md-11">
                                                    <button id="botao-docs" class="etapa-nome" @if(is_null($startup)) disabled @endif onclick=" alterarEtapa(this, 'Documentos', false)">Documentos</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8" style="background-color: #F3F3F3">
                                <div class="card-body" >
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h3 id="titulo-etapa" class="card-title">Informações básicas</h3>
                                            </div>
                                            <div class="col-md-12">
                                                <div id="componente">
                                                    @if(!$errors->any())
                                                        @if(is_null($startup))
                                                            <script>
                                                                $(document).ready(function(){
                                                                     alterarEtapa($('#botao-info'), 'Informações básicas', true);
                                                                });
                                                            </script>
                                                            <x-startup.create :areas="$areas"/>
                                                        @elseif(is_null($startup->endereco))
                                                            <script>
                                                                $(document).ready(function(){
                                                                     alterarEtapa($('#botao-endereco')[0], 'Endereço', true);
                                                                });
                                                            </script>
                                                            <x-endereco.create :startup="$startup"/>
                                                        @elseif(is_null($startup->telefones->first()))
                                                            <script>
                                                                $(document).ready(function(){
                                                                     alterarEtapa($('#botao-telefone')[0], 'Telefone', true);
                                                                });
                                                            </script>
                                                            <x-telefone.create :startup="$startup"/>
                                                        @elseif(is_null($startup->documentos->first()))
                                                            <script>
                                                                $(document).ready(function(){
                                                                     alterarEtapa($('#botao-docs')[0], 'Documentos', true);
                                                                });
                                                            </script>
                                                            <x-documentos.create :startup="$startup"/>
                                                        @endif
                                                    @else
                                                        @if(!is_null(old('email')))
                                                            <script>
                                                                $(document).ready(function(){
                                                                     alterarEtapa($('#botao-info'), 'Informações básicas', true);
                                                                });
                                                            </script>
                                                            @if(is_null($startup))
                                                                <x-startup.create :areas="$areas"/>
                                                            @else
                                                                <x-startup.edit :areas="$areas" :startup="$startup"/>
                                                            @endif
                                                        @elseif(!is_null(old('cep')))
                                                            <script>
                                                                $(document).ready(function(){
                                                                     alterarEtapa($('#botao-endereco')[0], 'Endereço', true);
                                                                });
                                                            </script>
                                                            @if(is_null($startup->endereco))
                                                                <x-endereco.create :startup="$startup"/>
                                                            @else
                                                                @php
                                                                    $endereco = $startup->endereco;
                                                                @endphp
                                                                <x-endereco.edit :startup="$startup" :endereco="$endereco"/>
                                                            @endif
                                                        @elseif(!is_null(old('numeros')))
                                                            <script>
                                                                $(document).ready(function(){
                                                                    alterarEtapa($('#botao-telefone')[0], 'Telefone', true);
                                                                });
                                                            </script>
                                                            @if(is_null($startup->telefones->first()))
                                                                <x-telefone.create :startup="$startup"/>
                                                            @else
                                                                @php
                                                                    $telefones = $startup->telefones;
                                                                @endphp
                                                                <x-telefone.edit :startup="$startup" :telefones="telefones"/>
                                                            @endif
                                                        @elseif(!is_null(old('nomes')))
                                                            <script>
                                                                $(document).ready(function(){
                                                                    alterarEtapa($('#botao-docs')[0], 'Documentos', true);
                                                                });
                                                            </script>
                                                            @if(is_null($startup->documentos->first()))
                                                                <x-documentos.create :startup="$startup"/>
                                                            @else
                                                                @php
                                                                    $documentos = $startup->documentos;
                                                                @endphp
                                                                <x-documentos.edit :startup="$startup" :documentos="documentos"/>
                                                            @endif
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div id="bottom-left-div-create" class="col-md-4"></div>
                            <div id="bottom-form" class="col-md-8"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function alterarEtapa(botao, nome_etapa, erro){
            var titulo = document.getElementById("titulo-etapa");
            if(nome_etapa != titulo.innerText){
                $(".etapa-nome-selected").addClass('etapa-nome');
                $(".etapa-nome-selected").removeClass('etapa-nome-selected');
                $(".circulo-selected").addClass('circulo');
                $(".circulo-selected").removeClass('circulo-selected');
                $(".numero-selected").addClass('numero');
                $(".numero-selected").removeClass('numero-selected');

                $(botao).removeClass('etapa-nome');
                $(botao).addClass('etapa-nome-selected');
                if((nome_etapa == 'Informações básicas' && document.getElementById('completo-info') == null) ||
                    (nome_etapa == 'Endereço' && document.getElementById('completo-endereco') == null) ||
                    (nome_etapa == 'Documentos' && document.getElementById('completo-docs') == null) ||
                    (nome_etapa == 'Telefone' && document.getElementById('completo-telefone') == null)){

                    $(botao.parentElement.parentElement.children[0].children[0]).removeClass('circulo');
                    $(botao.parentElement.parentElement.children[0].children[0]).addClass('circulo-selected');
                    $(botao.parentElement.parentElement.children[0].children[0].children[0]).removeClass('numero');
                    $(botao.parentElement.parentElement.children[0].children[0].children[0]).addClass('numero-selected');
                }

                if(!erro){
                    $.ajax({
                        url:"{{route('startup.component.ajax')}}",
                        type:"get",
                        data: {"etapa_nome": nome_etapa},
                        success: function(component) {
                            $("#componente").html(component);
                        }
                    });
                }

            }
            titulo.innerText = nome_etapa;
        }
    </script>
</x-app-layout>
