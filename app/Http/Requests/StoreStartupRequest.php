<?php

namespace App\Http\Requests;

use App\Models\Startup;
use Illuminate\Foundation\Http\FormRequest;

class StoreStartupRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('create', Startup::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nome' => ['required', 'string'],
            'descricao' => ['required', 'string'],
            'logo' => ['required', 'image', 'max:10240'],
            'cnpj' => ['nullable', 'cnpj', 'unique:startups,cnpj'],
            'email' => ['required', 'email'],
            'area' => ['required', 'numeric'],
        ];
    }

    /**
     * Get custom attributes for validator errors..
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'descricao' => 'descrição',
            'cnpj' => 'CNPJ',
            'email' => 'e-mail',
            'area' => 'área',
        ];
    }
}
