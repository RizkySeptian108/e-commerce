<?php

namespace App\Http\Requests;

use App\Rules\MaxWords;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class StoreKioskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // if(Auth::user()->email_verify_at && Auth::user()->address){
        //     return true;
        // }
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
            'kiosk_name' => 'required|max:50|min:3|string|unique:kiosks,kiosk_name',
            'kiosk_description' => ['required','max:500','string', new MaxWords(100)],
            'kiosk_logo' => 'image', 'size:2048'
        ];
    }
}
