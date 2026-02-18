@extends('layouts.client')

@section('content')

    <div class="login-container row">
        <!-- Image Section -->
        <div class="col-md-8 login-image"></div>

        <!-- Form Section -->
        <div class="col-md-4 p-5">
            <div class="text-center">
                <img src="{{ asset('logos/1725016789_Sans titre-1(1).png') }}" alt="Logo" class="form-logo">
                <h2 class="mb-4 text-success">CREATE AN ACCOUNT</h2>
            </div>

            <form action="{{ route('register') }}" method="POST">
                @csrf <!-- Protection contre les attaques CSRF -->

                <!-- Champ Nom -->
                <div class="mb-3">
                    <label for="name" class="form-label">Full Name</label>
                    <input type="text" class="form-control form-control-lg @error('name') is-invalid @enderror" id="name"
                        name="name" value="{{ old('name') }}" placeholder="Enter your full name">

                    <!-- Message d'erreur pour Nom -->
                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

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

                <!-- Champ Confirm Password -->
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <input type="password"
                        class="form-control form-control-lg @error('password_confirmation') is-invalid @enderror"
                        id="password_confirmation" name="password_confirmation" placeholder="Confirm your password">

                    <!-- Message d'erreur pour Confirm Password -->
                    @error('password_confirmation')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Bouton Register -->
                <button type="submit" class="btn btn-success btn-lg w-100">Sign Up</button>
            </form>

            <div class="text-center mt-4">
                <p class="mt-2">Already have an account? <a href="{{ route('login') }}"
                        class="text-decoration-none text-success">Login</a></p>
            </div>
        </div>
    </div>

@endsection