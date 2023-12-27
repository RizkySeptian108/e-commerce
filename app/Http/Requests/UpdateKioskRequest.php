<?php

namespace App\Http\Requests;

use App\Rules\MaxWords;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateKioskRequest extends FormRequest
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
        $kiosk = $this->route('kiosk');
        return [
            'kiosk_name' => ['required' , 'max:50', 'min:3', 'string', Rule::unique('kiosks', 'kiosk_name')->ignore($kiosk->id)],
            'kiosk_description' => ['required','max:500','string', new MaxWords(100)],
            'kiosk_logo' => 'image|max:2048'
        ];
    }
}
