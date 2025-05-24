<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use App\Models\InternshipSchedule;


use App\Exports\InternshipScheduleExport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class InternshipScheduleController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:internship_schedules.view');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $internship_schedules = InternshipSchedule::with('user', 'company', 'acceptedWeighingResult')->get();
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
}
