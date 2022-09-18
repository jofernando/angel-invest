<x-app-layout>
    <div class="container mt-3">
        @if(session('success'))
            <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                </symbol>
            </svg>
            <div class="alert alert-success d-flex align-items-center" role="alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
                <div>
                    {{session('success')}}
                </div>
            </div>
        @endif
        @if(session('error'))
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
        <div class="row row-cols-1 row-cols-md-3 g-4">
            @foreach ($planos as $plano)
                <div class="col">
                    <div class="card h-100">
                        <div class="card-body bg-white">
                            <h5 class="card-title">{{ $plano->titulo }}</h5>
                            <p class="card-text">{{ $plano->descricao }}</p>
                        </div>
                        <div class="card-footer d-flex justify-content-between align-items-center">
                            <span>{{ $plano->dias }} dias por R$ {{ $plano->valor }}</span>
                            @auth
                                <button type=button
                                    class="btn btn-default text-white"
                                    @if ($plano->assinaturasAtivasDoUsuarioLogado()->exists()) disabled @endif
                                    data-bs-toggle="modal"
                                    data-bs-target="#confirmarAssinatura{{$plano->id}}">
                                    @if ($plano->assinaturasAtivasDoUsuarioLogado()->exists()) Ativo @else Assinar @endif
                                </button>
                            @else
                                <button type=button
                                    class="btn btn-default text-white"
                                    data-bs-toggle="modal"
                                    data-bs-target="#confirmarAssinatura{{$plano->id}}">Assinar
                                </button>
                            @endauth
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @foreach ($planos as $plano)
        <div class="modal fade"
            id="confirmarAssinatura{{$plano->id}}"
            tabindex="-1"
            aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"
                            id="exampleModalLabel">Confirmar assinatura
                        </h5>
                        <button type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Tem certeza que deseja assinar o plano {{$plano->titulo}} pelo valor de R$ {{$plano->valor}}?
                    </div>
                    <div class="modal-footer">
                        <button type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal">Cancelar
                        </button>
                        <form action="{{route('assinar.plano', $plano->id)}}" method="POST">
                            @csrf
                            <button type="submit"
                                class="btn btn-default text-white">Confirmar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</x-app-layout>
