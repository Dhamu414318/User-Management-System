<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Services\ApiService;
use Illuminate\Http\Request;
use Exception;

class AdminUserController extends Controller
{
    protected $apiService;

    public function __construct(ApiService $apiService)
    {
        $this->apiService = $apiService;
    }

    /**
     * List all users with pagination
     */
    public function index(Request $request)
    {
        $page = $request->query('page', 1);
        $perPage = $request->query('per_page', 15);

        try {
            $data = $this->apiService->getAllUsers($page, $perPage);
            return view('admin.users.index', [
                'users' => $data['data'] ?? [],
                'meta' => $data['meta'] ?? [],
                'perPage' => $perPage,
            ]);
        } catch (Exception $e) {
            return back()->with('error', 'Unable to load users: ' . $e->getMessage());
        }
    }

    /**
     * Search users
     */
    public function search(Request $request)
    {
        $searchQuery = $request->query('search', '');
        $page = $request->query('page', 1);
        $perPage = $request->query('per_page', 15);

        if (empty($searchQuery)) {
            return redirect()->route('admin.users.index');
        }

        try {
            $data = $this->apiService->searchUsers($searchQuery, $page, $perPage);
            return view('admin.users.index', [
                'users' => $data['data'] ?? [],
                'meta' => $data['meta'] ?? [],
                'perPage' => $perPage,
                'search' => $searchQuery,
            ]);
        } catch (Exception $e) {
            return back()->with('error', 'Search failed: ' . $e->getMessage());
        }
    }

    /**
     * Show create user form
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store new user
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:3',
            'email' => 'required|email',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|in:user,manager,admin',
        ]);

        try {
            $this->apiService->createUser(
                $request->name,
                $request->email,
                $request->password,
                $request->role
            );

            return redirect()->route('admin.users.index')->with('success', 'User created successfully!');
        } catch (Exception $e) {
            $errorMsg = $e->getMessage();
            
            // Try to decode if it's JSON
            if (str_starts_with($errorMsg, '{')) {
                $errors = json_decode($errorMsg, true);
                return back()->withInput()->withErrors($errors);
            }

            return back()->withInput()->with('error', $errorMsg);
        }
    }

    /**
     * Show edit user form
     */
    public function edit($id)
    {
        try {
            $user = $this->apiService->getUser($id);
            return view('admin.users.edit', ['user' => $user]);
        } catch (Exception $e) {
            return back()->with('error', 'Unable to load user: ' . $e->getMessage());
        }
    }

    /**
     * Update user
     */
    public function update(Request $request, $id)
    {
        try {
            // Get current user to check email uniqueness
            $currentUser = $this->apiService->getUser($id);
            
            // Build validation rules
            $rules = [
                'name' => 'required|string|min:3',
                'role' => 'required|in:user,manager,admin',
                'password' => 'nullable|string|min:6|confirmed',
            ];
            
            // Only validate email uniqueness if it changed
            if ($request->email !== $currentUser['email']) {
                $rules['email'] = 'required|email|unique:users,email';
            } else {
                $rules['email'] = 'required|email';
            }
            
            $request->validate($rules);

            $this->apiService->updateUser(
                $id,
                $request->name,
                $request->email,
                $request->role,
                $request->password
            );

            return redirect()->route('admin.users.index')->with('success', 'User updated successfully!');
        } catch (Exception $e) {
            $errorMsg = $e->getMessage();
            
            // Try to decode if it's JSON
            if (str_starts_with($errorMsg, '{')) {
                $errors = json_decode($errorMsg, true);
                return back()->withInput()->withErrors($errors);
            }

            return back()->withInput()->with('error', $errorMsg);
        }
    }

    /**
     * Delete user
     */
    public function destroy($id)
    {
        try {
            $this->apiService->deleteUser($id);
            return redirect()->route('admin.users.index')->with('success', 'User deleted successfully!');
        } catch (Exception $e) {
            return back()->with('error', 'Failed to delete user: ' . $e->getMessage());
        }
    }
}
