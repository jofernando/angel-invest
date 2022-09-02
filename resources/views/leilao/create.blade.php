<x-app-layout>
    <div class="container" style="margin-top: 50px;">
        <div class="card card-feature">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 div-checks">
                        <div class="row mb-4 mt-4" style="text-align: center;">
                            <div class="col-md-12">
                                <a href="{{route('leilao.index')}}" class="btn btn-success btn-padding border"><img src="{{asset('img/back.svg')}}" alt="Icone de voltar" style="padding-right: 5px; height: 22px;"> Voltar</a>
                            </div>
                        </div>
                        <div class="row">
                            <h4 class="card-title" style="font-size: 22px;">Adicionando novo leilão</h5>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                @error('leilao_existente')
                                    <div class="alert alert-danger" role="alert">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8 div-form">
                        <form class="form-envia-documentos" method="POST" action="{{route('leilao.store')}}" enctype="multipart/form-data">
                            @csrf
                            <div class="container" style="margin-top: 15px; margin-bottom: 15px;">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h2>Criando um novo leilão</h2>
                                    </div>
                                </div>
                                <div class="row" style="text-align: right;">
                                    <div class="col-md-8"></div>
                                    <div class="col-md-4">
                                        <label><span style="color: red;">*</span> Campo obrigatório</label>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label for="produto_do_leilão" class="form-label ">Produto do leilão <span style="color: red;">*</span></label>
                                        <select name="produto_do_leilão" id="produto_do_leilão" class="form-control @error('produto_do_leilão') is-invalid @enderror" >
                                            <option value="" selected disabled>-- Selecione um produto --</option>
                                            @foreach ($produtos as $produto)
                                                @if($produto_parametro)
                                                    <option @if(old('produto_do_leilão') == $produto->id || $produto->id == $produto_parametro->id) selected @endif value="{{$produto->id}}">{{$produto->titulo}}</option>
                                                @else
                                                    <option @if(old('produto_do_leilão') == $produto->id) selected @endif value="{{$produto->id}}">{{$produto->titulo}}</option>
                                                @endif
                                            @endforeach
                                        </select>

                                        @error('produto_do_leilão')
                                            <div id="validationServer03Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label for="valor_mínimo" class="form-label ">Valor mínimo do lance <span style="color: red;">*</span></label>
                                        <input id="valor_mínimo" name="valor_mínimo" type="text" class="form-control dinheiro @error('valor_mínimo') is-invalid @enderror" placeholder="0,00" required value="{{old('valor_mínimo')}}">

                                        @error('valor_mínimo')
                                            <div id="validationServer03Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label for="número_de_ganhadores" class="form-label ">Número de ganhadores <span style="color: red;">*</span></label>
                                        <input id="número_de_ganhadores" name="número_de_ganhadores" type="number" class="form-control @error('número_de_ganhadores') is-invalid @enderror" placeholder="1" required value="{{old('número_de_ganhadores')}}">

                                        @error('número_de_ganhadores')
                                            <div id="validationServer03Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="data_de_início" class="form-label ">Data de início do leilão <span style="color: red;">*</span></label>
                                        <input id="data_de_início" name="data_de_início" type="date" class="form-control @error('data_de_início') is-invalid @enderror" required value="{{old('data_de_início')}}" onchange="calcularValorTaxa()">

                                        @error('data_de_início')
                                            <div id="validationServer03Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="data_de_fim" class="form-label ">Data de fim do leilão <span style="color: red;">*</span></label>
                                        <input id="data_de_fim" name="data_de_fim" type="date" class="form-control @error('data_de_fim') is-invalid @enderror" required value="{{old('data_de_fim')}}" onchange="calcularValorTaxa()">

                                        @error('data_de_fim')
                                            <div id="validationServer03Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="termo_de_porcentagem_do_produto" class="form-label ">Termo de resposabilidade e compromisso com a porcetagem do produto <span style="color: red;">*</span></label>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="label-input" for="termo"></label>
                                        <label for="termo" >Nenhum arquivo selecionado</label>
                                        <input id="termo" name="termo_de_porcentagem_do_produto" onchange="trocarNome(this)" type="file" class="input-enviar-arquivo @error('termo_de_porcetagem') is-invalid @enderror" accept=".pdf">

                                        @error('termo_de_porcentagem_do_produto')
                                            <div class="alert alert-danger" role="alert">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-md-12">
                                        <input type="checkbox" name="taxa" id="taxa" required @if(old('taxa')) selected @endif>
                                        <label for="taxa" class="form-label"> Eu concordo com a cobrança da taxa no valor de <span id="valor_taxa" class="text-red">R$ ??</span> para expor o meu produto!
                                        </label>
                                        @error('taxa')
                                            <div class="alert alert-danger" role="alert">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mt-4" style="text-align: center;">
                                    <div class="col-md-12">
                                        <button id="salvar" class="btn btn-success submit-form-btn" style="width: 40%;">Salvar</button>
                                    </div>
                                </div>

                            </div>
                        </form>
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
        $(document).ready(function(){
            $('.dinheiro').mask('#.##0,00', {reverse: true});
        });

        function trocarNome(botao) {
            var label = botao.parentElement.children[1];
            if(botao.files[0]){
                label.textContent = editar_caminho($(botao).val());
            }
        }

        function editar_caminho(string) {
            return string.split("\\")[string.split("\\").length - 1];
        }

        function calcularValorTaxa() {
            const data_inicio = document.getElementById('data_de_início');
            const data_fim = document.getElementById('data_de_fim');
            if(data_inicio.value && data_fim.value){
                $.ajax({
                    url:"{{route('leilao.valor.ajax')}}",
                    type:"get",
                    data:{"data_de_início": data_inicio.value, "data_de_fim": data_fim.value},
                    dataType:'json',
                    success: function(resposta) {
                        if(resposta.valor == null){
                            console.log('nulo');
                            let alerta = `<div class="col-md-12">
                                            <div class="alert alert-danger" role="alert">
                                                <p>O intervalo deve ser menor que 178 dias.</p>
                                            </div>
                                        </div>`;
                            $("#taxa").parent().parent().append(alerta);
                        }else{
                            $("#valor_taxa")[0].textContent = "R$ "+resposta.valor;
                        }
                    }
                });
            }
        }

    </script>
</x-app-layout>
