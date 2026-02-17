@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('hideCommon', 'true')

@section('content')
<div class="login-title">
    <h1 class="login-title__inner">ログイン</h1>
</div>
<div class="login-form__content">
    <form action="/login" method="post" class="login-form">
        @csrf
        <div class="login-form__group">
            <p class="login-form__label">メールアドレス</p>
            <input type="mail" class="login-form__input" name="email" value="{{ old('email') }}">
            <p class="login-form__error-message">
                @error('email')
                    {{ $message }}
                @enderror
            </p>
        </div>
        <div class="login-form__group">
            <p class="login-form__label">パスワード</p>
            <input type="password" class="login-form__input" name="password">
            <p class="login-form__error-message">
                @error('password')
                    {{ $message }}
                @enderror
            </p>
        </div>
        <input type="submit" class="login-form__btn" value="ログインする">
    </form>
    <div class="register-link"><a href="/register">会員登録はこちら</a></div>
</div>
@endsection