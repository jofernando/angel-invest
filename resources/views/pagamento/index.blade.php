<x-app-layout>
    <div class="container index-proposta" style="margin-top: 50px; padding-bottom: 70px;">
        <div class="row titulo-pag">
            <div class="col-md-8">
                <h4>Histórico</h4>
            </div>
            <div class="col-md-4" style="text-align: right;">
                <span class="span-btn-add"><a href="{{route('pagamento.create')}}" class="btn btn-success btn-default btn-padding border">
                    <img src="{{asset('img/dolar-bag.svg')}}" alt="ìcone de adicionar nova produto">Adicionar créditos</a></span>
            </div>
        </div>
        <div class="row">
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
        </div>
        <div class="row mt-4">
            <div class="col-md-3">
                <div class="card text-white bg-success card-carteira ml-3 mb-3" style="max-width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">Quantia de créditos na carteira</h5>
                        <p class="card-text">R$ {{number_format(auth()->user()->investidor->carteira, 2, ',', '.')}}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                @if ($pagamentos->count() > 0)
                <div class="table-responsive mb-5">
                    <table class="table table-striped">
                        <thead class="table-dark default-table-head-color">
                            <tr>
                                <th scope="col">Valor</th>
                                <th scope="col">Data</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pagamentos as $pagamento)
                                <tr>
                                    <td>{{$pagamento->valor}}</td>
                                    <td>{{date('d/m/Y', strtotime($pagamento->created_at))}}</td>
                                    <td>{{$pagamento->transacaoPagamento()}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                    <div class="col-md-12">
                        <div class="p-5 mb-4 bg-light rounded-3">
                            <div class="container-fluid py-5">
                                <h1 class="display-5 fw-bold">Histórico de compras</h1>
                                <p class="col-md-8 fs-4">Seu histórico de transações está vazio. Para efetuar investimentos nos Leilões é necessário adicionar créditos.<a href="{{route('pagamento.create')}}">Clique aqui</a> para adicionar créditos.</p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
