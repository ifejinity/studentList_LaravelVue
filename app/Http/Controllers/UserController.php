<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // login
    public function login(Request $request) {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        $remembered = $request->remember != false;
        if(Auth::attempt($validated, $remembered)) {
            $request->session()->regenerate();
            return redirect('/home');
        } else {
            return redirect()->back()->withErrors(['message' => 'Authentication failed. Please check your credentials.']);
        }
    }
    // logout
    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/index');
    }
}
