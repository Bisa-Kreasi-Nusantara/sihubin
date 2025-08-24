<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Events\AfterSheet;

use App\Models\InternshipSchedule;

class InternshipScheduleExport implements FromCollection, WithHeadings, WithEvents, WithCustomStartCell
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
                        date('d M Y', strtotime($row->start_date)) .'-' .date('d M Y', strtotime($row->end_date)),
                        $row->is_finished == true ? 'Finished' : 'Not Finish',
                    ];
                });
    }

    public function headings(): array
    {
        return ["Fullname", "Company", "Avg Scores", "Internship Date", "Status"];
    }

    // Mulai heading di row ke-4
    public function startCell(): string
    {
        return 'A4';
    }

    // Tambah judul & tanggal di atas tabel
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Judul Laporan
                $sheet->setCellValue('A1', 'Judul Laporan: Laporan Siswa Yang Melakukan PKL');
                $sheet->mergeCells('A1:G1'); // merge biar rapi

                // Tanggal Laporan
                $sheet->setCellValue('A2', 'Tanggal Laporan: ' . now()->translatedFormat('d F Y'));
                $sheet->mergeCells('A2:G2');

                // Bold biar lebih jelas
                $sheet->getStyle('A1:A2')->getFont()->setBold(true);
            },
        ];
    }
}
