@extends('layouts.app')
@section('title', 'Login - User Management System')

@section('content')
<div class="auth-header">
    <h2><i class="bi bi-box-arrow-in-right"></i> Login</h2>
    <p>Welcome back! Please login to your account.</p>
</div>

<form action="{{ route('login') }}" method="POST">
    @csrf

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-circle"></i>
            <strong>Login Failed!</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="mb-3">
        <label for="email" class="form-label">Email Address</label>
        <div class="input-group">
            <span class="input-group-text" style="background: white; border: 1px solid #e0e0e0;">
                <i class="bi bi-envelope"></i>
            </span>
            <input 
                type="email" 
                class="form-control @error('email') is-invalid @enderror" 
                id="email"
                name="email" 
                placeholder="Enter your email" 
                value="{{ old('email') }}" 
                required
            >
        </div>
        @error('email')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <div class="input-group">
            <span class="input-group-text" style="background: white; border: 1px solid #e0e0e0;">
                <i class="bi bi-lock"></i>
            </span>
            <input 
                type="password" 
                class="form-control @error('password') is-invalid @enderror" 
                id="password"
                name="password" 
                placeholder="Enter your password" 
                required
            >
        </div>
        @error('password')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    @if($captcha)
        <div class="captcha-box">
            <div class="question">
                <i class="bi bi-question-circle"></i> {{ $captcha['captcha_question'] ?? 'Solve this:' }}
            </div>
            <input 
                type="hidden" 
                name="captcha_key" 
                value="{{ $captcha['captcha_key'] ?? '' }}"
            >
            <input 
                type="text" 
                class="form-control @error('captcha_answer') is-invalid @enderror" 
                name="captcha_answer" 
                placeholder="Enter your answer" 
                required
            >
            <small class="form-text">Please solve the captcha above</small>
        </div>
        @error('captcha_answer')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    @else
        <div class="alert alert-warning">
            <i class="bi bi-exclamation-triangle"></i> Unable to load captcha. Please try again.
        </div>
    @endif

    <button type="submit" class="btn btn-primary w-100 py-2 mt-3">
        <i class="bi bi-box-arrow-in-right"></i> Login
    </button>
</form>

<hr class="my-4">

<p class="text-center mb-0">
    Don't have an account? 
    <a href="{{ route('register') }}" class="text-decoration-none fw-bold" style="color: #667eea;">
        Register here
    </a>
</p>
@endsection
