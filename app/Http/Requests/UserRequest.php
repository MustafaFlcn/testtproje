<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [

            'name' => 'required',
            'surname'=>'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'phone' => ['required', 'regex:/^(05(\d{9}))$/'],



        ];
    }


    public function messages()
    {
        return [
            'name.required' => 'Ad alanı zorunludur.',
            'surname.required' => 'soyad alanı zorunludur.',
            'email.required' => 'E-posta alanı zorunludur.',
            'email.email' => 'Geçerli bir e-posta adresi giriniz.',
            'email.unique' => 'Bu e-posta adresi zaten kullanılmaktadır.',
            'password.required' => 'Parola alanı zorunludur.',
            'password.min' => 'Parola en az 6 karakter olmalıdır.',
            'password.confirmed' => 'Parola doğrulama eşleşmiyor.',
            'phone.required' => 'telefon alanı zorunludur.',
            'phone.regex' => 'Telefon numarası geçerli bir telefon formatına uygun olmalıdır.',


        ];
    }

}
