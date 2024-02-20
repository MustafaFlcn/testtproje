<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class UserUpdateRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        $userId = Auth::id();

        return [

            'email' => [
                'email',
                Rule::unique('users')->ignore($userId),
            ],
            'password' => 'min:6|confirmed',

            'phone' => [ 'regex:/^(05(\d{9}))$/'],

        ];
    }

    public function messages()
    {
        return [

            'email.email' => 'Geçerli bir e-posta adresi giriniz.',
            'email.unique' => 'Bu e-posta adresi başka bir kullanıcı tarafından kullanılıyor.',
            'password.min' => 'Parola en az 6 karakter olmalıdır.',
            'password.confirmed' => 'Parola doğrulama eşleşmiyor.',
            'phone.regex' => 'Telefon numarası geçerli bir telefon formatına uygun olmalıdır.',

        ];
    }
}
