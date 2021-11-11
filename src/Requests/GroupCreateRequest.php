<?php

namespace AporteWeb\Dashboard\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GroupCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->hasPermission('group-create') || auth()->user()->root;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'        => 'required|string',
            'description' => 'required|string',
        ];
    }
    /**
     * Set name for input to request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'name'        => '<strong>Nombre</strong>',
            'description' => '<strong>Descripción</strong>',
        ];
    }
    /**
     * Set messages validation rules to request.
     *
     * @return array
     */
    public function messages()
    {
        return [];
    }
}
