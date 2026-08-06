<?php

namespace App\Http\Requests;

use App\Rules\NoHtml;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class AuthFormRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $noHtml = new NoHtml();
        return match ($this->route()->getActionMethod()) {
            'register' => [
                'name' => ['required', 'string', 'max:255', $noHtml],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => [
                    'required',
                    'string',
                    Password::min(8)
                        ->letters()
                        ->mixedCase()
                        ->numbers()
                        ->symbols(),
                    'confirmed',
                ],
            ],
            'send_email' => [
                'email' => ['required', 'string', 'email', 'max:255'],
            ],
            'verify_code' => [
                'email' => ['required', 'string', 'email', 'max:255'],
                'code' => ['required', 'digits:6'],
            ],
            'verify_for_new_password' => [
                'email' => ['required', 'string', 'email', 'max:255'],
                'code' => ['required', 'digits:6'],
            ],
            'reset_password' => [
                'email' => ['required', 'string', 'email', 'max:255'],
                'reset_token' => ['required', 'string'],
                'new_password' => [
                    'required',
                    'string',
                    Password::min(8)
                        ->letters()
                        ->mixedCase()
                        ->numbers()
                        ->symbols(),
                    'confirmed',
                ],
            ],
            'login' => [
                'email' => ['required', 'string', 'email', 'max:255'],
                'password' => ['required', 'string'],
            ],
            default => []
        };
    }
}
