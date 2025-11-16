@extends('layouts.app')
@section('title', 'Dashboard - User Management System')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-0"><i class="bi bi-speedometer2"></i> Dashboard</h1>
        </div>

        @if(isset($user) && $user)
            <div class="row mb-4">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-2 text-center">
                                    <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                                        <i class="bi bi-person" style="font-size: 2.5rem; color: white;"></i>
                                    </div>
                                </div>
                                <div class="col-md-10">
                                    <h4 class="card-title mb-2">Welcome, {{ $user['name'] ?? 'User' }}!</h4>
                                    <p class="text-muted mb-1"><i class="bi bi-envelope"></i> {{ $user['email'] ?? 'N/A' }}</p>
                                    <p class="text-muted mb-1"><i class="bi bi-briefcase"></i> Role: 
                                        @php
                                            $role = $user['role'] ?? 'user';
                                            $badgeClass = $role === 'admin' ? 'badge-admin' : ($role === 'manager' ? 'badge-manager' : 'badge-user');
                                        @endphp
                                        <span class="badge {{ $badgeClass }}">{{ ucfirst($role) }}</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body text-center">
                            <h6 class="text-muted mb-3">Account Status</h6>
                            <p class="mb-0">
                                <span class="badge bg-success" style="font-size: 0.9rem;">
                                    <i class="bi bi-check-circle"></i> Active
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="card text-center">
                        <div class="card-body">
                            <i class="bi bi-person-circle" style="font-size: 2.5rem; color: #667eea;"></i>
                            <h5 class="card-title mt-3">View Profile</h5>
                            <p class="card-text text-muted">See and edit your profile information</p>
                            <a href="{{ route('profile.show') }}" class="btn btn-primary btn-sm">
                                <i class="bi bi-arrow-right"></i> Go to Profile
                            </a>
                        </div>
                    </div>
                </div>

                @if($user['role'] === 'admin')
                    <div class="col-md-4">
                        <div class="card text-center">
                            <div class="card-body">
                                <i class="bi bi-shield-lock" style="font-size: 2.5rem; color: #ff6b6b;"></i>
                                <h5 class="card-title mt-3">Admin Panel</h5>
                                <p class="card-text text-muted">Manage all users in the system</p>
                                <a href="{{ route('admin.users.index') }}" class="btn btn-danger btn-sm">
                                    <i class="bi bi-arrow-right"></i> Go to Admin
                                </a>
                            </div>
                        </div>
                    </div>
                @endif

                @if($user['role'] === 'manager')
                    <div class="col-md-4">
                        <div class="card text-center">
                            <div class="card-body">
                                <i class="bi bi-people" style="font-size: 2.5rem; color: #ffa94d;"></i>
                                <h5 class="card-title mt-3">Users Management</h5>
                                <p class="card-text text-muted">View and manage users</p>
                                <a href="{{ route('admin.users.index') }}" class="btn btn-warning btn-sm">
                                    <i class="bi bi-arrow-right"></i> Go to Users
                                </a>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="col-md-4">
                    <div class="card text-center">
                        <div class="card-body">
                            <i class="bi bi-info-circle" style="font-size: 2.5rem; color: #4299e1;"></i>
                            <h5 class="card-title mt-3">Quick Stats</h5>
                            <p class="card-text text-muted">
                                @php
                                    $role = $user['role'] ?? 'user';
                                    echo ucfirst($role) . ' Account';
                                @endphp
                            </p>
                            <small class="text-muted">
                                <i class="bi bi-calendar"></i> Member since {{ isset($user['created_at']) ? date('M Y', strtotime($user['created_at'])) : 'N/A' }}
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle"></i>
                <strong>Warning!</strong> Unable to load user information. Please try logging out and logging back in.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
    </div>
</div>
@endsection
