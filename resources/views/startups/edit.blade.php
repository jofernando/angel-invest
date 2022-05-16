<x-app-layout>
    <div class="container" style="margin-top: 30px;">
        <div class="row titulo-pag">
            <div class="col-md-8">
                <h4><a class="link-default" href="{{route('startups.index')}}">Minhas startups</a> > <a class="link-default" href="{{route('startups.show', $startup)}}">{{mb_strimwidth($startup->nome, 0, 30, "...")}}</a> > Editando informações básicas </h4>
            </div>
        </div>
        <div class="card card-feature" style="margin-top:25px;">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 div-checks">
                        <div class="row mb-4 mt-4" style="text-align: center;">
                            <div class="col-md-12">
                                <a href="{{route('startups.show', $startup)}}" class="btn btn-success btn-padding border"><img src="{{asset('img/back.svg')}}" alt="Icone de voltar" style="padding-right: 5px; height: 22px;"> Voltar</a>
                            </div>  
                        </div>
                        <div class="row">
                            <div id ="left-div-create" class="col-md-12">
                                <div class="row">
                                    <div class="col-md-12 side-titulo"  style="text-align: center">
                                        Editando informações de {{$startup->nome}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8 div-form">
                        <div class="card-body">
                            <div style="margin-top: 15px; margin-bottom: 15px;">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h3 id="titulo-etapa" class="card-title">Informações básicas</h3>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="bg-[#F3F3F3]">
                                            <div class="row" style="text-align: right;">
                                                <div class="col-md-8"></div>
                                                <div class="col-md-4">
                                                    <label><span style="color: red;">*</span> Campo obrigatório</label>
                                                </div>
                                            </div>
                                            <form action="{{ route('startups.update', $startup) }}"
                                                enctype="multipart/form-data"
                                                method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="pb-3">
                                                    <label class="form-label pb-2" for="nome">Nome <span class="text-red">*</span></label>
                                                    <input type="text"
                                                        class="form-control border-ternary h-11 @error('nome') is-invalid @enderror"
                                                        id="nome"
                                                        name="nome"
                                                        value="{{ old('nome', $startup->nome) }}"
                                                        placeholder="Insira o nome da startup aqui...">
                                                        @error('nome')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                </div>
                                                <div class="pb-3">
                                                    <label class="form-label pb-2" for="descricao">Descrição <span class="text-red">*</span></label>
                                                    <small class="ps-4 ms-3">Forneça uma breve descrição da sua startup</small>
                                                    <textarea name="descricao"
                                                        id="descricao"
                                                        class="form-control border-ternary @error('descricao') is-invalid @enderror"
                                                        cols="30"
                                                        rows="3">{{ old('descricao', $startup->descricao) }}</textarea>
                                                        @error('descricao')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                </div>
                                                <div class="row">
                                                    <div class="pb-3 col-6">
                                                        <label class="form-label pb-2" for="cnpj">CNPJ</label>
                                                        <input type="text"
                                                            class="form-control border-ternary h-11 @error('cnpj') is-invalid @enderror"
                                                            id="cnpj"
                                                            name="cnpj"
                                                            value="{{ old('cnpj', $startup->cnpj) }}"
                                                            placeholder="Digite aqui o CNPJ da startup...">
                                                            @error('cnpj')
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                    </div>
                                                    <div class="pb-3 col-6">
                                                        <label class="form-label pb-2" for="area">Área <span class="text-red">*</span></label>
                                                        <select id="area"
                                                            name="area"
                                                            class="form-select border-ternary h-11 @error('area') is-invalid @enderror">
                                                            <option selected disabled hidden>Selecione a área que mais se aproxima da sua startup...</option>
                                                            @foreach ($areas as $id => $area)
                                                                <option value="{{ $id }}"
                                                                    {{ old('area', $startup->area->id) == $id ? 'selected' : '' }}>
                                                                    {{ $area }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        @error('area')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="pb-3">
                                                    <label class="form-label pb-2" for="email">E-mail <span class="text-red">*</span></label>
                                                    <input type="email"
                                                        class="form-control border-ternary h-11 @error('email') is-invalid @enderror"
                                                        id="email"
                                                        name="email"
                                                        value="{{ old('email', $startup->email) }}"
                                                        placeholder="Digite o email para contato...">
                                                        @error('email')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                </div>
                                                <div class="pb-3">
                                                    <label class="form-label pb-2" for="logo">Logo <span class="text-red">*</span></label>
                                                    <input type="file"
                                                        name="logo"
                                                        class="form-control-file d-none @error('logo') is-invalid @enderror"
                                                        id="logo">
                                                    <div class="w-32 h-32" onclick="$('#logo').click()" style="cursor: pointer">
                                                        <div class="w-full h-full bg-black rounded-full flex items-center justify-center align-middle relative overflow-hidden">
                                                            <img id="logo-display" src="{{ asset('storage/'.$startup->logo) }}" alt="" class="h-28 py-2">
                                                            <div id="desc-logo" class="absolute inset-0 branco-transparente mt-20 h-8">
                                                                <div class="text-xs font-normal text-center opacity-100 text-ternary flex justify-center">
                                                                    <div class="w-3/4">
                                                                        Altere o logo da startup
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @error('logo')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="grid justify-items-center">
                                                    <button type="submit" class="btn btn-secondary btn-padding border w-80 bg-verde submit-form-btn">Salvar</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" style="text-align: left;">
                    <div class="col-md-4"></div>
                    <div class="col-md-8" style="position: relative; left: -22px; padding-right: -200px;">
                        <div class="bottom-form" class="row mt-3" style="margin-left: 10px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $("#cnpj").mask("99.999.999/9999-99");
        function display(input) {
            const [file] = input.files
            if (file) {
                $("#logo-display").attr('src', URL.createObjectURL(file))
            }
        }

        $("#logo").change(function() {
            display(this);
            $('#desc-logo').addClass('d-none');
        });
    </script>
</x-app-layout>
