<?php

namespace App\Http\Controllers;

use App\Models\Principal;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;

class PrincipalController extends Controller
{
    /* ---------- AUTH ---------- */

    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:principals,email',
            'password' => 'required|min:6',
        ]);

        Principal::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('principal.login')
            ->with('success', 'Principal registered successfully');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $principal = Principal::where('email', $request->email)->first();

        if (!$principal || !Hash::check($request->password, $principal->password)) {
            return back()->with('error', 'Invalid credentials');
        }

        Session::put('principal_id', $principal->id);
        Session::put('principal_name', $principal->name);

        return redirect()->route('principal.dashboard');
    }

    public function logout()
    {
        Session::forget(['principal_id', 'principal_name']);
        return redirect()->route('principal.login');
    }

    /* ---------- DASHBOARD ---------- */

    public function dashboard()
    {
        if (!Session::has('principal_id')) {
            return redirect()->route('principal.login');
        }

        // STUDENTS FIRST
        $students = Student::orderBy('id', 'desc')->get();

        // TEACHERS SECOND
        $teachers = Teacher::orderBy('id', 'desc')->get();

        return view('principal.dashboard', compact('students', 'teachers'));
    }

    /* ---------- STUDENT MANAGEMENT ---------- */

    public function updateStudent(Request $request, $id)
    {
        $student = Student::findOrFail($id);

        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('students')->ignore($student->id),
            ],
            'phone' => 'nullable|string|max:20',
        ]);

        $student->update($request->only('name', 'email', 'phone'));

        return back()->with('success', 'Student updated by Principal');
    }

    public function deleteStudent($id)
    {
        Student::findOrFail($id)->delete();
        return back()->with('success', 'Student deleted by Principal');
    }

    /* ---------- TEACHER MANAGEMENT ---------- */

    public function updateTeacher(Request $request, $id)
    {
        $teacher = Teacher::findOrFail($id);

        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('teachers')->ignore($teacher->id),
            ],
        ]);

        $teacher->update($request->only('name', 'email'));

        return back()->with('success', 'Teacher updated by Principal');
    }

    public function deleteTeacher($id)
    {
        Teacher::findOrFail($id)->delete();
        return back()->with('success', 'Teacher deleted by Principal');
    }
}
