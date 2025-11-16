@extends('layouts.app')
@section('title', 'Edit User - User Management System')

@section('content')
<style>
    .edit-container {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: calc(100vh - 70px);
        padding: 3rem 1rem;
        animation: fadeIn 0.5s ease-in;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .edit-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
        overflow: hidden;
        animation: slideUp 0.6s ease-out;
    }

    @keyframes slideUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .edit-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 2.5rem;
        color: white;
        position: relative;
        overflow: hidden;
    }

    .edit-header::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 300px;
        height: 300px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        transform: translate(50%, -50%);
    }

    .edit-header h2 {
        margin: 0;
        font-weight: 800;
        font-size: 2rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        position: relative;
        z-index: 1;
    }

    .edit-header p {
        margin: 0.5rem 0 0;
        opacity: 0.95;
        font-size: 0.95rem;
        position: relative;
        z-index: 1;
    }

    .edit-body {
        padding: 3rem;
    }

    .section-title {
        color: #2d3748;
        font-weight: 700;
        margin: 2rem 0 1.5rem;
        padding-bottom: 0.75rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        border-bottom: 2px solid #e2e8f0;
    }

    .section-title i {
        color: #667eea;
        font-size: 1.25rem;
    }

    .form-group-wrapper {
        margin-bottom: 1.5rem;
    }

    .form-group-wrapper label {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: #2d3748;
        font-weight: 600;
        margin-bottom: 0.75rem;
        font-size: 0.95rem;
    }

    .form-group-wrapper label i {
        color: #667eea;
        font-size: 1rem;
    }

    .form-control,
    .form-select {
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        padding: 0.875rem 1rem;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        background-color: #f8fafc;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #667eea;
        background-color: white;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        outline: none;
    }

    .form-control::placeholder {
        color: #cbd5e0;
    }

    .password-section {
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.05) 0%, rgba(118, 75, 162, 0.05) 100%);
        padding: 1.5rem;
        border-radius: 12px;
        border-left: 4px solid #667eea;
        margin: 1.5rem 0;
    }

    .password-info {
        color: #4a5568;
        font-size: 0.9rem;
        margin-bottom: 1rem;
        padding: 0.75rem 1rem;
        background: rgba(102, 126, 234, 0.1);
        border-radius: 8px;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .account-info {
        background: linear-gradient(135deg, rgba(72, 187, 120, 0.05) 0%, rgba(72, 187, 120, 0.05) 100%);
        padding: 1.5rem;
        border-radius: 12px;
        border-left: 4px solid #48bb78;
        margin: 1.5rem 0;
    }

    .info-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0.75rem 0;
        color: #4a5568;
        font-size: 0.95rem;
    }

    .info-row strong {
        color: #2d3748;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .info-row i {
        color: #48bb78;
    }

    .error-alert {
        background: linear-gradient(135deg, rgba(245, 101, 101, 0.1) 0%, rgba(245, 101, 101, 0.05) 100%);
        border-left: 4px solid #f56565;
        border-radius: 12px;
        padding: 1rem;
        margin-bottom: 2rem;
        animation: slideDown 0.3s ease-out;
    }

    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .error-list {
        list-style: none;
        padding: 0;
        margin: 0.5rem 0 0;
    }

    .error-list li {
        color: #c53030;
        padding: 0.3rem 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .invalid-feedback {
        color: #f56565;
        font-size: 0.85rem;
        margin-top: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.3rem;
    }

    .button-group {
        display: flex;
        gap: 1rem;
        margin-top: 2.5rem;
        flex-wrap: wrap;
    }

    .btn-update {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        border-radius: 12px;
        padding: 0.875rem 2rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 1rem;
    }

    .btn-update:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
        color: white;
    }

    .btn-back {
        background: white;
        color: #667eea;
        border: 2px solid #667eea;
        border-radius: 12px;
        padding: 0.875rem 2rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 1rem;
    }

    .btn-back:hover {
        background: #667eea;
        color: white;
        transform: translateY(-2px);
    }

    .divider {
        height: 2px;
        background: linear-gradient(to right, transparent, #e0e0e0, transparent);
        margin: 2rem 0;
    }

    .user-avatar {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
        margin-bottom: 1rem;
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
    }

    @media (max-width: 768px) {
        .edit-body {
            padding: 1.5rem;
        }

        .edit-header {
            padding: 1.5rem;
        }

        .edit-header h2 {
            font-size: 1.5rem;
        }

        .button-group {
            flex-direction: column;
        }

        .btn-update,
        .btn-back {
            width: 100%;
            justify-content: center;
        }

        .info-row {
            flex-direction: column;
            align-items: flex-start;
        }
    }
</style>

<div class="edit-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7 col-xl-6">
                <div class="edit-card">
                    @if(isset($user) && $user)
                        <div class="edit-header">
                            <h2><i class="bi bi-pencil-square"></i> Edit User Account</h2>
                            <p>Update user information and permissions</p>
                        </div>

                        <div class="edit-body">
                            @if ($errors->any())
                                <div class="error-alert">
                                    <strong><i class="bi bi-exclamation-triangle"></i> Validation Errors</strong>
                                    <ul class="error-list">
                                        @foreach ($errors->all() as $error)
                                            <li><i class="bi bi-dash-circle-fill"></i> {{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form method="POST" action="{{ route('admin.users.update', $user['id']) }}">
                                @csrf
                                @method('PUT')
                                @method('PUT')

                                <!-- User Avatar & Name -->
                                <div style="text-align: center; margin-bottom: 2rem;">
                                    <div class="user-avatar">
                                        <i class="bi bi-person-fill"></i>
                                    </div>
                                    <p style="color: #4a5568; font-size: 0.9rem;">User ID: <strong>#{{ $user['id'] }}</strong></p>
                                </div>

                                <!-- Personal Information Section -->
                                <h5 class="section-title">
                                    <i class="bi bi-person-circle"></i> Personal Information
                                </h5>

                                <div class="form-group-wrapper">
                                    <label for="name">
                                        <i class="bi bi-person"></i> Full Name
                                    </label>
                                    <input 
                                        type="text" 
                                        class="form-control @error('name') is-invalid @enderror" 
                                        id="name"
                                        name="name" 
                                        value="{{ old('name', $user['name']) }}" 
                                        placeholder="Enter full name"
                                        required
                                    >
                                    @error('name')
                                        <div class="invalid-feedback"><i class="bi bi-exclamation-circle-fill"></i> {{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group-wrapper">
                                    <label for="email">
                                        <i class="bi bi-envelope"></i> Email Address
                                    </label>
                                    <input 
                                        type="email" 
                                        class="form-control @error('email') is-invalid @enderror" 
                                        id="email"
                                        name="email" 
                                        value="{{ old('email', $user['email']) }}" 
                                        placeholder="Enter email address"
                                        required
                                    >
                                    @error('email')
                                        <div class="invalid-feedback"><i class="bi bi-exclamation-circle-fill"></i> {{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="divider"></div>

                                <!-- Permissions Section -->
                                <h5 class="section-title">
                                    <i class="bi bi-shield-check"></i> Permissions & Access
                                </h5>

                                <div class="form-group-wrapper">
                                    <label for="role">
                                        <i class="bi bi-shield"></i> User Role
                                    </label>
                                    <select 
                                        class="form-select @error('role') is-invalid @enderror" 
                                        id="role"
                                        name="role" 
                                        required
                                    >
                                        <option value="user" {{ (old('role', $user['role']) === 'user') ? 'selected' : '' }}>
                                            👤 User - Standard Access
                                        </option>
                                        <option value="manager" {{ (old('role', $user['role']) === 'manager') ? 'selected' : '' }}>
                                            👨‍💼 Manager - Extended Access
                                        </option>
                                        <option value="admin" {{ (old('role', $user['role']) === 'admin') ? 'selected' : '' }}>
                                            👑 Admin - Full Access
                                        </option>
                                    </select>
                                    @error('role')
                                        <div class="invalid-feedback"><i class="bi bi-exclamation-circle-fill"></i> {{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="divider"></div>

                                <!-- Security Section -->
                                <h5 class="section-title">
                                    <i class="bi bi-lock-fill"></i> Security & Password
                                </h5>

                                <div class="password-section">
                                    <div class="password-info">
                                        <i class="bi bi-info-circle"></i>
                                        Leave password fields empty to keep the current password
                                    </div>

                                    <div class="form-group-wrapper">
                                        <label for="password">
                                            <i class="bi bi-key"></i> New Password
                                        </label>
                                        <input 
                                            type="password" 
                                            class="form-control @error('password') is-invalid @enderror" 
                                            id="password"
                                            name="password" 
                                            placeholder="Enter new password (min 6 characters)"
                                        >
                                        @error('password')
                                            <div class="invalid-feedback"><i class="bi bi-exclamation-circle-fill"></i> {{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group-wrapper">
                                        <label for="password_confirmation">
                                            <i class="bi bi-key-fill"></i> Confirm Password
                                        </label>
                                        <input 
                                            type="password" 
                                            class="form-control @error('password_confirmation') is-invalid @enderror" 
                                            id="password_confirmation"
                                            name="password_confirmation" 
                                            placeholder="Confirm new password"
                                        >
                                        @error('password_confirmation')
                                            <div class="invalid-feedback"><i class="bi bi-exclamation-circle-fill"></i> {{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="divider"></div>

                                <!-- Account Details Section -->
                                <h5 class="section-title">
                                    <i class="bi bi-info-circle"></i> Account Details
                                </h5>

                                <div class="account-info">
                                    <div class="info-row">
                                        <strong><i class="bi bi-calendar-event"></i> Created On:</strong>
                                        <span>{{ isset($user['created_at']) ? date('M d, Y \\a\\t H:i', strtotime($user['created_at'])) : 'N/A' }}</span>
                                    </div>
                                    <div class="info-row" style="border-top: 1px solid rgba(72, 187, 120, 0.2); padding-top: 0.75rem; margin-top: 0.75rem;">
                                        <strong><i class="bi bi-arrow-clockwise"></i> Last Updated:</strong>
                                        <span>{{ isset($user['updated_at']) ? date('M d, Y \\a\\t H:i', strtotime($user['updated_at'])) : 'N/A' }}</span>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="button-group">
                                    <button type="submit" class="btn-update">
                                        <i class="bi bi-check-circle"></i> Update User
                                    </button>
                                    <a href="{{ route('admin.users.index') }}" class="btn-back">
                                        <i class="bi bi-arrow-left"></i> Back to Users
                                    </a>
                                </div>
                            </form>
                        </div>
                    @else
                        <div class="edit-body">
                            <div class="error-alert">
                                <strong><i class="bi bi-exclamation-circle"></i> Error!</strong> Unable to load user information.
                            </div>
                            <a href="{{ route('admin.users.index') }}" class="btn-back">
                                <i class="bi bi-arrow-left"></i> Back to Users
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
