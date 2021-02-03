<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserCreateRequest extends FormRequest
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
            'document' => 'required',
        ];
    }

    public function messages()
{
    return [
        'document.required' => 'Selecciona un archivo .txt para continuar',
        'document.file' => 'Archivo no valido',
        'body.required' => 'A message is required',
    ];
}

}
