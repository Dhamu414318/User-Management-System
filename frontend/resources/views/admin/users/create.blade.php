@extends('layouts.app')
@section('title', 'Create New User - User Management System')

@section('content')
<style>
    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .create-container {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
        display: flex;
        align-items: center;
        padding: 2rem 1rem;
        animation: fadeIn 0.5s ease-in;
    }

    .create-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        max-width: 600px;
        width: 100%;
        animation: slideUp 0.6s ease-out;
    }

    .create-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 3rem;
        border-radius: 20px 20px 0 0;
        position: relative;
        overflow: hidden;
        color: white;
    }

    .create-header::before {
        content: '';
        position: absolute;
        width: 400px;
        height: 400px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        top: -50px;
        right: -50px;
    }

    .create-header h2 {
        font-size: 2rem;
        font-weight: 700;
        margin: 0;
        position: relative;
        z-index: 2;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .create-header p {
        margin: 0.5rem 0 0 0;
        position: relative;
        z-index: 2;
        font-size: 0.95rem;
        opacity: 0.95;
    }

    .create-body {
        padding: 3rem;
    }

    .form-section {
        margin-bottom: 2.5rem;
    }

    .form-section:last-of-type {
        margin-bottom: 1rem;
    }

    .form-section-title {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-size: 1.1rem;
        font-weight: 700;
        color: #2d3748;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid transparent;
        background: linear-gradient(to right, #667eea, #764ba2);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .form-section-title i {
        font-size: 1.3rem;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group label {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-weight: 600;
        color: #2d3748;
        margin-bottom: 0.75rem;
        font-size: 0.95rem;
    }

    .form-group label i {
        color: #667eea;
        font-size: 1.1rem;
    }

    .form-group label .required {
        color: #f56565;
        font-weight: 700;
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
        width: 100%;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        padding: 0.875rem 1rem;
        background: #f8fafc;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        color: #2d3748;
    }

    .form-group input::placeholder,
    .form-group textarea::placeholder {
        color: #cbd5e0;
    }

    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: #667eea;
        background: white;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .form-group small {
        display: block;
        margin-top: 0.5rem;
        font-size: 0.85rem;
        color: #718096;
    }

    .form-group small.text-danger {
        color: #f56565;
        font-weight: 500;
    }

    .alert-section {
        background: linear-gradient(135deg, rgba(245, 101, 101, 0.1) 0%, rgba(245, 101, 101, 0.05) 100%);
        border-left: 4px solid #f56565;
        border-radius: 8px;
        padding: 1.25rem;
        margin-bottom: 2rem;
        animation: slideDown 0.3s ease-out;
    }

    .alert-section strong {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: #c53030;
        margin-bottom: 0.75rem;
        font-size: 1rem;
    }

    .alert-section i {
        font-size: 1.1rem;
    }

    .alert-section ul {
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .alert-section ul li {
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        color: #c53030;
        margin-bottom: 0.5rem;
        font-size: 0.95rem;
    }

    .alert-section ul li::before {
        content: '─';
        min-width: 20px;
        font-weight: bold;
        color: #f56565;
    }

    .alert-section ul li:last-child {
        margin-bottom: 0;
    }

    .row-two-cols {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
    }

    .form-info-box {
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.05) 0%, rgba(118, 75, 162, 0.05) 100%);
        border-left: 4px solid #667eea;
        border-radius: 8px;
        padding: 1rem;
        font-size: 0.9rem;
        color: #4a5568;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-top: 0.75rem;
    }

    .form-info-box i {
        color: #667eea;
        font-size: 1.1rem;
        flex-shrink: 0;
    }

    .form-actions {
        display: flex;
        gap: 1rem;
        margin-top: 2.5rem;
        padding-top: 2rem;
        border-top: 1px solid #e2e8f0;
    }

    .btn-create {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        padding: 0.875rem 2rem;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.95rem;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
        flex: 1;
    }

    .btn-create:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
        color: white;
        text-decoration: none;
    }

    .btn-create:active {
        transform: translateY(0);
    }

    .btn-back {
        background: white;
        color: #667eea;
        border: 2px solid #667eea;
        padding: 0.875rem 2rem;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.95rem;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
        text-decoration: none;
        flex: 1;
    }

    .btn-back:hover {
        background: #667eea;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(102, 126, 234, 0.2);
    }

    .btn-back:active {
        transform: translateY(0);
    }

    @media (max-width: 768px) {
        .create-header {
            padding: 1.5rem;
        }

        .create-header h2 {
            font-size: 1.5rem;
        }

        .create-body {
            padding: 1.5rem;
        }

        .row-two-cols {
            grid-template-columns: 1fr;
            gap: 1rem;
        }

        .form-actions {
            flex-direction: column;
        }

        .btn-create,
        .btn-back {
            width: 100%;
        }
    }
</style>

<div class="create-container">
    <div class="create-card">
        <div class="create-header">
            <h2>
                <i class="bi bi-person-plus"></i>
                Create New User
            </h2>
            <p>Add a new user to your system with assigned role and permissions</p>
        </div>

        <div class="create-body">
            <form method="POST" action="{{ route('admin.users.store') }}">
                @csrf

                @if ($errors->any())
                    <div class="alert-section">
                        <strong>
                            <i class="bi bi-exclamation-circle"></i>
                            Validation Failed!
                        </strong>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Personal Information Section -->
                <div class="form-section">
                    <div class="form-section-title">
                        <i class="bi bi-person-circle"></i>
                        Personal Information
                    </div>

                    <div class="form-group">
                        <label for="name">
                            <i class="bi bi-person"></i>
                            Full Name
                            <span class="required">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="name"
                            name="name" 
                            placeholder="Enter user's full name" 
                            value="{{ old('name') }}" 
                            required
                            minlength="3"
                        >
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">
                            <i class="bi bi-envelope"></i>
                            Email Address
                            <span class="required">*</span>
                        </label>
                        <input 
                            type="email" 
                            id="email"
                            name="email" 
                            placeholder="Enter user's email" 
                            value="{{ old('email') }}" 
                            required
                        >
                        @error('email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <!-- Security & Password Section -->
                <div class="form-section">
                    <div class="form-section-title">
                        <i class="bi bi-lock-fill"></i>
                        Security & Password
                    </div>

                    <div class="row-two-cols">
                        <div class="form-group">
                            <label for="password">
                                <i class="bi bi-key"></i>
                                Password
                                <span class="required">*</span>
                            </label>
                            <input 
                                type="password" 
                                id="password"
                                name="password" 
                                placeholder="Enter a strong password" 
                                required
                            >
                            <small>Minimum 6 characters</small>
                            @error('password')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation">
                                <i class="bi bi-lock-check"></i>
                                Confirm Password
                                <span class="required">*</span>
                            </label>
                            <input 
                                type="password" 
                                id="password_confirmation"
                                name="password_confirmation" 
                                placeholder="Confirm password" 
                                required
                            >
                            @error('password_confirmation')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Permissions & Access Section -->
                <div class="form-section">
                    <div class="form-section-title">
                        <i class="bi bi-shield-check"></i>
                        Permissions & Access
                    </div>

                    <div class="form-group">
                        <label for="role">
                            <i class="bi bi-briefcase"></i>
                            User Role
                            <span class="required">*</span>
                        </label>
                        <select 
                            id="role"
                            name="role" 
                            required
                        >
                            <option value="" disabled {{ !old('role') ? 'selected' : '' }}>-- Select a role --</option>
                            <option value="user" {{ old('role') === 'user' ? 'selected' : '' }}>
                                User - Basic access to their own profile
                            </option>
                            <option value="manager" {{ old('role') === 'manager' ? 'selected' : '' }}>
                                Manager - Can manage users and view reports
                            </option>
                            <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>
                                Admin - Full system access and administration
                            </option>
                        </select>
                        <div class="form-info-box">
                            <i class="bi bi-info-circle"></i>
                            <span>Choose the appropriate role based on user responsibilities</span>
                        </div>
                        @error('role')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="form-actions">
                    <button type="submit" class="btn-create">
                        <i class="bi bi-check-circle"></i>
                        Create User
                    </button>
                    <a href="{{ route('admin.users.index') }}" class="btn-back">
                        <i class="bi bi-arrow-left"></i>
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
