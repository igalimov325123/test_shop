<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;

class CategoryStoreRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255']
        ];
    }

    public function messages()
    {
        return [
            'name.required'         => 'Название обязательно для заполнения',
            'name.string'           => 'Название должно быть строкой',
            'name.max'              => 'максимальное количество символов в названии - 255',
        ];
    }
}
