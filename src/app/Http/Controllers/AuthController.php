<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeEmail;
use Illuminate\Auth\Events\Registered;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        // return redirect('/mypage/profile');
        return redirect('/email/verify');
    }

    public function login(LoginRequest $request)
    {

        $credentials = $request->only('email', 'password');

        if (! Auth::attempt($credentials)) {

            throw ValidationException::withMessages([
                'password' => ['ログイン情報が登録されていません'],
            ]);
        }

        if(!auth()->user()->hasVerifiedEmail()) {
            return redirect()->route('verification.notice');
        }

        return redirect()->intended('/');
    }

    public function mail() {
        $certificationMail = new CertificationMail();
        Mail::send($certificationMail);
        if (count(Mail::failures()) > 0) {
            $message = 'メール送信に失敗しました';

						// 元の画面に戻る
						return back()->withErrors($messages);
        }
        else{
            $messages = 'メールを送信しました';

						// 別のページに遷移する
						return redirect()->route('profile')->with(compact('messages'));
        }
    }
}
