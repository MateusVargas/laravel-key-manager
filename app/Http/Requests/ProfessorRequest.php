<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfessorRequest extends FormRequest
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
            'nome' => 'required|string',
            'graduacao' => 'required|string',
        ];
    }

    public function messages()
    {
        return[
            'nome.required' => 'Nome é obrigatório',
            'graduacao.required' => 'Graduação é obrigatória'
        ];
    }
}
