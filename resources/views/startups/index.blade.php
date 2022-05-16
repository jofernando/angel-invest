<x-app-layout>
    <div class="container index-proposta" style="margin-top: 50px; padding-bottom: 100px;">
        <div class="row titulo-pag">
            <div class="col-md-6">
                <h4>Minhas startups </h4>
            </div>
            <div class="col-md-6" style="text-align: right;">
                <span class="span-btn-add">
                  <a href="{{route('startups.create')}}" class="btn btn-success btn-default btn-padding border">
                    <img src="{{asset('img/bi_plus-circle.png')}}" alt="">
                    <img src="{{asset('img/Vector.png')}}" alt="">
                    Adicionar nova startup
                  </a>
                </span>
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
        @elseif(session('error'))
            <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                  </symbol>
            </svg>

            <div class="alert alert-danger d-flex align-items-center" role="alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                <div>
                    {{session('error')}}
                </div>
            </div>
        @endif
        @if ($startups->count() > 0)
            <div class="row mt-4">
                @foreach ($startups as $startup)
                    <div class="col-md-4">
                        <div class="card card-startup mb-3">
                            <div class="card-header" style="transform: rotate(0);">
                                <div class="row">
                                    <div class="col-md-5" style="text-align: center;">
                                        <img class="img-circle" src="@if($startup->logo != null){{asset('storage/'.$startup->logo)}}@else{{asset('img/empresa-logo.svg')}}@endif" alt="Logo startup">
                                    </div>
                                    <div class="col-md-7">
                                        <div class="row mt-2">
                                            <div class="col-md-12">
                                                <a @if(!is_null($startup->endereco) && !is_null($startup->documentos->first()) && !is_null($startup->telefones->first())) href="{{route('startups.show', $startup)}}" @endif style="text-decoration: none; color: white;"><h5>{{$startup->nome}}</h5></a>
                                                <span class="categoria">{{$startup->area->nome}}</span>
                                            </div>
                                            <div class="col-md-12">
                                                <span class="text-startup" style="color: white;">{{$startup->email}}</span>
                                            </div>
                                            <div class="col-md-12">
                                                @if($startup->telefones->first())
                                                    <span class="text-startup" style="color: white;">{{$startup->telefones->first()->numero}}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @if(!is_null($startup->endereco) && !is_null($startup->documentos->first()) && !is_null($startup->telefones->first()))
                                    <a href="{{route('startups.show', $startup)}}" class="stretched-link"></a>
                                @endif
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-10">
                                        <a  @if(!is_null($startup->endereco) && !is_null($startup->documentos->first()) && !is_null($startup->telefones->first())) href="{{route('propostas.index', $startup)}}" @endif style="text-decoration: none; color: black; font-size: 20px;">Meus Produtos</a>
                                    </div>
                                    @if(is_null($startup->endereco) || is_null($startup->documentos->first()) || is_null($startup->telefones->first()))
                                        <small class="text-red">Conclua o cadastro da startup em <span style="font-weight: bold">Adicionar nova startup</span></small>
                                    @endif
                                    @if ($startup->propostas->count() > 0)
                                        <div class="col-md-2" style="text-align: right;">
                                            <a class="arrow-collapse" data-bs-toggle="collapse" href="#collapse_propostas_{{$startup->id}}" role="button" aria-expanded="false" aria-controls="collapse_propostas_{{$startup->id}}">
                                                <img class="arrow-down" src="{{asset('img/arrow-down.svg')}}" alt="Icone exibir produto">
                                            </a>
                                        </div>
                                    @endif
                                </div>
                                <div class="row mt-2">
                                    @foreach ($startup->propostas as $proposta)
                                        <a href="{{route('propostas.show', ['proposta' => $proposta, 'startup' => $startup])}}" style="text-decoration: none; color: black;">
                                            <div class="col-md-12">
                                                <div class="collapse" id="collapse_propostas_{{$startup->id}}">
                                                    <div class="card card-body mb-3">
                                                        <div class="row">
                                                            <div class="col-md-8">
                                                                <h6>{{mb_strimwidth($proposta->titulo, 0, 20, "...")}}</h6>
                                                                @if ($leilao = $proposta->leilao_atual())
                                                                    <span class="text-proposta"><img class="icon" src="{{asset('img/calendar.svg')}}" alt="Ícone de calendario"> Lances durande: <b>{{date('d/m', strtotime($leilao->data_inicio))}} a {{date('d/m', strtotime($leilao->data_fim))}}</b></span>
                                                                    <span class="text-proposta"><img class="icon" src="{{asset('img/preco.svg')}}" alt="Ícone de lance mínimo"> Lance mínimo: <b>R$ {{number_format($leilao->valor_minimo, 2,",",".")}}</b></span>
                                                                @endif
                                                            </div>
                                                            <div class="col-md-4" style="text-align: center;">
                                                                <div class="row">
                                                                    <img class="icon-investidor" src="{{asset('img/investidor-preto.png')}}" alt="Ícone do investidor">
                                                                </div>
                                                                @if(!is_null($proposta->leiloes->first()))
                                                                    <div class="row">
                                                                        <span class="text-proposta">{{$proposta->leiloes->last()->lances->count()}} @if($proposta->leiloes->last()->lances->count() == 1) investidor @else investidores @endif</span>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="col-md-12">
                <div class="p-5 mb-4 bg-light rounded-3">
                    <div class="container-fluid py-5">
                        <h1 class="display-5 fw-bold">Minhas Startups</h1>
                        <p class="col-md-8 fs-4">Nenhuma startup criada. <a href="{{route('startups.create')}}">Clique aqui</a> para criar sua primeira startup.</p>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <script>
        $(document).ready(function() {
            $('.arrow-collapse').click(function() {
                var img = this.children[0];
                if(this.ariaExpanded == "true") {
                    img.src = "{{asset('img/arrow-up.svg')}}";
                } else if (this.ariaExpanded == "false") {
                    img.src = "{{asset('img/arrow-down.svg')}}";
                }
            });
        });
    </script>
</x-app-layout>
