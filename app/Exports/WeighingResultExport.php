<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

use App\Models\WeighingResult;

use DB;

class WeighingResultExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return WeighingResult::with(['user', 'company'])->orderBy(
                DB::raw('(SELECT fullname FROM users WHERE users.id = weighing_results.users_id)')
            )
            ->get()
            ->map(function ($row) {
                return [
                    $row->code,
                    $row->user->fullname,
                    $row->company->name,
                    $row->scores,
                    $row->status,
                    $row->notes ?? '-',
                    $row->proceedBy == null ? '-' : $row->proceedBy->fullname,
                    date('d M Y', strtotime($row->created_at)),
                ];
            });
    }

    public function headings(): array
    {
        return ["Code", "Fullname", "Requested Company", "Weighing Scores Result", "Status", "Notes", "Proceed By", "Proceed Date"];
    }
}
