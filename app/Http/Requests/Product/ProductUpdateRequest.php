<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductUpdateRequest extends FormRequest
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
            'name'          => ['sometimes', 'string', 'max:255'],
            'description'   => ['nullable', 'string', 'max:500'],
            'price'         => ['sometimes', 'numeric', 'between:0,99999999.99'],
            'categories'    => ['array', 'sometimes', 'min:2', 'max:10'],
            'categories.*'  => ['integer', 'distinct', 'exists:categories,id'],
            'is_published'  => ['nullable', 'boolean'],
            'image'         => ['image', 'nullable'],
        ];
    }

    public function messages()
    {
        return [
            'name.string'           => 'Название должно быть строкой',
            'name.max'              => 'Максимальное количество элементов в названии - 255',

            'description.string'    => 'Описание должно быть строкой',
            'description.max'       => 'Максимальное количество элементов в названии - 500',

            'price.numeric'         => 'Поле "Цена от" должно быть числовым',
            'price.between'         => 'Поле "Цена от" должно быть в диапазоне от 0 до 99999999,99',

            'is_published.boolean'  => 'Поле публикации должно быть типа boolean',

            'categories.array'      => 'Поле категорий должно быть массивом',
            'categories.min'        => 'Минимальное количество элементов закрепляемых категорий - 2',
            'categories.max'        => 'Максимальное количество элементов закрепляемых категорий - 10',
            'categories.*.integer'  => 'ID категорий должны быть типом Integer',
            'categories.*.distinct' => 'Повторяющийся ID категории',
            'categories.*.exists'   => 'Указана не существующая категория',

            'image.image'           => 'Изображение неверного формата, поддерживаемы форматы: jpg, jpeg, png, bmp, gif, svg, webp',
        ];
    }
}
