<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
            'orders' => 'required|array',
            'orders.*.kiosk_id' => 'int|required|exists:kiosks,id',
            'orders.*.items' => 'required|array',
            'orders.*.items.*.cart_id' => 'int|required|exists:carts,id',
            'orders.*.items.*.qty' => 'required|numeric'
        ];
    }
}
