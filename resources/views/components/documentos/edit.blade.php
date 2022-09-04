<div class="card-feature">
    <div class="col-md-12 div-form" style="margin-top: 0px;">
        <div class="row" style="margin-top: 10px; margin-bottom: 10px;">
            <div class="col-md-6">
                <span class="span-btn-add" id="btn-adicionar-escolhar" onclick="addDoc()">
                  <a class="btn btn-success btn-default btn-padding border">
                    <img src="{{asset('img/add-document.svg')}}" alt="">
                    Novo documento
                  </a>
                </span>
            </div>
            <div class="col-md-6">
                <p class="text-right"><span style="color: red">*</span> Campos obrigatórios</p>
            </div>
        </div>
        <div class="row">
            <p>
                Anexe alguns documentos que comprovem a existência e legalidade da startup.
                Estes documentos ficarão públicos durante a exibição do produto para investidores e outros empreendedores.
            </p>
        </div>
        <form method="POST" action="{{route('documentos.update', ['startup' => $startup])}}" enctype="multipart/form-data" class="form-envia-documentos">
            @csrf
            @method('PUT')
            <div class="container" style="margin-top: 15px; margin-bottom: 15px;">
                <div class="row">
                    <div class="col-md-12">
                        Anexe um novo arquivo se deseja modificar o arquivo atual do documento.
                    </div>
                </div>
                <div id="docs" class="col-sm-12 form-group">
                    @if(old('nomes') != null)
                        <input type="hidden" id="docs_indice" value="{{count(old('nomes'))-1}}">
                    @else
                        <input type="hidden" id="docs_indice" value="{{$documentos->count()-1}}">
                    @endif
                    @foreach ($documentos as $i => $doc)
                        <div class="row" @if($i > 0) style="margin-top: 10px;" @endif>
                            <input type="hidden" name="docsID[]" value="{{$doc->id}}">
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label for="nomes" class="form-label ">{{$doc->nome}}</label>
                                    <a href="{{route('documento.arquivo', ['documento' => $doc->id])}}" target="_blank"><img src="{{asset('img/file-pdf-solid.svg')}}" alt="documento {{$doc->nome}}" style="width: 16px;"></a>
                                    <input name="nomes[]" type="text" class="form-control @error('nomes. '.$i) is-invalid @enderror" placeholder="Digite um novo nome para o documento aqui..." value="{{old('nomes.'.$i, $doc->nome)}}">
                                    @error('nomes.'. $i)
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-12" >
                                <label class="label-input" for="enviar_arquivo_{{$i}}"></label>
                                <label for="label-input-arquivo" for="enviar_arquivo_{{$i}}" >Nenhum arquivo selecionado</label>
                                <input id="enviar_arquivo_{{$i}}" name="documentos[]" type="file" onchange="trocarNome(this)" class="input-enviar-arquivo @error('documentos.'.$i) is-invalid @enderror" accept=".pdf" >
                                @if($i > 0)
                                    <a  onclick="this.parentElement.parentElement.remove()" style="margin-top: 10px; cursor: pointer">
                                        <img width="20px;" src="{{asset('img/trash.svg')}}"  alt="Apagar" title="Apagar">
                                    </a>
                                @endif
                                @error('documentos.' . $i)
                                    <div id="validationServer03Feedback" class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    @endforeach
                    @if(old('nomes') != null)
                        @foreach (old('nomes') as $i => $doc)
                            @if($i > $documentos->count()-1)
                                <div class="row" @if($i > 0) style="margin-top: 10px;" @endif>
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label for="nomes" class="form-label ">{{$doc}}</label>
                                            <input name="nomes[]" type="text" class="form-control @error('nomes. '.$i) is-invalid @enderror" placeholder="Digite um novo nome para o documento aqui..." value="{{old('nomes.'.$i, $doc)}}">
                                            @error('nomes.'. $i)
                                                <div id="validationServer03Feedback" class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-12" >
                                        <label class="label-input" for="enviar_arquivo_{{$i}}"></label>
                                        <label for="label-input-arquivo" for="enviar_arquivo_{{$i}}" >Nenhum arquivo selecionado</label>
                                        <input id="enviar_arquivo_{{$i}}" name="documentos[]" type="file" onchange="trocarNome(this)" class="input-enviar-arquivo @error('documentos.'.$i) is-invalid @enderror" accept=".pdf">
                                        @if($i > 0)
                                            <a  onclick="this.parentElement.parentElement.remove()" style="margin-top: 10px; cursor: pointer">
                                                <img width="20px;" src="{{asset('img/trash.svg')}}"  alt="Apagar" title="Apagar">
                                            </a>
                                        @endif
                                        @error('documentos.' . $i)
                                            <div id="validationServer03Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @endif

                </div>
            </div>
            <div class="row" style="margin-top: 10px; margin-bottom: 20px;">
                <div class="grid justify-items-center">
                    <button id="submitForm" type="submit" class="btn btn-secondary btn-padding border w-80 bg-verde submit-form-btn">Salvar</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    function addDoc() {
        var indice = document.getElementById("docs_indice");
        var doc_indice = parseInt(document.getElementById("docs_indice").value) + 1;
        indice.value = doc_indice;
        var doc = `<div class="row" style="margin-top: 10px;">
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="nomes" class="form-label ">Nome do documento<span style="color: red;">*</span></label>
                                <input name="nomes[]" type="text" class="form-control" placeholder="Digite o nome do documento aqui..." required>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <label class="label-input" for="enviar_arquivo_`+ doc_indice+ `"></label>
                            <label for="label-input-arquivo" for="enviar_arquivo_`+ doc_indice+`">Nenhum arquivo selecionado</label>
                            <input id="enviar_arquivo_`+ doc_indice+ `" name="documentos[]" type="file" class="input-enviar-arquivo" accept=".pdf" onchange="trocarNome(this)">
                            <a  onclick="this.parentElement.parentElement.remove()" style="margin-top: 10px; cursor: pointer">
                                <img width="20px;" src="{{asset('img/trash.svg')}}"  alt="Apagar" title="Apagar">
                            </a>
                        </div>
                    </div>`;
        $('#docs').append(doc);
    }
    function trocarNome(botao) {
        var label = botao.parentElement.children[1];
        if(botao.files[0]){
            const fileSize = botao.files[0].size / 1024 / 1024;
            if(fileSize > 5){
                alert("O arquivo deve ter no máximo 5MB!");
                this.value = "";
                label.textContent = editar_caminho("Nenhum arquivo selecionado");
            }
            else{
                label.textContent = editar_caminho($(botao).val());
            }
        }
    }
</script>

<script>
    $("form").submit(function() {
        var elements = document.getElementsByClassName("input-enviar-arquivo");
        for(let i=0; i < elements.length; i++){
            if(!elements[i].files[0]){
                alert("Anexe o .pdf para "+elements[i].parentElement.parentElement.children[0].children[0].children[1].value);
                return false
            }
        }
        return true;
    });
</script>

<script>

    function editar_caminho(string) {
        return string.split("\\")[string.split("\\").length - 1];
    }
</script>
