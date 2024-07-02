<?php

namespace App\Http\Requests;

use App\Rules\MaxWords;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreAddressRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if(Auth::user()->email_verified_at != null){
            return true;
        }else{
            return false;
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'recipient_name' => ['required', 'string', 'max:255'],
            'phone_number' => ['required','string', 'starts_with:+62', 'regex:/^\+62\d{9,12}$/'],
            'address_label' => ['required', 'string', 'max:255'],
            'address_benchmark' => ['string', new MaxWords(50)],
            'full_address' => ['string', new MaxWords(100)],
        ];
    }
}
