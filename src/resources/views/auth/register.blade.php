@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('hideCommon', 'true')

@section('content')
<div class="register-title">
    <h1 class="register-title__inner">会員登録</h1>
</div>
<div class="register-form__content">
    <form action="/register" method="post" class="register-form">
        @csrf
        <div class="register-form__group">
            <p class="register-form__label">ユーザー名</p>
            <input type="text" class="register-form__input" name="name" value="{{ old('name') }}">
            <p class="register-form__error-message">
                @error('name')
                    {{ $message }}
                @enderror
            </p>
        </div>
        <div class="register-form__group">
            <p class="register-form__label">メールアドレス</p>
            <input type="mail" class="register-form__input" name="email" value="{{ old('email') }}">
            <p class="register-form__error-message">
                @error('email')
                    {{ $message }}
                @enderror
            </p>
        </div>
        <div class="register-form__group">
            <p class="register-form__label">パスワード</p>
            <input type="password" class="register-form__input" name="password">
            <p class="register-form__error-message">
                @error('password')
                    {{ $message }}
                @enderror
            </p>
        </div>
        <div class="register-form__group">
            <p class="register-form__label">確認用パスワード</p>
            <input type="password" class="register-form__input" name="password_confirmation">
            <p class="register-form__error-message">
                @error('password_confirmation')
                    {{ $message }}
                @enderror
            </p>
        </div>
        <input type="submit" class="register-form__btn" value="登録する">
    </form>
    <div class="login-link"><a href="/login">ログインはこちら</a></div>
</div>
@endsection