<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

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
            return Inertia::render('home', [
                'student' => Student::all()
            ]);
        }
    }
}
