<!-- 
NAME: Rian Firmansyah
NIM: 3202416045
DATE: 2/11/2026
-->

@extends('layouts.guest')

@section('title', 'Login')

@section('content')
    <div class="text-center mb-4">
        <i class="bi bi-mortarboard-fill display-5 text-primary"></i>
        <h1 class="h3 fw-bold mb-1">{{ config('app.name') }}</h1>
        <p class="text-body-secondary mb-0">Politeknik Negeri Pontianak</p>
    </div>

    @include('layouts.partials.flash')

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <h2 class="h5 mb-3">Masuk ke akun Anda</h2>

            <form method="POST" action="{{ route('login.attempt') }}" novalidate>
                @csrf

                <div class="mb-3">
                    <x-form-input label="Email" name="email" type="email"
                        autocomplete="username" required autofocus />
                </div>

                <div class="mb-3">
                    <x-form-input label="Kata Sandi" name="password" type="password"
                        autocomplete="current-password" required />
                </div>

                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox"
                        name="remember" id="remember">
                    <label class="form-check-label" for="remember">Ingat saya</label>
                </div>

                <button type="submit" class="btn btn-primary w-100">Masuk</button>
            </form>
        </div>
    </div>
@endsection