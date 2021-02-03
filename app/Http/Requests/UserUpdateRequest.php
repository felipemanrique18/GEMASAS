<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
            'email' => 'required|email',
            'name' => 'max:80',
            'last_name' => 'max:80',
            'state' => 'required|in:1,2,3',
        ];
    }

    public function messages()
{
    return [
        'email.required' => 'Email es requerido',
        'email.email' => 'el Email no es valido',
        'name.max' => 'Nombre muy largo',
        'last_name.max' => 'Nombre muy largo',
        'state.required' => 'El codigo es requerido',
    ];
}

}
