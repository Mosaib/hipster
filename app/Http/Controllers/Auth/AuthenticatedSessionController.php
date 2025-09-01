<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // $request->authenticate();

        // $request->session()->regenerate();

        // return redirect()->intended(route('dashboard', absolute: false));
        $credentials = $request->only('email', 'password');
        $user = \App\Models\User::where('email', $credentials['email'])->first();

        if (!$user) {
            return back()->withErrors([
                'email' => 'These credentials do not match our records.',
            ]);
        }

        if ($user->user_type === 'admin') {
            if (Auth::guard('admin')->attempt($credentials, $request->boolean('remember'))) {
                $request->session()->regenerate();
                return redirect()->route('admin.dashboard');
            }
        }

        if ($user->user_type === 'customer') {
            if (Auth::guard('customer')->attempt($credentials, $request->boolean('remember'))) {
                $request->session()->regenerate();
                return redirect()->route('customer.dashboard');
            }
        }

        return back()->withErrors([
            'email' => 'Invalid credentials provided.',
            ]);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Auth::guard('web')->logout();
        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->user()->update(['is_online' => false]);
            Auth::guard('admin')->logout();
        }

        if (Auth::guard('customer')->check()) {
            Auth::guard('customer')->user()->update(['is_online' => false]);
            Auth::guard('customer')->logout();
        }

        $request->session()->invalidate();

        $request->session()->regenerateToken();
        // event(new \App\Events\UserOffline($user));

        return redirect('/dashboard');
    }
}
