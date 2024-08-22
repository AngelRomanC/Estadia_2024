<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMateriaRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'nombre' => ['required', 'string', 'max:255'],
            'clave' => ['required', 'string', 'max:255', 'unique:materias,clave'],
            'cuatrimestre' => ['required', 'int'],
            'tipo' => ['required', 'string', 'max:255'],
            'No_horas_presenciales' => ['required', 'int'],
            'No_horas_no_presenciales' => ['required', 'int'],
            'periodo'=> ['required', 'string', 'max:255'],
            'nivel'=> ['required', 'string', 'max:255'],
            
        ];
    }

    public function messages()
    {
        return [
            'nombre.required' => 'El campo nombre es obligatorio.',
            'clave.required' => 'El campo clave es obligatorio.',
            'clave.unique' => 'Clave ya existente.',
            'cuatrimestre' => 'El campo cuatrimestre es obligatorio.',
            'tipo.required' => 'El campo tipo es obligatorio.',
            'No_horas_presenciales.required' => 'El campo de numero de horas presenciales es obligatorio.',
            'No_horas_no_presenciales.required' => 'El campo de numero de horas no presenciales es obligatorio.',
            'periodo.required' => 'El campo periodo  es obligatorio.',
            'cuatrimestre.required' => 'El campo Cuatrimestre es obligatorio.',
            'nivel.required.required' => 'El campo nivel es obligatorio.',
           
        ];
    }
}
