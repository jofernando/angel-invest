<nav class="navbar navbar-expand-lg navbar-light bg-light nav-color">
    <div class="container">
        <a class="navbar-brand nav-link-logo" href="{{route('home')}}">
            <img class="img-logo" src="{{asset('img/angelInvestBrancoRecorte.png')}}" alt="Logo da angel invest">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse d-lg-flex justify-content-end" id="navbarSupportedContent">
        <ul class="navbar-nav mb-2 mb-lg-0">
            {{--<li class="nav-item">
                <a class="nav-link" href="#">Investidores-anjo</a>
            </li>--}}
            <li class="nav-item">
                <a class="nav-link" href="{{route('produto.search')}}">Produtos</a>
            </li>
            @auth
                @if(auth()->user()->tipo == 1)
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('startups.index')}}">Minhas startups</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('leilao.index')}}">Meus leilões</a>
                    </li>
                @endif
                @if(auth()->user()->tipo == 2)
                <li class="nav-item">
                    <a class="nav-link" href="{{route('lances')}}">Meus investimentos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('pagamento.index')}}">Carteira</a>
                </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link" href="{{route('chat.index')}}">Mensagens</a>
                </li>
                {{--<li class="nav-item">
                    <a class="nav-link" href="{{route('dashboard')}}">Dashboard</a>
                </li>--}}
                <div class="ml-3 relative">
                    <x-jet-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                <button id="btnperfil" class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                    <img class="h-8 w-8 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                                </button>
                            @else
                                <span class="inline-flex rounded-md">
                                    <button id="btnperfil" type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition">
                                        {{ Auth::user()->name }}

                                        <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </span>
                            @endif
                        </x-slot>

                        <x-slot name="content">
                            <!-- Account Management -->
                            <div class="block px-4 py-2 text-xs text-gray-400">
                                {{ __('Manage Account') }}
                            </div>

                            <x-jet-dropdown-link href="{{ route('profile.show') }}">
                                {{ __('Profile') }}
                            </x-jet-dropdown-link>

                            @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                                <x-jet-dropdown-link href="{{ route('api-tokens.index') }}">
                                    {{ __('API Tokens') }}
                                </x-jet-dropdown-link>
                            @endif

                            <div class="border-t border-gray-100"></div>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}" x-data>
                                @csrf

                                <x-jet-dropdown-link id="btnsair" href="{{ route('logout') }}"
                                         @click.prevent="$root.submit();">
                                    {{ __('Log Out') }}
                                </x-jet-dropdown-link>
                            </form>
                        </x-slot>
                    </x-jet-dropdown>
                </div>
            @else
                <li class="nav-item">
                    <a class="nav-link" href="#">Sobre</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Contato</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('login')}}">Entrar</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('register')}}">Cadastre-se</a>
                </li>
            @endif
        </ul>
        </div>
    </div>
</nav>
