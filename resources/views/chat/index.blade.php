<x-app-layout>
    <div class="container">
        <div class="titulo-pag">
            <div class="mt-[50px]">
                <h4>Mensagens </h4>
            </div>
        </div>
        <div class="py-10 min-h-screen bg-white px-2">
            <div class="w-full mx-auto bg-slate-300 shadow-lg rounded-lg overflow-hidden ">
                <div class="md:flex">
                    <div class="w-full p-4">
                        <ul class="ps-0">
                            @forelse ($usuarios as $index => $usuario)
                                <a href="{{route('chat', $usuario)}}" class="no-underline">
                                    <li class="flex justify-between items-center bg-white mt-2 p-2 hover:shadow-lg rounded cursor-pointer transition">
                                        <div class="flex ml-2">
                                            <img src="{{$usuario->profile_photo_url}}" width="40" height="40" class="rounded-full">
                                            @if (auth()->user()->mensagensNaoLidas()->where('remetente_id', $usuario->id)->exists())
                                                <span style="font-size: 0.7rem; font-weight: 700; position: relative; top: -5px;">{{auth()->user()->mensagensNaoLidas()->where('remetente_id', $usuario->id)->count()}}</span>
                                            @endif
                                            <div class="flex flex-col ml-2"> <span class="font-medium text-black">{{$usuario->name}}</span> <span class="text-sm text-gray-400 truncate w-32">{{$mensagens->slice($index, 1)->first()->conteudo}}</span> </div>
                                        </div>
                                        <div class="flex flex-col items-center"> <span class="text-gray-300">{{$mensagens->slice($index, 1)->first()->dataHelper()}}</span> <i class="fa fa-star text-green-400"></i> </div>
                                    </li>
                                </a>
                            @empty
                                <div class="flex justify-center text-lg">Nenhuma conversa</div>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
