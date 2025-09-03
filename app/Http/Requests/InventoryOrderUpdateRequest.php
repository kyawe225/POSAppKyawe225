<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InventoryOrderUpdateRequest extends FormRequest
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
            "product_id"=>"required|integer",
            "supplier_id"=>"required|integer",
            "order_date"=>"required|date",
            "total_amount"=>"required|date",
            "notes"=>"required|string",
            "actual_delivery_date"=>"nullable|date",
            "status"=>"required|string",
            "damage_quantity"=>"nullable|integer",
            "actual_quantity"=>"nullable|integer",
            "expected_quantity"=>"nullable|integer"
        ];
    }
}
