<div wire:poll class="flex flex-col min-h-screen justify-between w-full items-center bg-gray-10 overflow-hidden" id="componente">
    <div class="flex flex-row w-full px-7 py-4 justify-center items-center bg-gray-10 z-50 shadow">
        {{-- <a href="#"  class="cursor-pointer transform duration-150 active:scale-95">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-25" viewBox="0 0 20 20 " fill="currentColor">
                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
            </svg>
        </a> --}}
        <div class="flex flex-col items-center">
            <img class="rounded-full h-8 w-8" src="{{ $usuarioChat->profile_photo_url }}" />
            <span class="text-gray-75 text-xs font-bold mt-2">{{ $usuarioChat->name }}</span>
        </div>
        <div></div>
    </div>
    <div class="px-7 h-chat overflow-y-scroll w-full" id="chat">
            @foreach ($mensagens as $mensagem)
                <div class="flex flex-col flex-1 w-full observar" id="{{$mensagem->id}}">
                    @if ($mensagem->destinatario_id == $usuarioLogado->id)
                        <div class="flex flex-row w-full mt-4 ">
                            <div class="flex flex-row w-full items-center">
                                <div class="flex flex-col bg-gray-200 rounded p-2 mr-12">
                                    <span class="text-xs text-gray-75 break-all">{{ $mensagem->conteudo }}</span>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if ($mensagem->remetente_id == $usuarioLogado->id)
                        <div class="flex flex-row w-full mt-4 ">
                            <div class="flex flex-row w-full justify-end">
                                <div class="flex flex-col bg-[#35abf5] rounded p-2 ml-12">
                                    <span class="text-xs text-white break-all">{{ $mensagem->conteudo }}</span>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            @endforeach
    </div>
    <div class="flex flex-row w-full bg-gray-10 bottom-0 p-7">
        <div class="w-full flex flex-col items-end justify-center">
            <input wire:keydown.enter="enviarMensagem"
                wire:model="texto"
                class="placeholder-gray-65 py-1 pl-4 pr-14 rounded-full w-full bg-gray-35 border border-gray-65"
                placeholder="Digite uma mensagem"
            />
            <button
                wire:click="enviarMensagem"
                class="bg-transparent text-sm text-gray-65 absolute mr-2"
            >
                Enviar
            </button>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        var element = document.getElementById('componente');
                element.scrollIntoView(false);
        window.addEventListener('scrollToEnd', event => {
            scrollToEnd();
        });

        window.addEventListener('scrollToMensagem', event => {
            var ultimaLida = @js($ultimaLida);
            Livewire.emit('desativarRolagem');
            if(ultimaLida) {
                var element = document.getElementById(ultimaLida.id);
                element.scrollIntoView(false);
            } else {
                scrollToEnd();
            }
        });

        function scrollToEnd() {
            var d = $('#chat');
            d.scrollTop(d.prop("scrollHeight"));
        }

        function scrollToMensagem(event) {
            console.log(event);
        }

        // define uma instancia de IntersectionObserver
        var intersectionObserver = new IntersectionObserver(onIntersection, {
            root: null,   // o elemento utilizado como viewport
            threshold: .5 // porcentagem do elemento que deve estar visivel para executar a função de callback
        });

        // callback é chamada quando o elemento esta visivel
        function onIntersection(entries, opts) {
            entries.forEach(function (entry){
                if (entry.intersectionRatio > 0) {
                    Livewire.emit('mensagemLida', entry.target.getAttribute('id'));
                }
            });
        }

        // elementos que estão sendo observados
        document.querySelectorAll('.observar').forEach(function (entry){
            intersectionObserver.observe(entry)
        });

        // cria uma nova instância de mutationObserver
        var mutationObserver = new MutationObserver(function(mutations) {
            mutations.forEach(observarNo);
        });

        function observarNo(mutation) {
            mutation.addedNodes.forEach(function(node) {
                if(node.firstElementChild)
                    intersectionObserver.observe(node.firstElementChild)
            })
        }

        // seleciona o nó alvo
        var target = document.querySelector('#chat');

        // configuração do observador:
        var config = { attributes: false, childList: true, characterData: false };

        // passa o nó alvo, bem como as opções de observação
        mutationObserver.observe(target, config);
    </script>
@endpush

