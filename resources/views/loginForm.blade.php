@extends('layouts.app')

@section('content')
    <div class="main-container">
        <form class="login-form" action="{{route('login')}}" method="post">
            @csrf
            <input type="text" name="login" placeholder="Логин">
            <input type="password" name="password" placeholder="Пароль">
            <button>Войти</button>
        </form>
    </div>
@endsection
