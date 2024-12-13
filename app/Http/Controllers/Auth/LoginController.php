<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            if ($user->isAdmin()) {
                return redirect()->intended('/admin');
            }
            // If not admin, logout and redirect back with error
            Auth::logout();
            return back()->withErrors([
                'erreur' => 'Seuls les administrateurs peuvent se connecter',
            ]);
        }

        return back()->withErrors([
            'erreur' => 'Email ou mot de passe incorrect',
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
