<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Fazendo uma oferta para a exibição do produto {{ $leilao->proposta->startup->nome }}</h5>
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
                        <form action="{{route('leiloes.lances.store', ['leilao' => $leilao])}}" method="POST">
                            @csrf
                            <div class="mx-10 mt-12 pt-3">
                                <div class="grid justify-items-end">
                                    <label>
                                        <span class="text-red">*</span>
                                        Campo obrigatório
                                    </label>
                                </div>
                                <div class="bg-[#FFD6D6] text-center py-3 text-[#2F0E0E]">
                                    Faça uma oferta de R$ {{ number_format($leilao->valor_corte(), 2, ',', '.') }} para conseguir o produto
                                </div>
                                <div class="flex mt-3">
                                    <div class="w-1/2 bg-[#DADADA] mr-2 text-center py-3">
                                        Valor na carteira: <span class="text-[#03A000]">R$
                                            {{ number_format(auth()->user()->investidor->carteira, 2, ',', '.') }}</span>
                                    </div>
                                    <div class="w-1/2 bg-[#DADADA] ml-2 text-center py-3">
                                        Valor mínimo: <span class="text-red">R$ {{ number_format($leilao->valor_minimo, 2, ',', '.') }}</span>
                                    </div>
                                </div>
                                <div class="grid justify-items-center">
                                    <div class="justify-items-start mt-10">
                                        <div>
                                            <label for="valor">Valor da oferta <span class="text-red">*</span></label>
                                        </div>
                                        <div>
                                            <img src=" {{ asset('img/dolar.svg') }} "
                                                alt="icone de dinheiro"
                                                class="h-10">
                                            <input max="{{ auth()->user()->investidor->carteira }}"
                                                type="text"
                                                name="valor"
                                                id="valor"
                                                value="{{ old('valor', number_format($leilao->valor_minimo, 2, ',', '.')) }}"
                                                class="bg-fundo border-x-0 border-t-0 border-b-2 mb-2">
                                            @error('valor')
                                                <p class="text-xs text-red text-center">{{$message}}</p>
                                            @enderror
                                        </div>
                                        @if ($leilao->valor_minimo > auth()->user()->investidor->carteira)
                                            <div class="mx-2 text-left text-red w-72">
                                                Você não possui o valor mínimo na carteira para fazer uma oferta.
                                                <a href="#">Compre mais AnjoCoins aqui</a>
                                            </div>
                                        @endif
                                    </div>
                                    <button id="salvar" type="submit"
                                        class="mt-12 mb-3 btn btn-primary btn-padding border bg-verde w-1/3">Fazer
                                        oferta
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
