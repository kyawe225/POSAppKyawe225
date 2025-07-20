<?php

namespace App\Http\Requests\Cupon;

use Illuminate\Foundation\Http\FormRequest;

class CuponUpdateRequest extends FormRequest
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
            "cupon_code"=>"string|required",
            "description"=>"nullable|string",
            "discount_value"=>"required|decimal:2",
            "discount_type"=>"required|string|in:percentage,fixed_amount",
            "maximum_discount_amount"=>"nullable|decimal:2",
            "minimum_purchase_amount"=>"required|decimal:2",
            "valid_from"=>"required|date",
            "valid_until"=>"required|date",
            "usage_limit"=>"required|integer",
            "usage_count"=>"required|integer",
            "status"=>"requried|in:active,pause"
        ];
    }
}
