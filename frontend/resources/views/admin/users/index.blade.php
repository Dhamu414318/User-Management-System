@extends('layouts.app')
@section('title', 'Manage Users - User Management System')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="mb-0"><i class="bi bi-people"></i> User Management</h1>
    <a href="{{ route('admin.users.create') }}" class="btn btn-success btn-lg">
        <i class="bi bi-person-plus"></i> Add New User
    </a>
</div>

<!-- Search Box -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.users.search') }}" class="d-flex gap-2">
            <div class="search-box flex-grow-1">
                <i class="bi bi-search"></i>
                <input 
                    type="text"
                    name="search" 
                    class="form-control" 
                    placeholder="Search by name, email, or role..." 
                    value="{{ $search ?? '' }}"
                >
            </div>
            <button class="btn btn-primary" type="submit">
                <i class="bi bi-search"></i> Search
            </button>
            @if(isset($search) && $search)
                <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-x"></i> Clear
                </a>
            @endif
        </form>
    </div>
</div>

<!-- Users Table -->
@if(!empty($users) && count($users) > 0)
    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th><i class="bi bi-hash"></i> ID</th>
                        <th><i class="bi bi-person"></i> Name</th>
                        <th><i class="bi bi-envelope"></i> Email</th>
                        <th><i class="bi bi-briefcase"></i> Role</th>
                        <th><i class="bi bi-calendar"></i> Created At</th>
                        <th style="text-align: center;"><i class="bi bi-gear"></i> Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td class="fw-bold">{{ $user['id'] }}</td>
                            <td>{{ $user['name'] }}</td>
                            <td>
                                <a href="mailto:{{ $user['email'] }}" class="text-decoration-none">
                                    {{ $user['email'] }}
                                </a>
                            </td>
                            <td>
                                @php
                                    $role = $user['role'] ?? 'user';
                                    $badgeClass = $role === 'admin' ? 'badge-admin' : ($role === 'manager' ? 'badge-manager' : 'badge-user');
                                @endphp
                                <span class="badge {{ $badgeClass }}">{{ ucfirst($role) }}</span>
                            </td>
                            <td>
                                <small class="text-muted">
                                    {{ isset($user['created_at']) ? date('M d, Y', strtotime($user['created_at'])) : 'N/A' }}
                                </small>
                            </td>
                            <td style="text-align: center;">
                                <a href="{{ route('admin.users.edit', $user['id']) }}" class="btn btn-sm btn-info" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form method="POST" action="{{ route('admin.users.destroy', $user['id']) }}" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                    @csrf
                                    <button class="btn btn-sm btn-danger" type="submit" title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @if(!empty($meta))
        <nav aria-label="Page navigation" class="mt-4">
            <ul class="pagination justify-content-center">
                @if($meta['current_page'] > 1)
                    <li class="page-item">
                        <a class="page-link" href="{{ route('admin.users.index', ['page' => 1]) }}">
                            <i class="bi bi-chevron-bar-left"></i> First
                        </a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="{{ route('admin.users.index', ['page' => $meta['current_page'] - 1]) }}">
                            <i class="bi bi-chevron-left"></i> Previous
                        </a>
                    </li>
                @endif

                @for($i = max(1, $meta['current_page'] - 2); $i <= min($meta['last_page'], $meta['current_page'] + 2); $i++)
                    <li class="page-item {{ $i == $meta['current_page'] ? 'active' : '' }}">
                        <a class="page-link" href="{{ route('admin.users.index', ['page' => $i]) }}">
                            {{ $i }}
                        </a>
                    </li>
                @endfor

                @if($meta['current_page'] < $meta['last_page'])
                    <li class="page-item">
                        <a class="page-link" href="{{ route('admin.users.index', ['page' => $meta['current_page'] + 1]) }}">
                            Next <i class="bi bi-chevron-right"></i>
                        </a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="{{ route('admin.users.index', ['page' => $meta['last_page']]) }}">
                            Last <i class="bi bi-chevron-bar-right"></i>
                        </a>
                    </li>
                @endif
            </ul>
        </nav>

        <div class="text-center mt-3 text-muted">
            <small>
                Showing {{ count($users) }} of {{ $meta['total'] }} users 
                (Page {{ $meta['current_page'] }} of {{ $meta['last_page'] }})
            </small>
        </div>
    @endif
@else
    <div class="alert alert-info alert-dismissible fade show" role="alert">
        <i class="bi bi-info-circle"></i>
        <strong>No Users Found!</strong>
        @if(isset($search) && $search)
            No results found for "{{ $search }}". 
            <a href="{{ route('admin.users.index') }}" class="alert-link">View all users</a>
        @else
            No users in the system yet. 
            <a href="{{ route('admin.users.create') }}" class="alert-link">Create the first user</a>
        @endif
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif
@endsection
