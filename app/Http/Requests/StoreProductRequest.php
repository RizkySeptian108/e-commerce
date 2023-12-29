<?php

namespace App\Http\Requests;

use App\Rules\MaxWords;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if(Auth::user()->kiosk->id !== null){
            return true;
        }
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'product_name' => ['required', new MaxWords(40), 'min:3', 'string'],
            'category_id' => ['required', 'numeric', 'exists:categories,id'],
            'qty' => ['numeric','required'],
            'unit' => ['required', Rule::in(['pcs', 'kg', 'box','pck', 'sak']), 'string'],
            'price_per_unit' => ['numeric', 'required'],
            'description' => ['string', new MaxWords(100), 'required'],
            'product_picture' => ['image', 'max:2048']
        ];
    }
}
