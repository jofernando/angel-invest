<x-app-layout>
    <div class="container index-proposta" style="margin-top: 50px;">
        <div class="row titulo-pag">
            <div class="col-md-8">
                <h4><a class="link-default" href="{{route('startups.index')}}">Minhas startups</a> > <a class="link-default" href="{{route('startups.show', $leilao->proposta->startup)}}">{{mb_strimwidth($leilao->proposta->startup->nome, 0, 30, "...")}}</a> > <a class="link-default" href="{{route('propostas.show', ['startup' => $leilao->proposta->startup, 'proposta' => $leilao->proposta])}}">{{$leilao->proposta->titulo}}</a> > Lances</h4>
            </div>
        </div>
        <div class="col-md-12 mt-2 mb-2">
            <div class="card">
                <div class="card-body">
                    <div class="content-between">
                        <div class="row">
                            @if($lances->count() > 0)
                                @foreach($lances as $index => $lance)
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
                                        <p class ='text-sm font-bold mb-0 text-center'>{{ $lance->investidor->user->name }}</p>
                                        <p class="text-xs text-center">R$ {{ number_format($lance->valor, 2,",",".") }}</p>
                                    </div>
                                @endforeach
                                <div class="form-row justify-content-center">
                                    <div class="col-md-12">
                                        {{$lances->links()}}
                                    </div>
                                </div>
                            @else
                                <div class="col-md-12">
                                    <div class="p-5 mb-4 bg-light rounded-3">
                                        <div class="container-fluid py-5">
                                            <h3 class="w-full text-center">Nenhum lance realizado</h3>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>