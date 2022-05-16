<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Alterando o lance para o leilão do produto {{ $leilao->proposta->startup->nome }}</h5>
                <button type="button" class="btn-close mr-3" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body bg-azul ">
                <div class="card-body px-0 pt-1 flex flex-wrap">
                    {{--<div class="order-1 col-12 flex justify-end">
                        <div class="w-1/4 flex justify-center">
                            <button type="button" id="menu">
                                <img src="{{ asset('img/menu.svg') }}"
                                    alt="botao">
                            </button>
                        </div>
                    </div>--}}
                    <div id="divFormFazerLance" class="order-3 order-lg-2 mb-2 mt-4 px-0 bg-fundo col-lg-12 col-12">
                        <form id="formFazerLance" action="{{route('leiloes.lances.update', ['leilao' => $leilao, 'lance' => $lance])}}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mx-10 pt-3">
                                <div class="grid justify-items-end">
                                    <label>
                                        <span class="text-red">*</span>
                                        Campo obrigatório
                                    </label>
                                </div>
                                    @if(!$leilao->lances()->take($leilao->numero_ganhadores)->get()->pluck('investidor_id')->contains(auth()->user()->investidor->id))
                                        <div class="bg-[#FFD6D6] text-center py-3 text-[#2F0E0E]">
                                            Faça um lance maior que R$ {{ number_format($leilao->valor_corte(), 2, ',', '.') }} para conseguir o produto
                                        </div>
                                    @endif
                                <div class="flex mt-3">
                                    <div class="w-1/2 bg-[#DADADA] mr-2 text-center py-3">
                                        Valor na carteira: <span class="text-[#03A000]">R$
                                            {{ number_format(auth()->user()->investidor->carteira, 2, ',', '.') }}</span>
                                    </div>
                                    <div class="w-1/2 bg-[#DADADA] ml-2 text-center py-3">
                                        Lance mínimo: <span class="text-red">R$ {{ number_format($lance->valor, 2, ',', '.') }}</span>
                                    </div>
                                </div>
                                <div class="grid justify-items-center pb-5">
                                    <div class="justify-items-start mt-10">
                                        <div>
                                            <label for="valor">Valor do lance <span class="text-red">*</span></label>
                                        </div>
                                        <div>
                                            <img src=" {{ asset('img/dolar.svg') }} "
                                                alt="icone de dinheiro"
                                                class="h-10">
                                            <input max="{{ auth()->user()->investidor->carteira }}"
                                                type="text"
                                                name="valor"
                                                id="valor"
                                                value="{{ old('valor', $lance->valor) }}"
                                                class="bg-fundo border-x-0 border-t-0 border-b-2 mb-2">
                                                @error('valor')
                                                    <p class="text-xs text-red text-center">{{$message}}</p>
                                                @enderror
                                            </div>
                                        @if ($lance->valor > auth()->user()->investidor->carteira)
                                            <div class="mx-2 text-left text-red w-72">
                                                Você não possui o valor mínimo na carteira para fazer um lance.
                                                <a href="#">Compre mais AnjoCoins aqui</a>
                                            </div>
                                        @endif
                                    </div>
                                    <button id="salvar" type="submit"
                                        class="mt-12 mb-3 btn btn-success btn-padding w-1/3">Fazer
                                        lance
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    {{--<div id="collapseExample" class="order-2 order-lg-3 pt-0 px-0 col-lg-3 col-12">
                        <div class="grid justify-center">
                            <div>
                                <h6 class="text-white text-center font-bold mt-3">{{trans_choice('messages.contemplados', $leilao->numero_ganhadores)}}</h6>
                                <div>
                                    @foreach ($leilao->lances()->take($leilao->numero_ganhadores)->get() as $lance)
                                        <div class="flex flex-wrap text-xs">
                                            <div class="w-full flex justify-center mr-12">
                                                <img src="{{asset('img/logo.png')}}" class="w-32" alt="logo">
                                                <img class="rounded-full w-8 h-8 -ml-[80px] mt-[34px]" src="{{ $lance->investidor->user->profile_photo_url }}" alt="foto de {{ $lance->investidor->user->name }}">
                                            </div>
                                            <div class="w-full -mt-5" style="margin-top: -10px">
                                                <div class="flex justify-end text-white">
                                                    <div class="w-1/2">
                                                        <p class="my-0 font-bold">
                                                            {{$lance->investidor->user->name}}
                                                        </p>
                                                        <p class="my-0">
                                                            R$ {{number_format($lance->valor, 2,",",".")}}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>--}}
                </div>
            </div>
        </div>
    </div>
</div>
