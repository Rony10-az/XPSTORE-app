<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**----------------------------------------------------------------- 
       Esta funcion es para autorizar el request
    -------------------------------------------------------------------*/

    public function authorize(): bool
    {
        return true;
    }
    /**----------------------------------------------------------------- 
       Esta funcion es para obtener las reglas de validacion del request
    -------------------------------------------------------------------*/
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:6'],
        ];
    }
    /**----------------------------------------------------------------------- 
     Esta funcion es para obtener los mensajes personalizados de error de validacion
    ------------------------------------------------------------------------ */
    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'email.required' => 'El correo electrónico es obligatorio',
            'email.email' => 'Debe ser un correo electrónico válido',
            'password.required' => 'La contraseña es obligatoria',
            'password.min' => 'La contraseña debe tener al menos 6 caracteres',
        ];
    }
}
