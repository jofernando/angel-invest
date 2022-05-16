<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

         <!-- Styles -->
         @livewireStyles
        <link rel="stylesheet" href="{{asset('bootstrap-5.1.3/css/bootstrap.min.css')}}">
        <link rel="stylesheet" href="{{asset('css/style.css')}}">

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
        <script src="{{asset('bootstrap-5.1.3/js/bootstrap.js')}}"></script>
        <script src="{{asset('jquery/jquery-3.6.min.js')}}"></script>
    </head>
    <body>
        @component('layouts.nav_bar')@endcomponent

        <form method="GET" action="{{route('produto.search')}}">
            <div id="container-search" class="container-fluid">
                <div class="row justify-content-center search-box">
                    <div class="col-md-12">
                        <div id="search-text-title">
                            <h2>Produtos expostos na Angel Invest</h2>
                            Mais de <span class="numero-destaque-color">{{$total-1}}</span> produtos
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center search-box mt-3">
                    <div class="col-md-7">
                        <div class="input-group mb-3">
                            <input type="text" name="nome" class="form-control" placeholder="Angel Invest" aria-label="Angel Invest" aria-describedby="button-addon2" value="{{$request->nome}}">
                            <button id="btnbuscasubmit" type="submit" class="btn btn-secondary btn-search" type="button" id="button-addon2"><img src="{{asset('img/search.svg')}}" alt="Ícone de busca"></button>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center search-box">
                    <div class="col-md-12">
                        <button class="arrow-collapse" type="button" data-bs-toggle="collapse" href="#collapse-search" role="button" aria-expanded="@if($request->avancada == 1) true @else false @endif" aria-controls="collapse-search" style="text-decoration: none;">
                            <span class="search-span">Busca Avançada</span>
                        </button>
                    </div>
                    <div class="col-md-12">
                        <button class="arrow-collapse" type="button" data-bs-toggle="collapse" href="#collapse-search" role="button" aria-expanded="@if($request->avancada == 1) true @else false @endif" aria-controls="collapse-search">
                            @if($request->avancada == 1) <img src="{{asset('img/arrow-white-up.svg')}}" alt="Ícone da busca avançada"> @else <img src="{{asset('img/arrow-white-down.svg')}}" alt="Ícone da busca avançada"> @endif
                        </button>
                    </div>
                    <div class="col-md-10">
                        <div class="collapse @if($request->avancada == 1) show @endif" id="collapse-search">
                            <div style="display: none;">
                                <input id="avancada" name="avancada" value="@if($request->avancada == 1) 1 @else 0 @endif">
                            </div>
                            <div class="card card-body">
                                <div class="row" style="text-align: left;">
                                    <div class="col-md-4 mt-4">
                                        <label for="area">Área da startup</label>
                                        <select name="area" id="area" class="form-control">
                                            <option value="">-- Selecione uma área --</option>
                                            @foreach ($areas as $area)
                                                <option @if($request->area == $area->id) selected @endif value="{{$area->id}}">{{$area->nome}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3 mt-4">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label for="">Leilão</label>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-md-12">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-radio-input" type="radio" id="atual" name="perido" value="1" @if($request->perido == "1") checked @endif>
                                                    <label class="form-check-label" for="atual">Atual</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-radio-input" type="radio" id="encerrado" name="perido" value="2" @if($request->perido == "2") checked @endif>
                                                    <label class="form-check-label" for="encerrado">Encerrado</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label for="">Período de exposição</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="data_de_inicio" style="font-size: 14px;">Data de Início</label>
                                                <input id="data_de_inicio" type="date" class="form-control" name="data_de_inicio" value="{{$request->data_de_inicio}}">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="data_de_termino" style="font-size: 14px;">Data de Término</label>
                                                <input id="data_de_termino" type="date" class="form-control" name="data_de_termino" value="{{$request->data_de_termino}}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-4" style="text-align: center;">
                                    <div class="col-md-4"></div>
                                    <div class="col-md-4">
                                        <a href="{{route('produto.search')}}" class="btn btn-secondary btn-search">Limpar filtros</a>
                                        <button class="btn btn-secondary btn-search">Buscar</button>
                                    </div>
                                    <div class="col-md-4"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        @if($leiloes_buscados->first() == null && $leiloes->first() != null)
            @if ($leiloes[0]->count() > 0)
                <div class="container-fluid mt-4">
                    <div class="row">
                        <div class="col-md-12 titulo-pag">
                            <a href="{{route('produto.search')}}" style="text-decoration: none; color:black;"><h5 style="font-weight: bolder;">Produtos em leilão</h5></a>
                        </div>
                    </div>
                    <div id="row-cards-startups" class="row" style="background-color: white">
                        @foreach ($leiloes[0] as $leilao)
                            <div class="col-md-4">
                                <div class="card card-home border-none" style="width: 100%; @if($leilao->data_fim < now()) opacity: 0.4; @endif">
                                    <div class="row area-startup" style="margin-top: -24px;">
                                        <div class="col-md-4" style="text-align: left; position: relative; left: 10px;" >
                                            @if($leilao->data_fim < now())
                                                <span style="color: rgb(238, 0, 0); background-color: white; font-weight: bold; font-size: 18px;">ENCERRADO</span>
                                            @endif
                                        </div>
                                        <div class="col-md-8" style="text-align: right; position: relative; right: 10px;">
                                            <span class="span-area-startup" style="color: black;">{{$leilao->proposta->startup->area->nome}}</span>
                                        </div>
                                    </div>
                                    <a class="video-link" href="{{route('propostas.show', ['startup' => $leilao->proposta->startup, 'proposta' => $leilao->proposta])}}">
                                        <img class="thumbnail"  src="{{asset('storage/'.$leilao->proposta->thumbnail_caminho)}}" alt="Thumbnail do produto" style="height: 220px;">
                                    </a>
                                    <div id="div-card-hearder" class="card-header">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <a id="idshowa{{$leilao->id}}" href="{{route('propostas.show', ['startup' => $leilao->proposta->startup, 'proposta' => $leilao->proposta])}}" style="color: white; text-decoration: none;"><h4 class="card-title">{{$leilao->proposta->titulo}}</h4></a>
                                                <h5 class="card-subtitle mb-2" style="color: white;">{{$leilao->proposta->startup->nome}}</h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body bg-gray-250" style="height: 200px;">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <p class="card-text">{!! mb_strimwidth($leilao->proposta->descricao, 0, 90, "...") !!} @if(strlen($leilao->proposta->descricao) > 90) <a href="{{route('propostas.show', ['startup' => $leilao->proposta->startup, 'proposta' => $leilao->proposta])}}">Exibir produto</a> @endif</p>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <img class="icon-investidor" src="{{asset('img/investidor-preto.png')}}" alt="Ícone do investidor" style="height: 60px; width: 90px;">
                                                    </div>
                                                    <div class="col-md-12">
                                                        <span class="text-proposta">{{$leilao->lances->count()}} @if($leilao->lances->count() == 1) investidor @else investidores @endif</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
            @if ($leiloes[1]->count() > 0)
                <div class="container-fluid mt-4">
                    <div class="row">
                        <div class="col-md-12 titulo-pag">
                            <a href="{{route('produto.search')}}" style="text-decoration: none; color:black;"><h5 style="font-weight: bolder;">Produtos com leilão encerrado</h5></a>
                        </div>
                    </div>
                    <div id="row-cards-startups" class="row" style="background-color: white">
                        @foreach ($leiloes[1] as $leilao)
                            <div class="col-md-4">
                                <div class="card card-home border-none" style="width: 100%; @if($leilao->data_fim < now()) opacity: 0.4; @endif">
                                    <div class="row area-startup" style="margin-top: -24px;">
                                        <div class="col-md-4" style="text-align: left; position: relative; left: 10px;" >
                                            @if($leilao->data_fim < now())
                                                <span style="color: rgb(238, 0, 0); background-color: white; font-weight: bold; font-size: 18px;">ENCERRADO</span>
                                            @endif
                                        </div>
                                        <div class="col-md-8" style="text-align: right; position: relative; right: 10px;">
                                            <span class="span-area-startup" style="color: black;">{{$leilao->proposta->startup->area->nome}}</span>
                                        </div>
                                    </div>
                                    <a class="video-link" href="{{route('propostas.show', ['startup' => $leilao->proposta->startup, 'proposta' => $leilao->proposta])}}">
                                        <img class="thumbnail"  src="{{asset('storage/'.$leilao->proposta->thumbnail_caminho)}}" alt="Thumbnail do produto" style="height: 220px;">
                                    </a>
                                    <div id="div-card-hearder" class="card-header">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <a id="idshowa{{$leilao->id}}" href="{{route('propostas.show', ['startup' => $leilao->proposta->startup, 'proposta' => $leilao->proposta])}}" style="color: white; text-decoration: none;"><h4 class="card-title">{{$leilao->proposta->titulo}}</h4></a>
                                                <h5 class="card-subtitle mb-2" style="color: white;">{{$leilao->proposta->startup->nome}}</h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body bg-gray-250" style="height: 200px;">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <p class="card-text">{!! mb_strimwidth($leilao->proposta->descricao, 0, 90, "...") !!} @if(strlen($leilao->proposta->descricao) > 90) <a href="{{route('propostas.show', ['startup' => $leilao->proposta->startup, 'proposta' => $leilao->proposta])}}">Exibir produto</a> @endif</p>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <img class="icon-investidor" src="{{asset('img/investidor-preto.png')}}" alt="Ícone do investidor" style="height: 60px; width: 90px;">
                                                    </div>
                                                    <div class="col-md-12">
                                                        <span class="text-proposta">{{$leilao->lances->count()}} @if($leilao->lances->count() == 1) investidor @else investidores @endif</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            @if ($leiloes[0]->count() == 0 && $leiloes[1]->count() == 0)
            <div class="container-fluid">
                <div id="row-startups" class="row">
                    <div class="col-md-12">
                        <a href="{{route('produto.search')}}" style="text-decoration: none; color:black;"><h6 style="font-weight: bolder;">Produtos</h6></a>
                    </div>
                </div>
                <div id="row-cards-startups" class="row">
                    <div class="col-md-12 mt-4">
                        <div class="p-5 mb-4 bg-light rounded-3">
                            <div class="container-fluid py-5">
                                <h1 class="display-5 fw-bold">Produtos</h1>
                                <p class="col-md-8 fs-4">Não foram encontrados produtos com leilão para essa busca.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        @else
            <div class="container-fluid mt-4">
                <div class="row">
                    <div class="col-md-12 titulo-pag">
                        <a style="text-decoration: none; color:black;"><h5 style="font-weight: bolder;">Resultados da busca @if($request->nome != null)"{{$request->nome}}" @else avançada @endif</h5></a>
                    </div>
                </div>
                <div id="row-cards-startups" class="row" style="background-color: white">
                    @forelse ($leiloes_buscados as $leilao)
                        <div class="col-md-4">
                            <div class="card card-home border-none" style="width: 100%; @if($leilao->data_fim < now()) opacity: 0.4; @endif">
                                <div class="row area-startup" style="margin-top: -24px;">
                                    <div class="col-md-4" style="text-align: left; position: relative; left: 10px;" >
                                        @if($leilao->data_fim < now())
                                            <span style="color: rgb(238, 0, 0); background-color: white; font-weight: bold; font-size: 18px;">ENCERRADO</span>
                                        @endif
                                    </div>
                                    <div class="col-md-8" style="text-align: right; position: relative; right: 10px;">
                                        <span class="span-area-startup" style="color: black;">{{$leilao->proposta->startup->area->nome}}</span>
                                    </div>
                                </div>
                                <a class="video-link" href="{{route('propostas.show', ['startup' => $leilao->proposta->startup, 'proposta' => $leilao->proposta])}}">
                                    <img class="thumbnail"  src="{{asset('storage/'.$leilao->proposta->thumbnail_caminho)}}" alt="Thumbnail do produto" style="height: 220px;">
                                </a>
                                <div id="div-card-hearder" class="card-header">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <a id="idshowa{{$leilao->id}}" href="{{route('propostas.show', ['startup' => $leilao->proposta->startup, 'proposta' => $leilao->proposta])}}" style="color: white; text-decoration: none;"><h4 class="card-title">{{$leilao->proposta->titulo}}</h4></a>
                                            <h5 class="card-subtitle mb-2" style="color: white;">{{$leilao->proposta->startup->nome}}</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body bg-gray-250" style="height: 200px;">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <p class="card-text">{!! mb_strimwidth($leilao->proposta->descricao, 0, 90, "...") !!} @if(strlen($leilao->proposta->descricao) > 90) <a href="{{route('propostas.show', ['startup' => $leilao->proposta->startup, 'proposta' => $leilao->proposta])}}">Exibir produto</a> @endif</p>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <img class="icon-investidor" src="{{asset('img/investidor-preto.png')}}" alt="Ícone do investidor" style="height: 60px; width: 90px;">
                                                </div>
                                                <div class="col-md-12">
                                                    <span class="text-proposta">{{$leilao->lances->count()}} @if($leilao->lances->count() == 1) investidor @else investidores @endif</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div id="row-cards-startups" class="row" style="background-color: white;">
                            <div class="col-md-12 mt-4">
                                <div class="p-5 mb-4 bg-light rounded-3">
                                    <div class="container-fluid py-5">
                                        <p class="col-md-8 fs-4">Não foram encontrados produtos com leilão para essa busca :(
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforelse
                    <div class="form-row justify-content-center">
                        <div class="col-md-12">
                            {{$leiloes_buscados->links()}}
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @component('layouts.footer')@endcomponent
        <script>
            $(document).ready(function(){
                var categories = document.getElementsByClassName('span-area-startup');
                var qtd_investor = document.getElementsByClassName('qtd-investor');

                gerar_cores(categories);
                gerar_cores(qtd_investor);

                $('.arrow-collapse').click(function() {
                    var img = this.children[0];
                    var busca = document.getElementById('avancada');
                    if(this.ariaExpanded == "true") {
                        busca.value = 1;
                        img.src = "{{asset('img/arrow-white-up.svg')}}";
                    } else if (this.ariaExpanded == "false") {
                        busca.value = 0;
                        img.src = "{{asset('img/arrow-white-down.svg')}}";
                    }
                });
            });

            function gerar_cores(html_colletion) {
                for(i = 0; i < html_colletion.length; i++) {
                    html_colletion[i].style.backgroundColor = gerar_cor();
                }
            }

            cores = [ '#7fffd4'];
            function gerar_cor() {
                return cores[parseInt(Math.random() * cores.length)];
            }

            function atualizar_icone() {

            }
        </script>
    </body>
</html>
