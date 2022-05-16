<x-app-layout>
    <div class="container" style="margin-top: 50px;">
        <div class="card card-feature">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 div-checks">
                        <div class="row mb-4 mt-4" style="text-align: center;">
                            <div class="col-md-12">
                                <a href="{{route('pagamento.index')}}" class="btn btn-success btn-padding border"><img src="{{asset('img/back.svg')}}" alt="Icone de voltar" style="padding-right: 5px; height: 22px;"> Voltar</a>
                            </div>
                        </div>
                        <div class="row">
                            <h4 class="card-title" style="font-size: 22px;">Adicionando créditos a minha carteira</h5>
                        </div>
                    </div>
                    <div class="col-md-8 div-form">
                        <form class="" method="POST" id="pagamentoForm" action="{{route('pagamento.store')}}">
                            @csrf
                            <div class="container" style="margin-top: 15px; margin-bottom: 15px;">

                                <div class="row">
                                    <div class="col-md-12">
                                        <h3>Adicionando créditos</h3>
                                    </div>
                                </div>
                                <div class="row" style="text-align: right;">
                                    <div class="col-md-8"></div>
                                    <div class="col-md-4">
                                        <label><span style="color: red;">*</span> Campo obrigatório</label>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label for="valor" class="form-label">Valor<span style="color: red;">*</span></label>
                                        <input class="form-control dinheiro @error('valor') is-invalid @enderror" name="valor" id="valor" type="text" value="{{old("valor")}}">

                                        @error('valor')
                                            <div id="validationServer03Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-8">
                                        <label for="n_cartao" class="form-label">Número do cartão<span style="color: red;">*</span></label>
                                        <input class="form-control cartao @error('n_cartao') is-invalid @enderror" name="n_cartao" id="n_cartao" type="text" value="{{old("n_cartao")}}">

                                        @error('n_cartao')
                                            <div id="validationServer03Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="nome" class="form-label">Nome do cartão<span style="color: red;">*</span></label>
                                        <input class="form-control @error('nome') is-invalid @enderror" name="nome" id="nome" type="text" value="{{old("nome")}}">

                                        @error('nome')
                                            <div id="validationServer03Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-3">
                                        <label for="mes" class="form-label">Mês de expiração<span style="color: red;">*</span></label>

                                        <select class="form-control @error('mes') is-invalid @enderror" name="mes" id="mes">
                                            @for ($i=1;$i<=12;$i++)
                                                <option value="{{$i}}">{{$i}}</option>
                                            @endfor
                                         </select>

                                        @error('mes')
                                            <div id="validationServer03Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="col-md-3">
                                        <label for="ano" class="form-label">Ano de expiração<span style="color: red;">*</span></label>
                                        <select class="form-control @error('ano') is-invalid @enderror" name="ano" id="ano">
                                            @for ($i=22;$i<=44;$i++)
                                                <option value="20{{$i}}">20{{$i}}</option>
                                            @endfor
                                         </select>

                                        @error('ano')
                                            <div id="validationServer03Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="cvv" class="form-label">Código de segurança (CVV)
                                            <span style="color: red;">*</span>
                                        </label>
                                        <input class="form-control cvv @error('cvv') is-invalid @enderror" name="cvv" id="cvv" type="text" value="{{old("cvv")}}">

                                        @error('cvv')
                                            <div id="validationServer03Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <h3>Dados adicionais</h3>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <label for="telefone" class="form-label">Telefone
                                            <span style="color: red;">*</span>
                                        </label>
                                        <input class="form-control @error('telefone') is-invalid @enderror" oninput="mascaraTelefone(this);" type="text" name="telefone" id="telefone">
                                        @error('telefone')
                                            <div id="validationServer03Feedback" class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="cep" class="form-label pb-1 mt-2">CEP <span class="text-red">*</span></label>
                                        <input type="cep" id="cep" name="cep" class="form-control  @error('cep') is-invalid @enderror" value="{{old('cep')}}" required onblur="pesquisacep(this.value);">
                                        @error('cep')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="bairro" class="form-label pb-1 mt-2">Bairro <span class="text-red">*</span></label>
                                        <input type="text" id="bairro" name="bairro" class="form-control  @error('bairro') is-invalid @enderror" value="{{old('bairro')}}" required>
                                        @error('bairro')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="rua" class="form-label pb-1 mt-2">Rua <span class="text-red">*</span></label>
                                        <input type="text" id="rua" name="rua" class="form-control  @error('rua') is-invalid @enderror" value="{{old('rua')}}" required>
                                        @error('rua')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="numero" class="form-label pb-1 mt-2" >Número <span class="text-red">*</span></label>
                                        <input type="numero" id="numero" name="numero" class="form-control  @error('numero') is-invalid @enderror" value="{{old('numero')}}" required>
                                        @error('numero')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="estado" class="form-label pb-1 mt-2">Estado <span class="text-red">*</span></label>
                                        <select id="estado" name="estado" class="form-control  @error('estado') is-invalid @enderror" value="{{old('estado')}}" required onchange="buscaCidades(this.value)">
                                            <option value="" disabled selected>--Selecione o estado--</option>
                                            <option value="AC">Acre</option>
                                            <option value="AL">Alagoas</option>
                                            <option value="AP">Amapá</option>
                                            <option value="AM">Amazonas</option>
                                            <option value="BA">Bahia</option>
                                            <option value="CE">Ceará</option>
                                            <option value="DF">Distrito Federal</option>
                                            <option value="ES">Espírito Santo</option>
                                            <option value="GO">Goiás</option>
                                            <option value="MA">Maranhão</option>
                                            <option value="MT">Mato Grosso</option>
                                            <option value="MS">Mato Grosso do Sul</option>
                                            <option value="MG">Minas Gerais</option>
                                            <option value="PA">Pará</option>
                                            <option value="PB">Paraíba</option>
                                            <option value="PR">Paraná</option>
                                            <option value="PE">Pernambuco</option>
                                            <option value="PI">Piauí</option>
                                            <option value="RJ">Rio de Janeiro</option>
                                            <option value="RN">Rio Grande do Norte</option>
                                            <option value="RS">Rio Grande do Sul</option>
                                            <option value="RO">Rondônia</option>
                                            <option value="RR">Roraima</option>
                                            <option value="SC">Santa Catarina</option>
                                            <option value="SP">São Paulo</option>
                                            <option value="SE">Sergipe</option>
                                            <option value="TO">Tocantins</option>
                                        </select>
                                        @error('estado')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="cidade" class="form-label pb-1 mt-2">Cidade <span class="text-red">*</span></label>
                                        <select id="cidade" name="cidade" class="form-control  @error('cidade') is-invalid @enderror" value="{{old('cidade')}}" required></select>
                                        @error('cidade')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                {{-- <div class="row">
                                    <div class="col-md-12">
                                        <label for="complemento" class="form-label pb-1 mt-2" >Complemento</label>
                                        <textarea name="complemento" id="complemento" class="form-control @error('complemento') is-invalid @enderror" cols="30" rows="5">{{old('complemento')}}</textarea>
                                        @error('complemento')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div> --}}
                                <input name="senderHash" id="senderHash" type="hidden" value="">
                                <input name="band_cartao" id="band_cartao" type="hidden" value="">
                                <input name="token_cartao" id="token_cartao" type="hidden" value="">

                                <div class="row mt-4" style="text-align: center;">
                                    <div class="col-md-12">
                                        <button id="submeter" class="btn btn-success submit-form-btn" type="button" style="width: 40%;">Pagar</button>
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
    <script src="{{ asset('js/estado-cidade.js') }}"></script>
    <script>

        PagSeguroDirectPayment.setSessionId('{{ PagSeguro::startSession() }}');

        $(document).ready(function(){
            $('.dinheiro').mask('#.##0,00', {reverse: true});
            $('.cvv').mask('000');
            $('.cartao').mask('0000 0000 0000 0000');

            $('#submeter').click(function(){
                $('#submeter').attr('disabled', 'disabled');
                $('#submeter').html('Aguarde...');
                $('#submeter').attr('backgroundColor', 'd8');
                
                $('#senderHash').val(PagSeguroDirectPayment.getSenderHash());
                get_bandeira();
                consultar_token_cartao();
                setTimeout(submeter_form, 3000);
            });
        });

        function submeter_form(){
            $('#pagamentoForm').submit();
        }

        function consultar_token_cartao() {

            var param = {
                cardNumber: $("#n_cartao").val().replace(/\s/g, ''),
                cvv: $("#cvv").val(),
                expirationMonth: $("#mes").val(),
                expirationYear: $("#ano").val(),
                success: function(response) {
                    console.log(response.card.token);
                    $("#token_cartao").val(response.card.token);
                },
                error: function(response) {
                },
                complete: function(response) {
                }
            }

            if($("#band_cartao").val() != '') {
                param.brand = $("#band_cartao").val();
            }
            PagSeguroDirectPayment.createCardToken(param);
        }

        function bin_cartao() {
            var bin = $('#n_cartao').val();
            bin = bin.replace(/\s/g, '');
            bin = bin.slice(0, 6);
            return bin;
        }

        function get_bandeira() {
           PagSeguroDirectPayment.getBrand({
                cardBin: bin_cartao(),
                success: function(response) {
                    $("#band_cartao").val(response.brand.name);
                },
                error: function(response) {
                },
                complete: function(response) {
                }
            });
        }

        function mascaraTelefone(numero) {
            var behavior = function (val) {
                return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
            },
            options = {
                onKeyPress: function (val, e, field, options) {
                    field.mask(behavior.apply({}, arguments), options);
                }
            };
            $(numero).mask(behavior, options);
        }
    </script>
</x-app-layout>
