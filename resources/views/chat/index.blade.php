<x-app-layout>
    <div class="container">
        <div class="titulo-pag">
            <div class="mt-[50px]">
                <h4>Mensagens </h4>
            </div>
        </div>
        <div class="py-10 min-h-screen bg-white px-2">
            <div class="max-w-md mx-auto bg-gray-100 shadow-lg rounded-lg overflow-hidden md:max-w-lg">
                <div class="md:flex">
                    <div class="w-full p-4">
                        <ul>
                            @foreach ($usuarios as $index => $usuario)
                                <a href="{{route('chat', $usuario)}}" class="no-underline">
                                    <li class="flex justify-between items-center bg-white mt-2 p-2 hover:shadow-lg rounded cursor-pointer transition">
                                        <div class="flex ml-2"> <img src="{{$usuario->profile_photo_url}}" width="40" height="40" class="rounded-full">
                                            <div class="flex flex-col ml-2"> <span class="font-medium text-black">{{$usuario->name}}</span> <span class="text-sm text-gray-400 truncate w-32">{{$mensagens->slice($index, 1)->first()->conteudo}}</span> </div>
                                        </div>
                                        <div class="flex flex-col items-center"> <span class="text-gray-300">{{$mensagens->slice($index, 1)->first()->dataHelper()}}</span> <i class="fa fa-star text-green-400"></i> </div>
                                    </li>
                                </a>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
