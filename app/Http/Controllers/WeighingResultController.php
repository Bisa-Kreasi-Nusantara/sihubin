<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use App\Models\WeighingResult;
use App\Models\InternshipRequest;
use App\Models\CriteriaWeight;
use App\Models\Company;
use App\Models\UserCompany;
use App\Models\InternshipSchedule;

use App\Exports\WeighingResultExport;
use Maatwebsite\Excel\Facades\Excel;

use DB;
use Auth;

class WeighingResultController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:weighing_result.view');
    }


    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = WeighingResult::with(['user', 'company']);

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

        $weighing_results = $query
            ->orderBy(
                DB::raw('(SELECT fullname FROM users WHERE users.id = weighing_results.users_id)')
            )
            ->get();

        return view('weighing-result.index', compact('weighing_results'));
    }

    public function process()
    {
        DB::beginTransaction();
        try {
            // $requests = InternshipRequest::with(['company', 'user.student'])
            //     ->whereStatus('pending')
            //     ->get();

            $requests = InternshipRequest::with(['company', 'user.student'])
                        ->whereStatus('pending')
                        ->join('companies', 'internship_requests.companies_id', '=', 'companies.id')
                        ->orderByDesc('companies.reputations')
                        ->select('internship_requests.*') // penting agar hanya mengambil kolom internship_requests saja
                        ->get();

            if ($requests->count() < 1) {
                DB::rollback();
                return redirect()->route('weighing-result.index')->withError("No internship request available to calculate");
            }

            $criteria = CriteriaWeight::all();

            foreach ($requests as $request) {
                $student = $request->user->student;
                $company = $request->company;

                // pengecekan skor minimum berdasarkan reputasi
                $minScore = match (true) {
                    $company->reputations >= 5 => 90,
                    $company->reputations >= 4 => 85,
                    $company->reputations >= 3 => 80,
                    $company->reputations >= 2 => 75,
                    default => 70,
                };


                if ($student->avg_scores < $minScore) {
                    WeighingResult::updateOrCreate([
                        'users_id' => $request->users_id,
                        'companies_id' => $request->companies_id,
                    ], [
                        'code' => 'SPK'.rand(1111, 9999),
                        'scores' => 0,
                        'status' => 'rejected',
                        'notes' => 'Nilai siswa tidak memenuhi standar reputasi perusahaan',
                        'proceed_by' => Auth::user()->id,
                    ]);

                    InternshipRequest::where('users_id', $request->users_id)
                        ->where('companies_id', $request->companies_id)
                        ->update(['status' => 'weighed']);

                    DB::commit();
                    
                    continue;
                }

                $values = [];

                foreach ($criteria as $item) {
                    switch ($item->name) {
                        case 'Kesesuaian Jurusan':
                            $value = $student->majors_id == $company->majors_id ? 1 : 0.0001;
                            break;

                        case 'Jarak':
                            $value = $request->estimated_distance ?: 0.0001;
                            break;

                        case 'Reputasi Industri':
                            $value = $company->reputations ?: 0.0001;
                            break;

                        case 'Kapasitas Industri':
                            $value = $company->max_capacity ?: 0.0001;
                            break;

                        case 'Nilai Akademik Siswa':
                            $value = $student->avg_scores ?: 0.0001;
                            break;

                        default:
                            $value = 0.0001;
                    }

                    $values[] = [
                        'value' => $value,
                        'weight' => $item->weight_value,
                        'type' => $item->type,
                    ];
                }

                // Hitung skor WP
                $score = 1;
                foreach ($values as $v) {
                    $weight = $v['type'] === 'cost' ? -$v['weight'] : $v['weight'];
                    $score *= pow($v['value'], $weight);
                }

                // Simpan ke hasil WP
                WeighingResult::updateOrCreate([
                    'users_id' => $request->users_id,
                    'companies_id' => $request->companies_id,
                ], [
                    'code' => 'SPK'.rand(1111, 9999),
                    'scores' => round($score, 3),
                    'proceed_by' => Auth::user()->id,
                ]);

                InternshipRequest::where('users_id', $request->users_id)
                    ->where('companies_id', $request->companies_id)
                    ->update(['status' => 'weighed']);
            }

            $results = WeighingResult::with('company')
                ->whereStatus('pending')
                ->orderByDesc('scores')
                ->get();

            $acceptedUsers = [];

            foreach ($results as $result) {
                $userId = $result->users_id;
                $companyId = $result->companies_id;
                $company = $result->company;

                InternshipRequest::where('users_id', $userId)
                    ->where('companies_id', $companyId)
                    ->update(['status' => 'weighed']);

                // check user
                $check_user = InternshipSchedule::where('users_id', $userId)
                                        ->where('is_finished', false)
                                        ->first();
                if ($check_user) {
                    $result->update([
                        'status' => 'rejected',
                        'notes' => 'Siswa telah diterima di perusahaan lain',
                    ]);
                    continue;
                }
                

                if (in_array($userId, $acceptedUsers)) {
                    $result->update([
                        'status' => 'rejected',
                        'notes' => 'Siswa telah diterima di perusahaan lain',
                    ]);
                    continue;
                }

                // check company capacity
                $company_capacity = DB::table('companies as c')
                                ->leftJoin('user_companies as uc', 'uc.companies_id', '=', 'c.id')
                                ->leftJoin('internship_schedules as isch', function ($join) {
                                    $join->on('isch.users_id', '=', 'uc.users_id')
                                        ->on('isch.companies_id', '=', 'c.id')
                                        ->where('isch.is_finished', 0);
                                })
                                ->where('c.id', $companyId)
                                ->select(
                                    'c.id',
                                    'c.name',
                                    'c.max_capacity',
                                    DB::raw('COUNT(DISTINCT uc.users_id) as current_students'),
                                    DB::raw('(c.max_capacity - COUNT(DISTINCT uc.users_id)) as remaining_capacity')
                                )
                                ->groupBy('c.id', 'c.name', 'c.max_capacity')
                                ->first();

                if ($company_capacity->remaining_capacity > 0) {
                    $result->update([
                        'status' => 'accepted',
                        'notes' => null,
                    ]);

                    $acceptedUsers[] = $userId;

                    UserCompany::create([
                        'users_id'      => $userId,
                        'companies_id'  => $companyId
                    ]);

                    $company = Company::find($companyId);

                    InternshipSchedule::create([
                        'users_id'      => $userId,
                        'companies_id'  => $companyId,
                        'start_date'    => $company->start_date,
                        'end_date'      => $company->end_date,
                    ]);
                } else {
                    $result->update([
                        'status' => 'rejected',
                        'notes' => 'Kapasitas perusahaan telah terpenuhi',
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('weighing-result.index')->withSuccess("Success process calculation and placement based on criteria");
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }

    public function export()
    {
        return Excel::download(new WeighingResultExport, 'weighing_result_'.time().'.xlsx');
    }
}
