<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
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
            'fullname' => 'required|string|max:255', 
            'adresse' => 'nullable|string|max:255',
            'phone' => 'required|string|max:255',
            'photo' => 'nullable',
            'ville' => 'nullable|string|max:255',
            'email' => 'required|string|max:255',
            'password' => 'required|string',
            'role_id' => 'required|exists:roles,id',
        ];

    }
}
