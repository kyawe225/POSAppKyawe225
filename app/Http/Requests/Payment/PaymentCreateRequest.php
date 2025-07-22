<?php

namespace App\Http\Requests\Payment;

use Illuminate\Foundation\Http\FormRequest;

class PaymentCreateRequest extends FormRequest
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
            "order_id"=>"required|integer|exists:orders,id",
            "payment_method_id"=>"required|integer|exists:payment_methods,id",
            "amount"=>"required|decimal:2",
            "payment_date"=>"required|date",
            "gateway_provider"=>"required|string",
            "cupon_code"=>"nullable|string"
        ];
    }
}
