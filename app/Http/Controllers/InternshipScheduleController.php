<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use App\Models\InternshipSchedule;


use App\Exports\InternshipScheduleExport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Auth;

class InternshipScheduleController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:internship_schedules.view');
    }

    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {
    //     $query = InternshipSchedule::query()->with('user', 'company', 'acceptedWeighingResult');

    //     if (Auth::user()->roles_id == 3) {
    //         $query = $query->where('users_id', Auth::user()->id);
    //     }

    //     $internship_schedules = $query->get();


    //     return view('internship-schedule.index', compact('internship_schedules'));
    // }

    public function index(Request $request)
    {
        $query = InternshipSchedule::query()
            ->with(['user', 'company', 'acceptedWeighingResult'])
            ->join('users', 'internship_schedules.users_id', '=', 'users.id')
            ->join('students', 'students.users_id', '=', 'users.id')
            ->join('companies', 'internship_schedules.companies_id', '=', 'companies.id')
            ->leftJoin('weighing_results', function ($join) {
                $join->on('weighing_results.users_id', '=', 'internship_schedules.users_id')
                    ->on('weighing_results.companies_id', '=', 'internship_schedules.companies_id')
                    ->where('weighing_results.status', 'accepted');
            });

        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('users.fullname', 'like', '%' . $search . '%')
                ->orWhere('companies.name', 'like', '%' . $search . '%');
            });
        }

        // Role check
        if (Auth::user()->roles_id == 3) {
            $query->where('internship_schedules.users_id', Auth::user()->id);
        }

        // Default order
        $orderBy = 'users.fullname';
        $orderByType = 'asc';

        if ($request->has('order_by') && $request->has('order_by_type')) {
            if (!in_array($request->order_by_type, ['asc', 'desc'])) {
                abort(403);
            }

            $orderByType = $request->order_by_type;

            switch ($request->order_by) {
                case 'fullname':
                    $orderBy = 'users.fullname';
                    break;
                case 'company':
                    $orderBy = 'companies.name';
                    break;
                case 'avg_scores':
                    $orderBy = 'students.avg_scores';
                    break;
                case 'weighing_scores':
                    $orderBy = 'weighing_results.scores'; // Sesuaikan jika field berbeda
                    break;
                case 'is_finished':
                    $orderBy = 'internship_schedules.is_finished';
                    break;
                default:
                    $orderBy = 'users.fullname';
            }
        }

        $internship_schedules = $query
            ->orderBy($orderBy, $orderByType)
            ->select('internship_schedules.*') // penting untuk select primary table
            ->get();

        return view('internship-schedule.index', compact('internship_schedules'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $internship_schedule = InternshipSchedule::with('user', 'company')->findOrFail($id);
        return view('internship-schedule.edit', compact('internship_schedule'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {

            $request->merge([
                'start_date'    => date('Y-m-d', strtotime($request->start_date)),
                'end_date'      => date('Y-m-d', strtotime($request->end_date))
            ]);

            $internship_schedule = InternshipSchedule::findOrFail($id);
            $internship_schedule->update($request->all());

            return redirect()->route('internship-schedule.edit', $id)->withSuccess('Success update internship schedule');
        } catch (\Throwable $th) {
            throw $th;
        }


        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function export()
    {
        return Excel::download(new InternshipScheduleExport, 'internship-schedule_'.time().'.xlsx');
    }

    public function download($id)
    {
        $internship_schedule = InternshipSchedule::with('user', 'company', 'acceptedWeighingResult')->findOrFail($id);

        if (Auth::user()->roles_id == 3) {
            if ($internship_schedule->user->id != Auth::user()->id) {
                return redirect()->route('internship-schedule.index')->withWarning('Download document another user is forbidden!');
            }
        }
        
        $pdf = Pdf::loadView('export.internship-scheduled-pdf', compact('internship_schedule'));
        return $pdf->download('Surat Keterangan PKL.pdf');
    }
}
