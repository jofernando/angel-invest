<x-app-layout>
    <div class="container-fluid" style="margin-bottom: -70px;">
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
        <div class="row">
            @forelse ($lances as $index => $lance)
                @if(auth()->user()->investidor && $lance->investidor->id == auth()->user()->investidor->id)
                    @include('leiloes.lances.edit', ['leilao' => $lance->leilao, 'lance' => $lance])
                @endif
                <div class="col-md-6 mt-2 mb-2">
                    <div class="card">
                        <div class="card-body" style="margin-top: -15px;">
                            <div class="row justify-content-between" style="height: 100%">
                                <div class="col-md-6 py-0 px-0">
                                    <div class="row area-startup" style="margin-top: -24px;">
                                        <div class="col-md-4"></div>
                                        <div class="col-md-8" style="text-align: right; position: relative; right: 10px; top: 23px;">
                                            <span class="span-area-startup" style="color: white;">{{$lance->leilao->proposta->startup->area->nome}}</span>
                                        </div>
                                    </div>
                                    <a class="" href="{{route('propostas.show', ['startup' => $lance->leilao->proposta->startup, 'proposta' => $lance->leilao->proposta])}}">
                                        <img class="thumbnail"  src="{{asset('storage/'.$lance->leilao->proposta->thumbnail_caminho)}}" alt="Thumbnail do produto"  style="height: 220px" width="100%">
                                    </a>
                                    <div id="div-card-hearder" class="card-header">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <a href="{{route('propostas.show', ['startup' => $lance->leilao->proposta->startup, 'proposta' => $lance->leilao->proposta])}}" style="color: white; text-decoration: none;"><h5 class="card-title">{{$lance->leilao->proposta->titulo}}</h5></a>
                                                <h6 class="card-subtitle mb-2" style="color: white;">{{$lance->leilao->proposta->startup->nome}}</h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-4 pl-3 mt-3">
                                        @if ($leilao = $lance->leilao)
                                            <div>
                                                <span class="text-proposta" style="font-size: 14px"><img class="icon" src="{{asset('img/calendar.svg')}}" alt="Ícone de calendario"> Período do leilão: <b>{{date('d/m', strtotime($leilao->data_inicio))}} a {{date('d/m', strtotime($leilao->data_fim))}}</b></span>
                                            </div>
                                            <div>
                                                <span class="text-proposta" style="font-size: 14px"><img class="icon" src="{{asset('img/preco.svg')}}" alt="Ícone de lance mínimo"> Lance mínimo: <b>R$ {{number_format($leilao->valor_minimo, 2,",",".")}}</b></span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="row pl-3">
                                        <div class="row">
                                            <div class="col-md-12" style="font-size: 16px">
                                                Contato
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12" style="font-size: 14px">
                                                <span style="font-weight: bolder;">E-mail: </span> {{$lance->leilao->proposta->startup->email}}
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12" style="font-size: 14px">
                                                <span style="font-weight: bolder;">Contato: </span> {{$lance->leilao->proposta->startup->telefones->first()->numero}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 bg-fundo pt-3 grid content-between">
                                    <div class="row">
                                        @forelse ($lance->leilao->lances as $index => $lance)
                                            @if($index < $lance->leilao->numero_ganhadores)

                                                <div @class([
                                                        'w-1/2' => $index == 1 || $index == 2,
                                                        'w-full' => $index != 1 && $index != 2,
                                                    ])>
                                                    <div class="grid justify-content-center">
                                                        <div @class([
                                                                'rounded-full grid place-content-center',
                                                                'h-12 w-12' => $index >= 3,
                                                                'h-16 w-16' => $index < 3,
                                                                'bg-[#EEBC3B]' => $index == 0,
                                                                'bg-[#989898]' => $index == 1,
                                                                'bg-[#BE770C]' => $index == 2,
                                                                'bg-[#C4C4C4]' => $index > 2,
                                                            ])>
                                                            <img src="{{ $lance->investidor->user->profile_photo_url }}" alt="{{ $lance->investidor->user->name }}"
                                                                @class([
                                                                    'rounded-full object-cover',
                                                                    'h-8 w-8' => $index >= 3,
                                                                    'h-12 w-12' => $index < 3,
                                                                ])>
                                                        </div>
                                                    </div>
                                                    <p @class([
                                                            'text-sm font-bold mb-0 text-center',
                                                            'text-blue-500' => $lance->investidor->user->id == auth()->user()->id,
                                                        ])>
                                                        @if ($lance->investidor->user->id == auth()->user()->id)
                                                            Você
                                                        @else
                                                            {{ $lance->investidor->user->name }}
                                                        @endif
                                                    </p>
                                                    <p class="text-xs text-center">R$ {{ number_format($lance->valor, 2,",",".") }}</p>
                                                </div>
                                            @endif
                                        @empty
                                            <h3 class="w-full text-center">Nenhum lance realizado</h3>
                                        @endforelse
                                        <div>
                                            @if(!$lance->leilao->lances()->take($lance->leilao->numero_ganhadores)->get()->pluck('investidor_id')->contains(auth()->user()->investidor->id))
                                                <div class="bg-[#FFD6D6] text-center py-3 mx-4 mb-2 px-2 text-[#2F0E0E]">
                                                    Faça um lance maior que R$ {{ number_format($leilao->valor_corte(), 2, ',', '.') }} para conseguir o produto
                                                </div>
                                            @endif
                                            @if($lance->leilao->proposta->leilao_atual())
                                                @if($lance->leilao->id == $lance->leilao->proposta->leilao_atual()->id)
                                                    <div class="w-full grid justify-center">
                                                        <button class="btn btn-success btn-color-dafault mb-4" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                            {{ __('Atualizar lance') }}
                                                        </button>
                                                    </div>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-md-12">
                    <div class="p-5 mb-5 mt-4 bg-light rounded-3">
                        <div class="container-fluid py-5">
                            <h1 class="display-5 fw-bold">Investimentos</h1>
                            <p class="col-md-8 fs-4">Nenhum lance efutado</p>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
    @if (count($errors) > 0)
        <script type="text/javascript">
            var myModal = new bootstrap.Modal(document.getElementById('exampleModal'), {
                keyboard: false
            })
            myModal.show()
        </script>
    @endif
    <script>
        cores = ['#00ffff', '#7fffd4', '#8a2be2', '#a52a2a', '#5f9ea0', '#6495ed', '#008b8b', '#bdb76b', '#ff8c00',
                 '#483d8b', '#8fbc8f', '#2f4f4f', '#ffd700', '#20b2aa', '#ffa07a', '#87cefa', '#66cdaa', '#9370db', '#3cb371', '#191970'];

        $(document).ready(function(){
            $('.span-area-startup').each(function(index, element) {
                element.style.backgroundColor = cores[parseInt(Math.random() * cores.length)]
            });
            $('#valor').mask('#.##0,00', {
                reverse: true
            });
            $('#menu').click(function() {
                $('#collapseExample').toggleClass('hidden');
                $('#divFormFazerLance').toggleClass('col-lg-9');
            });
        });
    </script>
</x-app-layout>
