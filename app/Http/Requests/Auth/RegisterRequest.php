<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'email' => 'required|string|email|max:255|unique:users',
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*?&#]/',
            ],
            'user_name' => 'required|string|max:255|alpha_dash',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048|unique:users',
            'certificate' => 'nullable|file|mimes:pdf|max:5120|unique:users',
            'phone_number' => 'required|string|max:20|unique:users|regex:/^[0-9]+$/',
        ];
    }

    /**
     * @return string[]
     */
    public function messages()
    {
        return [
            'name.required' => 'The name field is required.',
            'name.regex' => 'The name field must contain only letters and spaces.',
            'email.required' => 'The email field is required.',
            'email.email' => 'The email must be a valid email address.',
            'email.unique' => 'The email has already been taken.',
            'password.required' => 'The password field is required.',
            'password.min' => 'The password must be at least 8 characters.',
            'password.confirmed' => 'The password confirmation does not match.',
            'password.regex' => 'The password must contain at least one lowercase letter, one uppercase letter, one digit, and one special character.',
            'user_name.required' => 'The username field is required.',
            'user_name.unique' => 'The username has already been taken.',
            'user_name.alpha_dash' => 'The username may only contain letters, numbers, dashes, and underscores.',
            'profile_photo.image' => 'The profile photo must be an image.',
            'profile_photo.mimes' => 'The profile photo must be a file of type: jpeg, png, jpg, gif.',
            'profile_photo.max' => 'The profile photo may not be greater than 2048 kilobytes.',
            'certificate.mimes' => 'The certificate must be a file of type: pdf.',
            'certificate.max' => 'The certificate may not be greater than 2048 kilobytes.',
            'phone_number.required' => 'The phone number field is required.',
            'phone_number.unique' => 'The phone number has already been taken.',
            'phone_number.regex' => 'The phone number must contain only digits.',
            'verification_code.size' => 'The verification code must be exactly 6 digits.',
            'verification_code.regex' => 'The verification code must be exactly 6 digits.',
        ];
    }
}
