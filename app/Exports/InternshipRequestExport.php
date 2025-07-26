<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

use App\Models\InternshipRequest;


class InternshipRequestExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $orderBy = "users.fullname";
        $orderByType = "asc";

        return InternshipRequest::query()
                    ->join('users', 'internship_requests.users_id', '=', 'users.id')
                    ->join('students', 'students.users_id', '=', 'users.id')
                    ->join('companies', 'internship_requests.companies_id', '=', 'companies.id')
                    ->with('user', 'company')
                    ->orderBy($orderBy, $orderByType)
                    ->select('internship_requests.*')
                    ->get()
                    ->map(function ($row) {
                        return [
                            $row->user->fullname,
                            $row->company->name,
                            round($row->user->student->avg_scores, 2),
                            round($row->weighing_scores, 3),
                            $row->status,
                            date('d M Y', strtotime($row->created_at)),
                            $row->notes ?? '-',
                        ];
                    });
    }

    public function headings(): array
    {
        return ["Fullname", "Company", "Avg Scores", "Weighing Scores", "Status", "Request Date", "Notes"];
    }
}
