<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

class OrderCreateRequest extends FormRequest
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
            'cms_user_id'=>'nullable|integer|exists:users,id', // after login implemented this will remove
            'subtotal'=>'required|decimal:2',
            'tax_amount'=>'required|decimal:2',
            'notes'=>'required|string',
            'order_items' => 'required|array|min:1',
            'order_items.*.product_id' => 'required|integer|exists:product,id',
            'order_items.*.quantity' => 'required|integer|min:1|max:999999',
            'order_items.*.unit_price' => 'required|numeric|min:0|max:9999999999999999999999999999.99'
        ];
    }

    /**
     * Get custom attribute names for error messages.
     */
    public function attributes(): array
    {
        return [
            'order_items.*.product_id' => 'product ID',
            'order_items.*.quantity' => 'quantity',
            'order_items.*.unit_price' => 'unit price',
        ];
    }
}
