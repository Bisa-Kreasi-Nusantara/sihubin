<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use App\Models\InternshipRequest;
use App\Models\User;
use App\Models\Company;
use App\Models\Student;
use App\Models\CriteriaWeight;
use App\Models\WeighingResult;

use App\Imports\InternshipRequestImport;
use Maatwebsite\Excel\Facades\Excel;

use Auth;
use DB;

class InternshipRequestController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:internship_request.view');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = InternshipRequest::query()
                    ->join('users', 'internship_requests.users_id', '=', 'users.id')
                    ->with('user', 'company');

        if ($request->has('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($subQ) use ($search) {
                    $subQ->where('fullname', 'like', '%' . $search . '%');
                })->orWhereHas('company', function ($subQ) use ($search) {
                    $subQ->where('name', 'like', '%' . $search . '%');
                });
            });
        }

        if (Auth::user()->roles_id == 3) {
            $query = $query->where('users_id', Auth::user()->id);
        }

        $internship_requests = $query
        ->orderBy('users.fullname', 'asc')
        ->select('internship_requests.*')
        ->get();

        return view('internship-request.index', compact('internship_requests'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::query()->with('student')->where('roles_id', 3);
        $companies = Company::query()
                            ->withCount('users');
                            

        if (Auth::user()->roles_id == 3) {
            $users = $users->where('id', Auth::user()->id);
            $companies = $companies->where('majors_id', Auth::user()->student->majors_id);
        }


        $users = $users->get();
        $companies = $companies->get()
                            ->filter(function ($company) {
                                return $company->users_count < $company->max_capacity;
                            });

        return view('internship-request.create', compact('users', 'companies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {

            // check internship request
            if (InternshipRequest::whereUsersId($request->users_id)->whereCompaniesId($request->companies_id)->first()) {
                return back()->withWarning("Warning: internship request is exists, please use another user or company");
            }

            $request->merge([
                'created_by'    => Auth::user()->id,
            ]);

            InternshipRequest::create($request->all());

            return redirect()->route('internship-request.index')->withSuccess("Success create internship request");
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function upload(Request $request)
    {
        DB::beginTransaction();
        try {
            
            if ($request->has('file')) {

                $import = new InternshipRequestImport;
                Excel::import($import, $request->file('file'));

                if (count($import->errors) > 0) {
                    DB::rollback();
                    return back()->with('import_errors', $import->errors);
                }

                DB::commit();
                return back()->withSuccess('Success import internship request');
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
        $users = User::where('roles_id', 3)->get();
        $companies = Company::all();

        $internship_request = InternshipRequest::find($id);
        return view('internship-request.edit', compact('internship_request', 'users', 'companies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $internship_request = InternshipRequest::find($id);

            $request->merge([
                'updated_by'    => Auth::user()->id,
            ]);

            $internship_request->update($request->all());

            return redirect()->route('internship-request.edit', $id)->withSuccess("Success update internship request");
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            InternshipRequest::find($id)->delete();
            return redirect()->route('internship-request.index')->withSuccess("Success delete internship request");
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
