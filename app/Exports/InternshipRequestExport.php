<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Events\AfterSheet;

use App\Models\InternshipRequest;


class InternshipRequestExport implements FromCollection, WithHeadings, WithEvents, WithCustomStartCell
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
                $sheet->setCellValue('A1', 'Judul Laporan: Laporan Pengajuan PKL');
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
