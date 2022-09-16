<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PropostaRequest extends FormRequest
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
            'título'            => 'required|max:255',
            'vídeo_do_pitch'    => 'required|file|max:102400|mimes:mp4,mkv',
            'thumbnail'         => 'required|file|max:5120|mimes:png,jpg',
            'descrição'         => 'required|max:4000000000',
        ];
    }
}
