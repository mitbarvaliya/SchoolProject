<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;

class TeacherController extends Controller
{
    /* ---------- AUTH ---------- */

    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:teachers,email',
            'password' => 'required|min:6',
        ]);

        Teacher::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('teacher.login')
            ->with('success', 'Registration successful. Please login.');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $teacher = Teacher::where('email', $request->email)->first();

        if (!$teacher || !Hash::check($request->password, $teacher->password)) {
            return back()->with('error', 'Invalid email or password');
        }

        Session::put('teacher_id', $teacher->id);
        Session::put('teacher_name', $teacher->name);

        return redirect()->route('teacher.dashboard');
    }

    public function logout()
    {
        Session::forget(['teacher_id', 'teacher_name']);
        return redirect()->route('teacher.login');
    }

    /* ---------- DASHBOARD ---------- */

    public function dashboard()
    {
        if (!Session::has('teacher_id')) {
            return redirect()->route('teacher.login');
        }

        // Show all students (including self-registered ones)
        $students = Student::orderBy('id', 'desc')->get();

        return view('teacher.dashboard', compact('students'));
    }

    /* ---------- STUDENT CRUD ---------- */

    public function storeStudent(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:students,email',
            'phone'    => 'nullable|string|max:20',
            'password' => 'required|min:6',
        ]);

        Student::create([
            'teacher_id' => Session::get('teacher_id'),
            'name'       => $request->name,
            'email'      => $request->email,
            'phone'      => $request->phone,
            'password'   => Hash::make($request->password),
        ]);

        return back()->with('success', 'Student added successfully');
    }

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

        $student->update([
            'name'  => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        return back()->with('success', 'Student updated successfully');
    }

    public function deleteStudent($id)
    {
        $student = Student::findOrFail($id);
        $student->delete();

        return back()->with('success', 'Student deleted successfully');
    }
}
