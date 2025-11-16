@extends('layouts.app')
@section('title', 'My Profile - User Management System')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-0"><i class="bi bi-person-circle"></i> My Profile</h1>
            <a href="{{ route('dashboard') }}" class="btn btn-outline-primary">
                <i class="bi bi-arrow-left"></i> Back to Dashboard
            </a>
        </div>

        @if(isset($profile) && $profile)
            <div class="card mb-4">
                <div class="card-header bg-light border-0 pt-4 pb-3">
                    <h5 class="card-title mb-0"><i class="bi bi-pencil-square"></i> Edit Profile</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf

                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="bi bi-exclamation-circle"></i>
                                <strong>Update Failed!</strong>
                                <ul class="mb-0 mt-2">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <div class="mb-3">
                            <label for="name" class="form-label">
                                <i class="bi bi-person"></i> Full Name
                            </label>
                            <input 
                                type="text" 
                                class="form-control @error('name') is-invalid @enderror" 
                                id="name"
                                name="name" 
                                value="{{ $profile['name'] ?? '' }}" 
                                required
                            >
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">
                                <i class="bi bi-envelope"></i> Email Address
                            </label>
                            <input 
                                type="email" 
                                class="form-control @error('email') is-invalid @enderror" 
                                id="email"
                                name="email" 
                                value="{{ $profile['email'] ?? '' }}" 
                                required
                            >
                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">
                                <i class="bi bi-lock"></i> New Password
                            </label>
                            <input 
                                type="password" 
                                class="form-control @error('password') is-invalid @enderror" 
                                id="password"
                                name="password" 
                                placeholder="Leave blank to keep current password"
                            >
                            <small class="form-text text-muted">
                                Only fill this if you want to change your password. Minimum 6 characters.
                            </small>
                            @error('password')
                                <small class="text-danger d-block">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">
                                <i class="bi bi-lock"></i> Confirm Password
                            </label>
                            <input 
                                type="password" 
                                class="form-control @error('password_confirmation') is-invalid @enderror" 
                                id="password_confirmation"
                                name="password_confirmation" 
                                placeholder="Confirm your new password"
                            >
                            @error('password_confirmation')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">
                                <i class="bi bi-briefcase"></i> Role
                            </label>
                            <div class="input-group">
                                @php
                                    $role = $profile['role'] ?? 'user';
                                    $badgeClass = $role === 'admin' ? 'badge-admin' : ($role === 'manager' ? 'badge-manager' : 'badge-user');
                                @endphp
                                <span class="input-group-text badge {{ $badgeClass }}" style="border: none; width: 100%; justify-content: flex-start;">
                                    {{ ucfirst($role) }}
                                </span>
                            </div>
                            <small class="form-text text-muted d-block mt-2">Your role cannot be changed</small>
                        </div>

                        <hr>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-start">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-check-circle"></i> Save Changes
                            </button>
                            <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary btn-lg">
                                <i class="bi bi-x-circle"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-light border-0 pt-4 pb-3">
                    <h5 class="card-title mb-0"><i class="bi bi-info-circle"></i> Account Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p class="mb-2">
                                <strong><i class="bi bi-calendar-event"></i> Account Created:</strong><br>
                                <small class="text-muted">
                                    {{ isset($profile['created_at']) ? date('M d, Y H:i', strtotime($profile['created_at'])) : 'N/A' }}
                                </small>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-2">
                                <strong><i class="bi bi-arrow-repeat"></i> Last Updated:</strong><br>
                                <small class="text-muted">
                                    {{ isset($profile['updated_at']) ? date('M d, Y H:i', strtotime($profile['updated_at'])) : 'N/A' }}
                                </small>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-circle"></i>
                <strong>Error!</strong> Unable to load profile information. Please try refreshing the page.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
    </div>
</div>
@endsection
