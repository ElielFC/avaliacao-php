<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
            'product_category_id' => 'required|exists:product_categories,id',
            'registration_date'   => 'required|date_format:Y-m-d H:i:s',
            'product_name'        => 'required|max:150',
            'product_value'       => 'required|numeric',
        ];
    }
}
