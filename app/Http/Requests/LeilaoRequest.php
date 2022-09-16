<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use PHPUnit\Framework\Constraint\IsTrue;

class LeilaoRequest extends FormRequest
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
            'taxa' => 'accepted',
            'produto_do_leilão' => 'required|integer',
            'valor_mínimo' => 'required|numeric|min:0.01|max:10000000000',
            'número_de_ganhadores' => 'required|integer|min:1',
            'data_de_início' => 'required|date',
            'data_de_fim' => 'required|date|after:data_de_início',
            'termo_de_porcentagem_do_produto' => 'nullable|file|max:5120|mimes:pdf',
        ];
    }

    public function messages()
    {
        return [
            'valor_mínimo.min' => 'O campo valor minímo deve ser pelo menos :min.',
            'valor_mínimo.max' => 'O campo valor minímo deve ser menor que 10.000.000.000,00.',
            'taxa.accepted' => 'O campo de taxa do valor deve ser marcado.'
        ];
    }

    public function prepareForValidation()
    {
        $this->whenFilled('valor_mínimo', function ($input) {
            $this->merge([
                'valor_mínimo' => str_replace(['.', ','], ['', '.'], $input),
            ]);
        });
    }
}
