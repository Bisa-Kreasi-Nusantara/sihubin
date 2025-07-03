<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use \App\Models\Student;
use \App\Models\InternshipRequest;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:dashboard.view');
    }

    public function index()
    {

        $students = Student::get()->count();
        $internship_request  = InternshipRequest::query()->with('user', 'company');
        $data = array(
            'student_count'         => $students,
            'internship_requests'   => $internship_request->orderBy('created_at', 'desc')->limit(5)->get(),
            'pending_request'       => $internship_request->where('status', 'pending')->get()->count()
        );

        return view('dashboard', compact('data'));
    }
}
