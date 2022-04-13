<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class ProductIndexRequest extends FormRequest
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
            'count'                 => ['integer', 'nullable', 'min:5', 'max:50'],
            'search_product_name'   => ['nullable', 'string', 'min:3', 'max:50'],
            'category_id'           => ['integer', 'nullable', 'exists:categories,id'],
            'search_category_name'  => ['string', 'min:3', 'max:50'],
            'search_price_from'     => ['numeric', 'nullable'],
            'search_price_to'       => ['numeric', 'nullable'],
            'show_published'        => ['boolean', 'nullable'],
            'show_deleted'          => ['boolean', 'nullable'],

        ];
    }

    public function messages()
    {
        return [
            'count.min'                     => 'Минимальное количество элементов на странице - 5',
            'count.max'                     => 'Максимальное количество элементов на странице - 50',
            'search_product_name.string'    => 'Строка поиска товаров должна быть строкой',
            'search_product_name.min'       => 'Минимальное количество символов для поиска товара - 3',
            'search_product_name.max'       => 'Максимальное количество символов для поиска товара - 50',
            'category_id.integer'           => '',
            'category_id.exists'            => '',
            'search_category_name.string'   => 'Строка поиска категорий должна быть строкой',
            'search_category_name.min'      => 'Минимальное количество символов для поиска категорий - 3',
            'search_category_name.max'      => 'Максимальное количество символов для поиска категорий - 50',
            'search_price_from.numeric'     => 'Поле фильтра "Цена от" должно быть числом',
            'search_price_to.numeric'       => 'Поле фильтра "Цена до" должно быть числом',
            'show_published.boolean'        => 'Поле фильтра "Показать опубликованные" должно быть числом',
            'show_deleted.boolean'          => 'Поле фильтра "Показать удаленные" должно быть числом',
        ];
    }
}
