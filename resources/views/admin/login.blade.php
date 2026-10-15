@extends('layouts.course')
@section('title', 'Login Dosen')
@section('content')
<div class="auth">
    <h1>Login dosen</h1>
    <p class="lead">Masuk untuk mengelola materi dan status pertemuan.</p>
    <div class="panel"><div class="panel-body">
        <form method="POST" action="{{ route('admin.login.store') }}">
            @csrf
            <div class="field">
                <label class="lbl" for="email">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
            </div>
            <div class="field">
                <label class="lbl" for="password">Kata sandi</label>
                <input id="password" type="password" name="password" required autocomplete="current-password">
            </div>
            <div class="field">
                <label class="check"><input type="checkbox" name="remember" value="1"> Ingat saya di perangkat ini</label>
            </div>
            <button class="btn" type="submit">Masuk ke dashboard</button>
        </form>
    </div></div>
</div>
@endsection
