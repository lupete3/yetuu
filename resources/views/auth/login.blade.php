@extends('layouts.client')

@section('content')

    <div class="login-container row">
        <!-- Image Section -->
        <div class="col-md-8 login-image "></div>

        <!-- Form Section -->
        <div class="col-md-4 p-5">
            <div class="text-center">
                <img src="{{ asset('logos/1725016789_Sans titre-1(1).png') }}" alt="Logo" class="form-logo">
                <h2 class="mb-4 text-success">LOGIN – WELCOME BACK</h2>
            </div>

            <form action="{{ route('login') }}" method="POST">
                @csrf <!-- Protection contre les attaques CSRF -->

                <!-- Champ Email -->
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control form-control-lg @error('email') is-invalid @enderror" id="email"
                        name="email" value="{{ old('email') }}" placeholder="Enter your email">

                    <!-- Message d'erreur pour Email -->
                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Champ Password -->
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control form-control-lg @error('password') is-invalid @enderror"
                        id="password" name="password" placeholder="Enter your password">

                    <!-- Message d'erreur pour Password -->
                    @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Checkbox "Remember me" -->
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" id="remember" name="remember">
                    <label class="form-check-label" for="remember">Remember me</label>
                </div>

                <!-- Bouton de connexion -->
                <button type="submit" class="btn btn-success btn-lg w-100">Login</button>
            </form>

            <div class="text-right mt-4">
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-decoration-none text-success">Forgot password?</a>
                @endif
                <p class="mt-2 text-left">Don’t have an account? <a href="{{ route('register') }}"
                        class="text-decoration-none text-success">Sign Up</a></p>
            </div>
        </div>
    </div>

@endsection