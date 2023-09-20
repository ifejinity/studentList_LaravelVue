<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class StudentController extends Controller
{
    public function inputValidation($request) {
        $validated = $request->validate([
            'student_type' => 'required|in:local,foreign',
            'mobile_number' => [
                'required', 'min:11', 'max:11', 'regex:#(09|\+639|\+63|0)[0-9]{9}#',
                Rule::unique('students', 'mobile_number')
                    ->where('name', $request->name)
                    ->ignore($request->id_number, 'id_number'),
            ],
            'name' => [
                'required','min:6',
                Rule::unique('students', 'name')
                    ->where('mobile_number', $request->mobile_number)
                    ->ignore($request->id_number, 'id_number'),
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
            'method' => 'create',
            'student' => []
        ]);
    }

    public function createStudent(Request $request) {
        $validated = $this->inputValidation($request);
        Student::create($validated);
    }

    public function edit(Request $request) {
        $studentData = Student::where('id_number', $request->id_number)->get()->toArray();
        return Inertia::render('student', [
            'title' => 'Student list | edit',
            'header' => 'Edit student',
            'method' => 'edit',
            'student' => $studentData[0]
        ]);
    }

    public function editStudent(Request $request) {
        $validated = $this->inputValidation($request);
        Student::where('id_number', $request->id_number)->update($validated);
    }

    public function delete(Request $request) {
        if ($request->route()->uri() == 'delete') {
            Student::where('id_number', $request->id_number)->delete();
        } else if ($request->route()->uri() == 'multiDelete') {
            $request->validate([
                "id_number" => 'required'
            ]);
            Student::whereIn('id_number', $request->id_number)->delete();
        }
    }
}

