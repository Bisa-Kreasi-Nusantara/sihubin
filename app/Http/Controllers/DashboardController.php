<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use \App\Models\Student;
use \App\Models\InternshipRequest;
use \App\Models\InternshipSchedule;
use \App\Models\Company;

use Auth;

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
        $internship = InternshipSchedule::query()->where('is_finished', false)->get();
        $users      = Student::whereNotIn('users_id', $internship->pluck('users_id'))->get()->count();
        $companies = Company::get()->count();

        if (Auth::user()->role->name == "student") {
            $internship_request = $internship_request->where("users_id", Auth::user()->id);
        }

        $data = array(
            'student_count'         => $students,
            'internship_requests'   => $internship_request->orderBy('created_at', 'desc')->limit(5)->get(),
            'pending_request'       => $internship_request->where('status', 'pending')->get()->count(),
            'internship_user_count' => $internship->count(),
            'not_internship_user_count' => $users,
            'company_count' => $companies,
        );

        return view('dashboard', compact('data'));
    }
}
