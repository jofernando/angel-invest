<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PagamentoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "valor"=>["required","min:0.01","max:100000000000"],
            "n_cartao"=>["required","max:20","min:16"],
            "nome"=>["required","max:255", "min:10"],
            "mes"=>["required","max:2","min:1"],
            "ano"=>["required","max:4","min:4"],
            "cvv"=>["required","min:3","max:3"],
            "telefone"=>["required","max:20","min:15"],
            "cep"=>["required","max:9", "min:9"],
            "bairro"=>["required","max:255"],
            "rua"=>["required","max:255"],
            "numero"=>["required","min:1","max:10"],
            "estado"=>["required"],
            "cidade"=>["required"],
            "senderHash"=>["required"],
            "band_cartao"=>["required"],
            "token_cartao"=>["required"],
        ];
    }
    public function messages()
    {
        return [
            'valor.required' => 'O valor é obrigatório.',
            'valor.max' => 'O valor máximo é 100 bilhões.',
            'valor.min' => 'O valor deve ser superior a um centavo.',
            'n_cartao.required' => 'O número do cartão é obrigatório.',
            'n_cartao.max' => 'Número do cartão deve conter 16 digítos.',
            'n_cartao.min' => 'Número do cartão deve conter 16 digítos.',
            'mes.required'=> 'Campo mês é obrigatório.',
            'ano.required'=> 'Campo ano é obrigatório.',
            'cvv.required' => 'O Código de segurança (CVV) é obrigatório.',
            'cvv.max' => 'O Código de segurança (CVV) deve conter 3 números.',
            'cvv.min' => 'O Código de segurança (CVV) deve conter 3 números.',
            'telefone.required'=> 'Campo telefone é obrigatório.',
            'cep.required'=> 'Campo CEP é obrigatório.',
            'cep.max' => 'O CEP deve conter 9 números.',
            'cep.min' => 'O CEP deve conter 9 números.',
            'bairro.required'=> 'Campo bairro é obrigatório.',
            'bairro.max' => 'O nome da bairro deve conter máximo 255 caracteres.',
            'rua.required'=> 'Campo rua é obrigatório.',
            'rua.max' => 'O nome da rua deve conter máximo 255 caracteres.',
            'numero.required'=> 'Campo número é obrigatório.',
            'numero.max' => 'O número deve conter máximo 10 caracteres.',
            'numero.min' => 'O número deve conter minimo 1 caractere.',
            'estado.required'=> 'Campo estado é obrigatório.',
            'cidade.required'=> 'Campo cidade é obrigatório.',
            'senderHash.required'=>'Algo aconteceu de errado, por favor tente novamente mais tarde.',
            'band_cartao.required'=>'Algo aconteceu de errado, por favor tente novamente mais tarde.',
            'token_cartao.required'=>'Algo aconteceu de errado, por favor tente novamente mais tarde.',
        ];
    }
    public function prepareForValidation()
    {
        $this->whenFilled('valor', function ($input) {
            $this->merge([
                'valor' => str_replace(['.', ','], ['', '.'], $input),
            ]);
        });
    }
}
