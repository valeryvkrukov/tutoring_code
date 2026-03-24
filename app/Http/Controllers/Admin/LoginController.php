<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Show the admin login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        if (Auth::check() && Auth::user()->isAdmin()) {
            return redirect()->intended('dashboard/view_sessions');
        }

        return view('admin.login-page');
    }

    /**
     * Handle the admin login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request) {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $remember = $request->filled('remember');

        if (Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password'], 'role' => 'admin'], $remember)) {
            $user = Auth::user();

            // temporary
            session(['sct_admin' => $user]); 

            if ($user->status === 'inactive') {
                Auth::logout();

                return back()->withErrors(['loginAlert' => 'Your account has been disabled by an administrator.']);
            }

            $request->session()->regenerate();

            return redirect()->intended('dashboard/view_sessions');
        }

        return back()
            ->with('loginAlert', 'Invalid email or password.')
            ->withInput($request->only('email'));
    }

    /**
     * Log the admin out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request) {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('admin/login');
    }
}
