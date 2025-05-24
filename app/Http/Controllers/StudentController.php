<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use App\Models\User;
use App\Models\Student;
use App\Models\Major;

use App\Imports\StudentImport;
use Maatwebsite\Excel\Facades\Excel;

use DB;
use Auth;
use Hash;

class StudentController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:student_management.view');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $students = User::query()->with('role', 'student', 'student.major')->whereHas('role', function($q) {
            return $q->where('name', 'student');
        });

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $students->where(function($query) use ($search) {
                $query->where('fullname', 'like', '%' . $search . '%')
                      ->orWhere('email', 'like', '%' . $search . '%');
            });
        }

        $students = $students->get();

        return view('students-management.index', compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $majors = Major::all();
        return view('students-management.create', compact('majors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $user = [
                'roles_id'  => 3,
                'fullname'  => $request->fullname,
                'email'     => $request->email,
                'password'  => Hash::make($request->password),
                'created_by'    => Auth::user()->id,
            ];

            $user = User::create($user);

            $student = [
                'users_id'      => $user->id,
                'majors_id'     => $request->majors_id,
                'nis'           => $request->nis,
                'address'       => $request->address,
                'avg_scores'    => $request->avg_scores,
                'created_by'    => Auth::user()->id,
            ];

            Student::create($student);

            DB::commit();

            return redirect()->route('students-management.index')->withSuccess("Success create new student");
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
        return $request->all();
    }

    public function upload(Request $request)
    {
        DB::beginTransaction();
        try {
            
            if ($request->has('file')) {
                // return $request->all();

                Excel::import(new StudentImport, $request->file('file'));

                DB::commit();
                return back()->withSuccess('Success import students');
            }

            DB::rollback();
            return back()->withWarning('Uploaded file is required');
            
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::with('role', 'student', 'student.major')->find($id);
        $majors = Major::all();
        return view('students-management.edit', compact('majors', 'user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            DB::beginTransaction();
            $user = User::with('role')->find($id);
            $student = Student::where('users_id', $user->id);

            $userData = [
                'roles_id'  => 3,
                'fullname'  => $request->fullname,
                'email'     => $request->email,
                'updated_by'    => Auth::user()->id,
            ];

            if ($request->has('password')) {
                $userData['password'] = Hash::make($request->password);
            }

            $user->update($userData);

            $studentData = [
                'users_id'      => $user->id,
                'majors_id'     => $request->majors_id,
                'nis'           => $request->nis,
                'address'       => $request->address,
                'avg_scores'    => $request->avg_scores,
                'updated_by'    => Auth::user()->id,
            ];

            $student->update($studentData);

            DB::commit();
            return redirect()->route('students-management.edit', $id)->withSuccess("Success update student");
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            User::find($id)->delete();
            Student::where('users_id', $id)->first()->delete();
            return redirect()->route('students-management.index')->withSuccess("Success delete student");
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
