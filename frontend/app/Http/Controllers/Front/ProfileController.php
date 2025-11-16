<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Services\ApiService;
use Illuminate\Http\Request;
use Exception;

class ProfileController extends Controller
{
    protected $apiService;

    public function __construct(ApiService $apiService)
    {
        $this->apiService = $apiService;
    }

    /**
     * Show user profile
     */
    public function show()
    {
        try {
            $profile = $this->apiService->getProfile();
            return view('profile.show', ['profile' => $profile]);
        } catch (Exception $e) {
            return redirect()->route('dashboard')->with('error', 'Unable to load profile: ' . $e->getMessage());
        }
    }

    /**
     * Update user profile
     */
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:3',
            'email' => 'required|email',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        try {
            $profile = $this->apiService->updateProfile(
                $request->name,
                $request->email,
                $request->password
            );

            // Update session with new user info
            session()->put('user_name', $profile['name']);
            session()->put('user_email', $profile['email']);

            return redirect()->route('profile.show')->with('success', 'Profile updated successfully!');
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
}
