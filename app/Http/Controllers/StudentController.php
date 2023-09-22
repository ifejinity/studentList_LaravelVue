<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
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
                    ->ignore($request->id, 'id'),
            ],
            'name' => [
                'required','min:6',
                Rule::unique('students', 'name')
                    ->where('mobile_number', $request->mobile_number)
                    ->ignore($request->id, 'id'),
            ],
            'age' => 'required|integer|between:1,99',
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

    public function index(Request $request) {
        // dd($request);
        if($request->student_type === null) {
            $studentData = Student::where('name', 'like', '%' . $request->search . '%')
                                ->orWhere('id', 'like',  $request->search . '%')
                                ->orderBy('updated_at', 'desc')->get();
        } else {
            $studentData = Student::where('student_type', $request->student_type)
                                ->where('name', 'like', '%' . $request->search . '%')
                                ->orWhere('id', 'like',  $request->search . '%')
                                ->orderBy('updated_at', 'desc')->get();
        }
        return Inertia::render('home',[
            'student' => $studentData,
            'type' => $request->student_type
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
        $data = Arr::add($validated, 'gender', $request->gender);
        Student::create($data);
        return redirect('/home');
    }

    public function edit($id) {
        $studentData = Student::findOrFail($id);
        return Inertia::render('student', [
            'title' => 'Student list | edit',
            'header' => 'Edit student',
            'method' => 'edit',
            'student' => $studentData
        ]);
    }

    public function editStudent(Request $request) {
        $validated = $this->inputValidation($request);
        $data = Arr::add($validated, 'gender', $request->gender);
        Student::where('id', $request->id)->update($data);
        return redirect('/home');
    }

    public function delete(Request $request) {
        if ($request->route()->uri() == 'delete') {
            Student::find($request->id)->delete();
        } else if ($request->route()->uri() == 'multiDelete') {
            $request->validate([
                "id" => 'required'
            ]);
            Student::whereIn('id', $request->id)->delete();
        }
    }
}