<x-app-layout>
    <div class="container index-proposta" style="margin-top: 50px; padding-bottom: 70px;">
        <div class="row titulo-pag">
            <div class="col-md-8">
                <h4>Dashboard de entrada de capital na AngelInvest</h4>
                <div class="d-flex align-items-center">
                    <div class="ps-1 mt-0 pt-0" style="font-size: 14px; color: black;">
                        <span style="font-weight: bolder;">Filtrando por:
                            @switch($ordenacao)
                                @case('7_dias')
                                    Últimos 7 dias
                                    @break
                                @case('ultimo_mes')
                                    Últimos 30 dias
                                    @break
                                @case('meses')
                                    Últimos 12 meses
                                    @break
                                @case('anos')
                                    Últimos 5 anos
                                    @break
                                @default
                                Últimos 7 dias
                                    @break
                            @endswitch
                        </span>
                    </div>
                    <div class="dropdown">
                        <button type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img width="35" style="padding-left: 5px; border-radius: 10px" src="{{asset('img/ordenacao.svg')}}" alt="Icone de ordenação de candidatos">
                        </button>
                        <div class="dropdown-menu px-2" aria-labelledby="dropdownMenuButton">
                            <div class="form-check link-ordenacao">
                                <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1" @if($ordenacao == '7_dias') checked @endif>
                                <label class="form-check-label" for="flexRadioDefault1">
                                    Últimos 7 dias
                                </label>
                                <a class="dropdown-item" href="{{route('pagamento.dashboard', ['ordenacao' => '7_dias'])}}"></a>
                            </div>
                            <div class="form-check link-ordenacao">
                                <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" @if($ordenacao == 'ultimo_mes') checked @endif>
                                <label class="form-check-label" for="flexRadioDefault2">
                                    Últimos 30 dias
                                </label>
                                <a class="dropdown-item" href="{{route('pagamento.dashboard', ['ordenacao' => 'ultimo_mes'])}}"></a>
                            </div>
                            <div class="form-check link-ordenacao">
                                <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault3" @if($ordenacao == 'meses') checked @endif>
                                <label class="form-check-label" for="flexRadioDefault3">
                                    Últimos 12 meses
                                </label>
                                <a class="dropdown-item" href="{{route('pagamento.dashboard', ['ordenacao' => 'meses'])}}"></a>
                            </div>
                            <div class="form-check link-ordenacao">
                                <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault4" @if($ordenacao == 'anos') checked @endif>
                                <label class="form-check-label" for="flexRadioDefault4">
                                    Últimos 5 anos
                                </label>
                                <a class="dropdown-item" href="{{route('pagamento.dashboard', ['ordenacao' => 'anos'])}}"></a>
                            </div>
                        </div>
                    </div>
                </div>
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
        <canvas id="myChart"></canvas>
        <div class="row mt-4">
            @if ($collection->count() > 0)
                <h5>Tabela de entrada de capital</h5>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead class="table-dark default-table-head-color">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Data</th>
                                <th scope="col">Valor em R$</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($collection as $i => $pagamento)
                                <tr>
                                    <th scope="col">{{$i}}</th>
                                    <td>@switch($ordenacao)
                                        @case('7_dias')
                                        Dia {{$pagamento->day}}
                                        @break
                                        @case('ultimo_mes')
                                        Dia {{$pagamento->day}}
                                        @break
                                        @case('meses')
                                        Mês {{$pagamento->month}}
                                        @break
                                        @case('anos')
                                        {{$pagamento->year}}
                                        @break
                                    @endswitch</td>
                                    <td>{{number_format($pagamento->sum, 2, ',', '.')}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="col-md-12">
                    <div class="p-5 mb-4 bg-light rounded-3">
                        <div class="container-fluid py-5">
                            <h1 class="display-5 fw-bold">Nehuma compra de crédito foi realizada no período dado</h1>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    @push('scripts')
    <script>
        Chart.register(ChartDataLabels);
            const dados = @json($pagamentos);

            const data = {
                labels: Object.keys(dados),
                datasets: [{
                    data: Object.values(dados),
                    backgroundColor: ['#273746','#F78259', '#581845', '#C70039 ', '#293462', '#1CD6CE', '#D61C4E', '#FEDB39', '#FF5733'],
                    hoverOffset: 0,
                }]
            };
            const options = {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text:  {!! json_encode($titulo) !!},
                    },
                    legend: {
                        display: false,
                    },
                }
            };
            const config = {
                type: 'line',
                data: data,
                options: options,
            };
            const myChart = new Chart(
                document.getElementById('myChart'),
                config
            );

            $('.link-ordenacao').click(function() {
                window.location = this.children[2].href;
            });
    </script>
    @endpush
</x-app-layout>
