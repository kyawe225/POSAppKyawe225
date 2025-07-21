<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class ProductCreateRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'=>"required|string",
            'description'=>"nullable|string",
            "category_id"=>'required|integer',
            "default_supplier_id"=>'required|integer',
            "price"=>"required|decimal:2",
            "cost"=>"required|decimal:2",
            "reorder_point"=>"required|integer",
            "image_url"=>"required|string",
            "attribute"=>"required|json",
            "attribute_type"=>"required|string"
        ];
    }
}
