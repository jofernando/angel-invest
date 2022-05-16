<div class="card-feature">
    <div class="col-md-12 div-form" style="margin-top: 0px;">
        <p class="text-right"><span style="color: red">*</span> Campos obrigatórios</p>
        <form action="{{ route('enderecos.store',$startup) }}"
            enctype="multipart/form-data"
            method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <label for="cep" class="form-label pb-1 mt-2">CEP <span class="text-red">*</span></label>
                    <input type="cep" id="cep" name="cep" class="form-control border-ternary h-11 @error('cep') is-invalid @enderror" value="{{old('cep')}}" required onkeyup="pesquisacep(this.value);">
                    @error('cep')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="bairro" class="form-label pb-1 mt-2">Bairro <span class="text-red">*</span></label>
                    <input type="text" id="bairro" name="bairro" class="form-control border-ternary h-11 @error('bairro') is-invalid @enderror" value="{{old('bairro')}}" required>
                    @error('bairro')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="rua" class="form-label pb-1 mt-2">Rua <span class="text-red">*</span></label>
                    <input type="text" id="rua" name="rua" class="form-control border-ternary h-11 @error('rua') is-invalid @enderror" value="{{old('rua')}}" required>
                    @error('rua')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="numero" class="form-label pb-1 mt-2" >Número <span class="text-red">*</span></label>
                    <input type="numero" id="numero" name="numero" class="form-control border-ternary h-11 @error('numero') is-invalid @enderror" value="{{old('numero')}}" required>
                    @error('numero')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="estado" class="form-label pb-1 mt-2">Estado <span class="text-red">*</span></label>
                    <select id="estado" name="estado" class="form-control border-ternary h-11 @error('estado') is-invalid @enderror" value="{{old('estado')}}" required onchange="buscaCidades(this.value)">
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
                    <select id="cidade" name="cidade" class="form-control border-ternary h-11 @error('cidade') is-invalid @enderror" value="{{old('cidade')}}" required></select>
                    @error('cidade')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <label for="complemento" class="form-label pb-1 mt-2" >Complemento</label>
                    <textarea name="complemento" id="complemento" class="form-control border-ternary  @error('complemento') is-invalid @enderror" cols="30" rows="5">{{old('complemento')}}</textarea>
                    @error('complemento')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="row" style="margin-top: 10px; margin-bottom: 20px;">
                <div class="grid justify-items-center">
                    <button type="submit" class="btn btn-secondary btn-padding border w-80 bg-verde submit-form-btn">Salvar</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script src="{{ asset('js/estado-cidade.js') }}"></script>
