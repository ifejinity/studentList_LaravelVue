<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class StudentController extends Controller
{
    public function inputValidation($request, $numberId = null) {
        $validated = $request->validate([
            'student_type' => 'required|in:local,foreign',
            'mobile_number' => [
                'required', 'min:11', 'max:11', 'regex:#(09|\+639|\+63|0)[0-9]{9}#',
                Rule::unique('students', 'mobile_number')
                    ->where('name', $request->name)
                    ->ignore($numberId, 'id_number'),
            ],
            'name' => [
                'required','min:6',
                Rule::unique('students', 'name')
                    ->where('mobile_number', $request->mobile_number)
                    ->ignore($numberId, 'id_number'),
            ],
            'age' => 'required|integer|between:1,99',
            'gender' => 'in:male,female',
            'city' => 'required',
            'grades' => 'required|numeric|between:0,100',
            'email' => 'required|email'
        ], 
        // custom message
        [
            'name.unique' => 'Already registered with the same number.',
            'mobile_number.unique' => 'Already registered with the same name.',
        ]);
        return $validated;
    }

    public function index() {
        return Inertia::render('home',[
            'student' => Student::all()
        ]);
    }

    public function create() {
        return Inertia::render('student', [
            'title' => 'Student list | create',
            'header' => 'Add student',
            'method' => 'create'
        ]);
    }

    public function createStudent(Request $request) {
        $validated = $this->inputValidation($request);
        Student::create($validated);
    }

    public function edit(Request $request) {
        $studentData = Student::where('id_number', $request->id_number)->get();
        return Inertia::render('student', [
            'title' => 'Student list | edit',
            'header' => 'Edit student',
            'method' => 'edit',
            'student' => $studentData
        ]);
    }

    public function delete(Request $request) {
        Student::where('id_number', $request->id_number)->delete();
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/index');
    }
}

