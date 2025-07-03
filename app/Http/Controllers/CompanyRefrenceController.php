<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use App\Models\WeighingResult;
use App\Models\InternshipRequest;
use App\Models\CriteriaWeight;
use App\Models\User;
use App\Models\Company;
use App\Models\UserCompany;
use App\Models\InternshipSchedule;

use Auth;
use DB;

class CompanyRefrenceController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:company_refrences.view');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $refrences = [];
        return view('company-refrences.index', compact('refrences'));
    }

    public function show_refrences(Request $request)
    {
        try {
            $user = User::with('student')->where('fullname', $request->student_name)->first();
            if (!$user) {
                return back()->withError("Student not found, please check again.");
            }

            $companies = Company::where('majors_id', $user->student->majors_id)->where('is_active', true)->get();
            $criteria = CriteriaWeight::all();

            $selected_companies = [];

            // check apakah user sudah terdaftar pada perusahaan
            $checkUser = UserCompany::where('users_id', $user->id)->whereIn('companies_id', $companies->pluck('id'))->first();
            if ($checkUser) {
                return back()->withError("Student already apply intership request or already have internship schedule.");
            }

            // filter pertama: berdasarkan nilai rata-rata siswa
            foreach ($companies as $company) {

                // get data company capacity
                $company_capacity = DB::table('companies as c')
                                    ->leftJoin('user_companies as uc', 'uc.companies_id', '=', 'c.id')
                                    ->leftJoin('internship_schedules as isch', function ($join) {
                                        $join->on('isch.users_id', '=', 'uc.users_id')
                                            ->on('isch.companies_id', '=', 'c.id')
                                            ->where('isch.is_finished', 0);
                                    })
                                    ->where('c.id', $company->id)
                                    ->select(
                                        DB::raw('COUNT(DISTINCT uc.users_id) as current_students')
                                    )
                                    ->groupBy('c.id', 'c.name', 'c.max_capacity')
                                    ->first();

                if ($company_capacity->current_students >= $company->max_capacity) {
                    continue;
                }

                // pengecekan skor minimum berdasarkan reputasi
                $minScore = match (true) {
                    $company->reputations >= 5 => 90,
                    $company->reputations >= 4 => 85,
                    $company->reputations >= 3 => 80,
                    $company->reputations >= 2 => 75,
                    default => 70,
                };

                // jika student avg score lebih / sama dengan minimal score maka tambahkan ke selected_companies
                if ($user->student->avg_scores >= $minScore) {
                    array_push($selected_companies, $company);
                }
            }


            $refrences = [];

            foreach ($selected_companies as $company) {
                $values = [];

                foreach ($criteria as $item) {
                    switch ($item->name) {
                        case 'Kesesuaian Jurusan':
                            $value = $user->student->majors_id == $company->majors_id ? 1 : 0.0001;
                            break;

                        case 'Reputasi Industri':
                            $value = $company->reputations ?: 0.0001;
                            break;

                        case 'Kapasitas Industri':
                            $value = $company->max_capacity ?: 0.0001;
                            break;

                        case 'Nilai Akademik Siswa':
                            $value = $user->student->avg_scores ?: 0.0001;
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

                // get data company capacity
                $company_capacity = DB::table('companies as c')
                                    ->leftJoin('user_companies as uc', 'uc.companies_id', '=', 'c.id')
                                    ->leftJoin('internship_schedules as isch', function ($join) {
                                        $join->on('isch.users_id', '=', 'uc.users_id')
                                            ->on('isch.companies_id', '=', 'c.id')
                                            ->where('isch.is_finished', 0);
                                    })
                                    ->where('c.id', $company->id)
                                    ->select(
                                        DB::raw('COUNT(DISTINCT uc.users_id) as current_students')
                                    )
                                    ->groupBy('c.id', 'c.name', 'c.max_capacity')
                                    ->first();

                array_push($refrences, [
                    'company_id'            => $company->id,
                    'user_id'               => $user->id,
                    'company_name'          => $company->name,
                    'company_reputations'   => $company->reputations,
                    'company_address'       => $company->address,
                    'current_students'      => $company_capacity->current_students,
                    'company_capacity'      => $company->max_capacity,
                    'weighing_scores'       => round($score, 3)
                ]);
            }

            // Urutkan secara descending berdasarkan weighing_scores
            usort($refrences, function ($a, $b) {
                return $b['weighing_scores'] <=> $a['weighing_scores'];
            });

            // Ambil 5 teratas
            $refrences = array_slice($refrences, 0, 5);
            return view('company-refrences.index', compact('refrences'));
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function request_internship(Request $request)
    {
        $decode = base64_decode($request->data);
        $data = unserialize($decode);

        try {
            DB::beginTransaction();

            InternshipRequest::create([
                'users_id' => $data['user_id'],
                'companies_id' => $data['company_id'],
                'status'    => 'pending',
                'created_by' => Auth::user()->id,
                'updated_by' => Auth::user()->id,
                'weighing_scores' => $data['weighing_scores']
            ]);

            UserCompany::create([
                'users_id' => $data['user_id'],
                'companies_id' => $data['company_id'],
            ]);

            DB::commit();
            return redirect()->route('internship-request.index')->withSuccess('Success requested intership to selected company.');
        } catch (\Throwable $th) {
            // throw $th;
            return redirect()->route('company-refrences.index')->withError($th->getMessage());
        }
    }
}
