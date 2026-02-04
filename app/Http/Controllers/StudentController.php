<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class StudentController extends Controller
{
    /* ---------- STUDENT SELF-REGISTRATION ---------- */
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:students,email',
            'phone'    => 'required|string|max:20',
            'password' => 'required|string|min:6',
        ]);

        Student::create([
            'name'       => $request->name,
            'email'      => $request->email,
            'phone'      => $request->phone,
            'password'   => Hash::make($request->password),
            'teacher_id' => null, // Nullable for self-registered students
        ]);

        return redirect()->route('students.login')
            ->with('success', 'Registered successfully. Please login.');
    }

    /* ---------- STUDENT LOGIN ---------- */
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $student = Student::where('email', $request->email)->first();

        if (!$student) {
            return back()->with('error', 'You are not registered. Please register first.');
        }

        if (!Hash::check($request->password, $student->password)) {
            return back()->with('error', 'Invalid password.');
        }

        // Store session
        Session::put('student_id', $student->id);
        Session::put('student_name', $student->name);

        return redirect()->route('students.dashboard');
    }

    /* ---------- STUDENT DASHBOARD ---------- */
    public function dashboard()
    {
        if (!Session::has('student_id')) {
            return redirect()->route('students.login')
                             ->with('error', 'Please login first.');
        }

        // Get logged-in student info
        $student = Student::find(Session::get('student_id'));

        return view('students.dashboard', compact('student'));
    }

    /* ---------- STUDENT LOGOUT ---------- */
    public function logout()
    {
        Session::forget(['student_id', 'student_name']);
        return redirect()->route('students.login')
                         ->with('success', 'Logged out successfully.');
    }

    /* ---------- OPTIONAL: Update Self Info ---------- */
    public function update(Request $request)
    {
        if (!Session::has('student_id')) {
            return redirect()->route('students.login')
                             ->with('error', 'Please login first.');
        }

        $student = Student::find(Session::get('student_id'));

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:students,email,' . $student->id,
            'phone'    => 'nullable|string|max:20',
            'password' => 'nullable|string|min:6',
        ]);

        $student->name  = $request->name;
        $student->email = $request->email;
        $student->phone = $request->phone;

        if ($request->filled('password')) {
            $student->password = Hash::make($request->password);
        }

        $student->save();

        return back()->with('success', 'Profile updated successfully.');
    }
}
