<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLanceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->tipo == 2;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $leilao = $this->route('leilao');
        $min = $leilao->valor_minimo;
        $max = auth()->user()->investidor->carteira;
        return [
            'valor' => ['required', 'numeric', "min:$min", "max:$max"],
        ];
    }

    public function messages()
    {
        $leilao = $this->route('leilao');
        $min = number_format($leilao->valor_minimo, 2,",",".");
        $max = number_format(auth()->user()->investidor->carteira, 2,",",".");
        return [
            'valor.min' => "O valor da oferta não pode estar abaixo do valor mínimo que é {$min}",
            'valor.max' => "Você não possui AnjoCoins suficientes para realizar a oferta",
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $valor_sem_ponto = str_replace('.', '', $this->valor);
        $valor_com_ponto = str_replace(',', '.', $valor_sem_ponto);
        $this->merge([
            'valor' => floatval($valor_com_ponto),
        ]);
    }
}
