<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('Users')->ignore($this->id)],
            //'agency_id' => 'required|exists:agencies,id',
            'agency_id' => 'required',
            'status'      => 'required',
            'phone_number' => 'required|digits:10',
            'percentage'   => 'max:255',
            'photo'        => 'sometimes|max:255'
        ];
    }
    public function attributes(): array
    {
        return [
            'name' => 'Nombre',
            'email' => 'Correo electrónico',
            'password' => 'Contraseña',
            'agency_id' => 'Agencia',
            'status' => 'Estado',
            'phone_number' => 'Telefono',
            'percentage' => 'Porcentaje',
            'photo'     => 'Foto'
        ];
    }
    
}
