<?php

namespace App\Http\Requests\Supplier;

use Illuminate\Foundation\Http\FormRequest;

class SupplierUpdateRequest extends FormRequest
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
            "name"=>"required|string",
            "contact_person"=>"required|string",
            "email"=>"required|email",
            "phone"=>"required|string",
            "address"=>"required|string",
            "city"=>"nullable|string",
            "state"=>"nullable|string",
            "postal_code"=>"nullable|string",
            "country"=>"nullable|string",
            "status"=>"nullable|string"
        ];
    }
}
