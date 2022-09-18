<x-app-layout>
    <div class="container index-proposta" style="margin-top: 50px; padding-bottom: 70px;">
        <div class="row titulo-pag">
            <div class="col-md-8">
                <h4>Exposições de produtos</h4>
            </div>
            <div class="col-md-4" style="text-align: right;">
                <span class="span-btn-add"><a href="{{route('leilao.create')}}" class="btn btn-success btn-default btn-padding border"> <img src="{{asset('img/dolar-bag.svg')}}" alt="ìcone de adicionar nova produto"> Criar uma exibição do produto</a></span>
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
            @if ($leiloes->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead class="table-dark default-table-head-color">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Produto</th>
                                <th scope="col">Periodo</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($leiloes as $leilao)
                                <tr>
                                    <th scope="col">{{$leilao->id}}</th>
                                    <td><a href="{{route('propostas.show', ['startup' => $leilao->proposta->startup, 'proposta' => $leilao->proposta])}}">{{$leilao->proposta->titulo}}</a></td>
                                    <td>De {{date('d/m/Y', strtotime($leilao->data_inicio))}} até {{date('d/m/Y', strtotime($leilao->data_fim))}}</td>
                                    <td><a class="btn btn-success btn-default btn-padding border" href="{{route('leilao.edit', $leilao)}}"><img src="{{asset('img/edit.svg')}}" alt="Icone de editar exibição do produto">Editar</a><button id="btnmodaldelete{{$leilao->id}}" class="btn btn-danger btn-padding border" data-bs-toggle="modal" data-bs-target="#moda-delete-leilao-{{$leilao->id}}"> <img src="{{asset('img/trash-white.svg')}}" alt="Icone de deletar exibição do produto" style="height: 20px;"> Deletar</button></td>
                                </tr>

                                <div class="modal fade" id="moda-delete-leilao-{{$leilao->id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header" style="background-color: #dc3545;">
                                            <h5 class="modal-title" id="staticBackdropLabel" style="color: white;">Confirmação</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="form-deletar-proposta-{{$leilao->id}}" method="POST" action="{{route('leilao.destroy', $leilao)}}">
                                                @csrf
                                                @method('DELETE')
                                                Tem certeza que deseja deletar a exibição #{{$leilao->id}} do produto {{$leilao->proposta->titulo}}?
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary btn-padding border" data-bs-dismiss="modal">Cancelar</button>
                                            <button id="btnmodaldeleteform{{$leilao->id}}" type="submit" class="btn btn-danger btn-padding border" form="form-deletar-proposta-{{$leilao->id}}">Deletar</button>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="col-md-12">
                    <div class="p-5 mb-4 bg-light rounded-3">
                        <div class="container-fluid py-5">
                            <h1 class="display-5 fw-bold">Exposições de produtos</h1>
                            <p class="col-md-8 fs-4">Para que seu produto seja exposto aos investidores é necessário criar uma exibição do produto. <a href="{{route('leilao.create')}}">Clique aqui</a> para criar um exibição do produto.</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
