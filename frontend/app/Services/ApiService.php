<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Exception;

class ApiService
{
    protected $baseUrl;

    public function __construct()
    {
        $this->baseUrl = env('BACKEND_URL', 'http://127.0.0.1:8000');
    }

    /**
     * Get authorization headers with token
     */
    protected function getHeaders()
    {
        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];

        if (Session::has('api_token')) {
            $headers['Authorization'] = 'Bearer ' . Session::get('api_token');
        }

        return $headers;
    }

    /**
     * Make API request
     */
    protected function request($method, $endpoint, $data = [])
    {
        try {
            $url = rtrim($this->baseUrl, '/') . '/' . ltrim($endpoint, '/');
            
            $response = Http::withHeaders($this->getHeaders())->timeout(30);

            switch ($method) {
                case 'GET':
                    $response = $response->get($url, $data);
                    break;
                case 'POST':
                    $response = $response->post($url, $data);
                    break;
                case 'PUT':
                    $response = $response->put($url, $data);
                    break;
                case 'DELETE':
                    $response = $response->delete($url, $data);
                    break;
                default:
                    throw new Exception('Invalid HTTP method');
            }

            return $response;
        } catch (Exception $e) {
            throw new Exception('API Request failed: ' . $e->getMessage());
        }
    }

    /**
     * Generate captcha
     */
    public function getCaptcha()
    {
        $response = $this->request('GET', 'api/auth/captcha');
        
        if ($response->successful()) {
            return $response->json();
        }

        throw new Exception('Failed to get captcha');
    }

    /**
     * Register user
     */
    public function register($name, $email, $password, $captchaKey, $captchaAnswer)
    {
        $response = $this->request('POST', 'api/auth/register', [
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'password_confirmation' => $password,
            'captcha_key' => $captchaKey,
            'captcha_answer' => $captchaAnswer,
        ]);

        if ($response->successful()) {
            return $response->json();
        }

        if ($response->status() === 422) {
            throw new Exception(json_encode($response->json()['errors'] ?? ['error' => 'Validation failed']));
        }

        throw new Exception($response->json()['message'] ?? 'Registration failed');
    }

    /**
     * Login user
     */
    public function login($email, $password, $captchaKey, $captchaAnswer)
    {
        $response = $this->request('POST', 'api/auth/login', [
            'email' => $email,
            'password' => $password,
            'captcha_key' => $captchaKey,
            'captcha_answer' => $captchaAnswer,
        ]);

        if ($response->successful()) {
            return $response->json();
        }

        if ($response->status() === 422) {
            throw new Exception(json_encode($response->json()['errors'] ?? ['error' => 'Validation failed']));
        }

        throw new Exception($response->json()['message'] ?? 'Login failed');
    }

    /**
     * Get current user
     */
    public function getCurrentUser()
    {
        $response = $this->request('GET', 'api/auth/user');

        if ($response->successful()) {
            return $response->json()['user'] ?? null;
        }

        throw new Exception('Failed to get user info');
    }

    /**
     * Logout user
     */
    public function logout()
    {
        $response = $this->request('POST', 'api/auth/logout');

        if ($response->successful()) {
            return $response->json();
        }

        throw new Exception('Logout failed');
    }

    /**
     * Get user profile
     */
    public function getProfile()
    {
        $response = $this->request('GET', 'api/user/profile');

        if ($response->successful()) {
            return $response->json()['user'] ?? null;
        }

        throw new Exception('Failed to get profile');
    }

    /**
     * Update user profile
     */
    public function updateProfile($name, $email, $password = null)
    {
        $data = [
            'name' => $name,
            'email' => $email,
        ];

        if (!empty($password)) {
            $data['password'] = $password;
            $data['password_confirmation'] = $password;
        }

        $response = $this->request('PUT', 'api/user/profile', $data);

        if ($response->successful()) {
            return $response->json()['user'] ?? null;
        }

        if ($response->status() === 422) {
            throw new Exception(json_encode($response->json()['errors'] ?? ['error' => 'Validation failed']));
        }

        throw new Exception($response->json()['message'] ?? 'Profile update failed');
    }

    /**
     * Get all users (admin)
     */
    public function getAllUsers($page = 1, $perPage = 15, $search = null)
    {
        $params = [
            'page' => $page,
            'per_page' => $perPage,
        ];

        if (!empty($search)) {
            $params['search'] = $search;
        }

        $response = $this->request('GET', 'api/admin/users', $params);

        if ($response->successful()) {
            return $response->json();
        }

        throw new Exception('Failed to get users');
    }

    /**
     * Get specific user (admin)
     */
    public function getUser($id)
    {
        $response = $this->request('GET', 'api/admin/users/' . $id);

        if ($response->successful()) {
            return $response->json()['user'] ?? null;
        }

        throw new Exception('Failed to get user');
    }

    /**
     * Create user (admin)
     */
    public function createUser($name, $email, $password, $role)
    {
        $response = $this->request('POST', 'api/admin/users', [
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'password_confirmation' => $password,
            'role' => $role,
        ]);

        if ($response->successful()) {
            return $response->json()['user'] ?? null;
        }

        if ($response->status() === 422) {
            throw new Exception(json_encode($response->json()['errors'] ?? ['error' => 'Validation failed']));
        }

        throw new Exception($response->json()['message'] ?? 'User creation failed');
    }

    /**
     * Update user (admin)
     */
    public function updateUser($id, $name, $email, $role, $password = null)
    {
        $data = [
            'name' => $name,
            'email' => $email,
            'role' => $role,
        ];

        if (!empty($password)) {
            $data['password'] = $password;
            $data['password_confirmation'] = $password;
        }

        $response = $this->request('PUT', 'api/admin/users/' . $id, $data);

        if ($response->successful()) {
            return $response->json()['user'] ?? null;
        }

        if ($response->status() === 422) {
            throw new Exception(json_encode($response->json()['errors'] ?? ['error' => 'Validation failed']));
        }

        throw new Exception($response->json()['message'] ?? 'User update failed');
    }

    /**
     * Delete user (admin)
     */
    public function deleteUser($id)
    {
        $response = $this->request('DELETE', 'api/admin/users/' . $id);

        if ($response->successful() || $response->status() === 204) {
            return $response->json()['message'] ?? 'User deleted successfully';
        }

        if ($response->status() === 403) {
            throw new Exception($response->json()['message'] ?? 'Permission denied');
        }

        throw new Exception('Failed to delete user');
    }

    /**
     * Search users (admin)
     */
    public function searchUsers($search, $page = 1, $perPage = 15)
    {
        $response = $this->request('GET', 'api/admin/users/search', [
            'search' => $search,
            'page' => $page,
            'per_page' => $perPage,
        ]);

        if ($response->successful()) {
            return $response->json();
        }

        throw new Exception('Search failed');
    }
}
