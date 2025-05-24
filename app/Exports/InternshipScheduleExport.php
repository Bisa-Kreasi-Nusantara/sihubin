<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

use App\Models\InternshipSchedule;

class InternshipScheduleExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return InternshipSchedule::with('user', 'company', 'acceptedWeighingResult')
                ->get()
                ->map(function ($row) {
                    return [
                        $row->user->fullname,
                        $row->company->name,
                        round($row->user->student->avg_scores, 2),
                        $row->acceptedWeighingResult->scores,
                        date('d M Y', strtotime($row->start_date)) .'-' .date('d M Y', strtotime($row->end_date)),
                        $row->is_finished == true ? 'Finished' : 'Not Finish',
                    ];
                });
    }

    public function headings(): array
    {
        return ["Fullname", "Company", "Avg Scores", "Weighing Scores", "Internship Date", "Status"];
    }
}
