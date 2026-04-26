<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Utilisateur;

class AuthController extends Controller
{
    /**
     * Show the login form.
     */
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }

    /**
     * Handle authentication.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = Utilisateur::where('email', $credentials['email'])->first();

        if ($user && Hash::check($credentials['password'], $user->mot_de_passe)) {
            if ($user->etat !== 'actif') {
                return back()->with('error', 'Votre compte est ' . $user->etat . '.');
            }

            Auth::login($user, $request->has('remember'));
            $request->session()->regenerate();

            // Update last login
            $user->update(['derniere_connexion_at' => now()]);

            return redirect()->intended('dashboard');
        }

        return back()->with('error', 'Les identifiants fournis ne correspondent pas à nos enregistrements.')->onlyInput('email');
    }

    /**
     * Log the user out.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Vous avez été déconnecté avec succès.');
    }
}
