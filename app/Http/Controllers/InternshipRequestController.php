<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use App\Models\InternshipRequest;
use App\Models\InternshipSchedule;
use App\Models\User;
use App\Models\Company;
use App\Models\UserCompany;
use App\Models\Student;
use App\Models\CriteriaWeight;
use App\Models\WeighingResult;

use App\Imports\InternshipRequestImport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

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
                    ->join('students', 'students.users_id', '=', 'users.id')
                    ->join('companies', 'internship_requests.companies_id', '=', 'companies.id')
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
            $query = $query->where('students.users_id', Auth::user()->id);
        }

        $orderBy = "users.fullname";
        $orderByType = "asc";

        if ($request->has('order_by') && $request->has('order_by_type')) {

            if (!in_array($request->order_by_type, ['asc', 'desc'])) {
                abort(403);
            }

            $orderByType = $request->order_by_type;
            switch ($request->order_by) {
                case 'fullname':
                    $orderBy = "users.fullname";
                    break;
                // case 'avg_scores':
                //     $orderBy = "students.avg_scores";
                //     break;
                // case 'estimated_distance':
                //     $orderBy = "estimated_distance";
                //     break;
                case 'weighing_scores':
                    $orderBy = "weighing_scores";
                    break;
                case 'requested_company':
                    $orderBy = "companies.name";
                    break;
                case 'requested_date':
                    $orderBy = "created_at";
                    break;
                default:
                    $orderBy = "users.fullname";
                    break;
            }
        }

        $internship_requests = $query
        ->orderBy($orderBy, $orderByType)
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

    public function show($id)
    {
        $internship_request = InternshipRequest::with('user', 'company')->findOrFail($id);
        return view('internship-request.show', compact('internship_request'));
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

    public function form(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $internship_request = InternshipRequest::findOrFail($id);
            $company = Company::find($internship_request->companies_id);

            if ($request->status == 'approve') {
                $internship_request->update([
                    'status' => 'approved',
                    'notes'  => $request->notes,
                ]);

                InternshipSchedule::create([
                    'users_id'      => $internship_request->users_id,
                    'companies_id'  => $internship_request->companies_id,
                    'start_date'    => $company->start_date,
                    'end_date'      => $company->end_date,
                ]);

                DB::commit();
                return redirect()->route('internship-request.index')->withSuccess('Success approved internship request');
            } else if ($request->status == 'reject') {
                $internship_request->update([
                    'status' => 'rejected',
                    'notes'  => $request->notes,
                ]);

                $user_company = UserCompany::where('users_id', $internship_request->users_id)->where('companies_id', $internship_request->companies_id)->first();
                if ($user_company) {
                    $user_company->delete();
                }

                DB::commit();
                return redirect()->route('internship-request.index')->withSuccess('Success rejected internship request');
            } else {
                DB::rollback();
                return back()->withError("status is not valid");
            }

        } catch (\Throwable $th) {
            DB::rollback();
            return back()->withError($th->getMessage());
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
            DB::beginTransaction();
            $internship_request = InternshipRequest::find($id);
            $user_company = UserCompany::where('users_id', $internship_request->users_id)->where('companies_id', $internship_request->companies_id)->first();

            if ($user_company) {
                $user_company->delete();
            }

            $internship_request->delete();

            DB::commit();
            return redirect()->route('internship-request.index')->withSuccess("Success delete internship request");
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }

    public function download($id)
    {
        $internship_request = InternshipRequest::with('user', 'company')->findOrFail($id);

        if (Auth::user()->roles_id == 3) {
            if ($internship_request->user->id != Auth::user()->id) {
                return back()->withWarning('Download document another user is forbidden!');
            }
        }

        $pdf = Pdf::loadView('export.internship-report-pdf', compact('internship_request'));
        return $pdf->download('SURAT KETERANGAN HASIL PENGAJUAN PKL - '. $internship_request->user->fullname .'.pdf');
    }
}
