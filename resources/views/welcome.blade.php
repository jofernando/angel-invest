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
        <div id="container-home" class="container">
            <div id="home-box" class="row justify-content-center">
                <div class="col-md-12">
                    <img id="logo-angel-invest" src="{{asset('img/AngelInvest.png')}}" alt="Logo angel invest">
                    <div id="home-text">
                        A AngelInvest é uma startup que visa aproximar investidores-anjo e startups que estão começando no mercado atualmente. Através da nossa plataforma online o dono da startup pode expor seu pitch, plano de negócio, métricas em uma espécie de leilão. Dando a possibilidade do investidor visualizar sua empresa e caso tenha interesse dar um lance. O lance mais alto ao fim do período de exposição pode negociar com o dono da startup.
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div id="row-startups" class="row">
                <div class="col-md-12">
                    <a href="{{route('produto.search')}}" style="text-decoration: none; color:black;"><h6 style="font-weight: bolder;">Produtos</h6></a>
                </div>
            </div>
            <div id="row-cards-startups" class="row">
                @if ($leiloes->count() > 0)
                    @foreach ($leiloes as $leilao)
                        <div class="col-md-4">
                            <div class="card card-home border-none" style="width: 100%;">
                                <div class="row area-startup" style="margin-top: -24px;">
                                    <div class="col-md-4"></div>
                                    <div class="col-md-8" style="text-align: right; position: relative; right: 10px;">
                                        <span class="span-area-startup" style="color: black;">{{$leilao->proposta->startup->area->nome}}</span>
                                    </div>
                                </div>
                                <a id="idshowvideo{{$leilao->id}}" class="video-link" href="{{route('propostas.show', ['startup' => $leilao->proposta->startup, 'proposta' => $leilao->proposta])}}">
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
                                <div class="card-body" style="height: 200px;">
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
                @else
                    <div class="col-md-12 mt-4">
                        <div class="p-5 mb-4 bg-light rounded-3">
                            <div class="container-fluid py-5">
                                <h1 class="display-5 fw-bold">Leilões</h1>
                                <p class="col-md-8 fs-4">Não existem leilões ocorrendo atualmente. <a href="{{route('produto.search')}}">Clique aqui</a> para buscar leilões que já ocorreram.</p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        @component('layouts.footer')@endcomponent

        <script>
            $(document).ready(function(){
                categories = document.getElementsByClassName('span-area-startup');
                qtd_investor = document.getElementsByClassName('qtd-investor');

                gerar_cores(categories);
                gerar_cores(qtd_investor);
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
        </script>
    </body>
</html>
