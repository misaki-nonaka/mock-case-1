<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'profile_img' => ['mimes:jpeg,png,jpg'],
            'nickname' => ['required', 'max:20'],
            'zipcode' => ['required', 'regex:/^\d{3}-\d{4}$/'],
            'address' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'profile_img.mimes' => '拡張子は.jpgもしくは.pngを選択してください',
            'nickname.required' => 'ユーザー名を入力してください',
            'nickname.max' => 'ユーザー名は20文字以内で入力してください',
            'zipcode.required' => '郵便番号を入力してください',
            'zipcode.regex' => '郵便番号はハイフン含めた8桁で入力してください',
            'address.required' => '住所を入力してください',
        ];
    }
}
