<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Services\ApiService;
use Illuminate\Http\Request;
use Exception;

class AuthController extends Controller
{
    protected $apiService;

    public function __construct(ApiService $apiService)
    {
        $this->apiService = $apiService;
    }

    /**
     * Show login form
     */
    public function showLogin()
    {
        if (session()->has('api_token')) {
            return redirect()->route('dashboard');
        }

        try {
            $captcha = $this->apiService->getCaptcha();
        } catch (Exception $e) {
            $captcha = null;
        }

        return view('auth.login', [
            'captcha' => $captcha,
        ]);
    }

    /**
     * Handle login
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
            'captcha_key' => 'required',
            'captcha_answer' => 'required',
        ]);

        try {
            $response = $this->apiService->login(
                $request->email,
                $request->password,
                $request->captcha_key,
                $request->captcha_answer
            );

            // Store token and user info in session
            session()->put('api_token', $response['token']);
            session()->put('user_id', $response['user']['id']);
            session()->put('user_name', $response['user']['name']);
            session()->put('user_email', $response['user']['email']);
            session()->put('user_role', $response['user']['role']);

            return redirect()->route('dashboard')->with('success', 'Login successful!');
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
     * Show register form
     */
    public function showRegister()
    {
        if (session()->has('api_token')) {
            return redirect()->route('dashboard');
        }

        try {
            $captcha = $this->apiService->getCaptcha();
        } catch (Exception $e) {
            $captcha = null;
        }

        return view('auth.register', [
            'captcha' => $captcha,
        ]);
    }

    /**
     * Handle registration
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:3',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
            'captcha_key' => 'required',
            'captcha_answer' => 'required',
        ]);

        try {
            $response = $this->apiService->register(
                $request->name,
                $request->email,
                $request->password,
                $request->captcha_key,
                $request->captcha_answer
            );

            // Store token and user info in session
            session()->put('api_token', $response['token']);
            session()->put('user_id', $response['user']['id']);
            session()->put('user_name', $response['user']['name']);
            session()->put('user_email', $response['user']['email']);
            session()->put('user_role', $response['user']['role']);

            return redirect()->route('dashboard')->with('success', 'Registration successful!');
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
     * Show dashboard
     */
    public function dashboard()
    {
        $user = [
            'id' => session()->get('user_id'),
            'name' => session()->get('user_name'),
            'email' => session()->get('user_email'),
            'role' => session()->get('user_role'),
        ];

        return view('dashboard', ['user' => $user]);
    }

    /**
     * Handle logout
     */
    public function logout(Request $request)
    {
        try {
            $this->apiService->logout();
        } catch (Exception $e) {
            // Continue logout even if API call fails
        }

        // Clear session
        session()->flush();

        return redirect()->route('login')->with('success', 'Logged out successfully');
    }
}
