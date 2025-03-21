@extends('layouts.app')

@section('content')
<div class="page-center">
    <div class="form-container">
        <h2 class="form-title">Login</h2>
        <form method="POST" {{ route('login') }} class="mt-6 space-y-6">
            @csrf
            <div>
                <label for="email" class="input-label">Email</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    class="w-full input-text @error('email') border-red-500 @enderror"
                    placeholder="Enter your email"
                    required
                    autocomplete="email"
                    autofocus
                >
                @error('email')
                <p class="input-error">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="input-label">Password</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    class="w-full input-text @error('password') border-red-500 @enderror"
                    placeholder="Enter your password"
                    autocomplete="current-password"
                    required
                >
                @error('password')
                    <p class="input-error">{{ $message }}</p>
                @enderror
            </div>
            <div class="mt-2">
                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                <label class="form-check-label" for="remember">
                    {{ __('Remember Me') }}
                </label>
            </div>
            <div>
                <button type="submit" class="submit-button">Login</button>
            </div>
        </form>
    </div>
</div>
@endsection
