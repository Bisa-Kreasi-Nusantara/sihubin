<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Keterangan PKL</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
        }
        .header {
            text-align: center;
            margin-bottom: 40px;
        }
        .title {
            font-size: 18pt;
            font-weight: bold;
            text-decoration: underline;
        }
        .content {
            font-size: 12pt;
        }
        .content table {
            width: 100%;
            margin-top: 20px;
        }
        .content td {
            padding: 6px 0;
        }
        .signature {
            margin-top: 50px;
            text-align: right;
            font-size: 12pt;
        }
    </style>
</head>
<body>

    <div class="header">
        <div class="title">SURAT KETERANGAN PRAKTIK KERJA LAPANGAN (PKL)</div>
        {{-- <div>Nomor: -</div> --}}
    </div>

    <div class="content">
        <p>Yang bertanda tangan di bawah ini menerangkan bahwa:</p>

        <table>
            <tr>
                <td style="width: 30%;">Nama Lengkap</td>
                <td style="width: 5%;">:</td>
                <td>{{$internship_schedule->user->fullname}}</td>
            </tr>
            <tr>
                <td>Perusahaan Tujuan</td>
                <td>:</td>
                <td>{{$internship_schedule->company->name}}</td>
            </tr>
            <tr>
                <td>Nilai Rata-Rata</td>
                <td>:</td>
                <td>{{ round($internship_schedule->user->student->avg_scores, 2) }}</td>
            </tr>
            <tr>
                <td>Skor Penimbangan</td>
                <td>:</td>
                <td>{{ $internship_schedule->acceptedWeighingResult->scores }}</td>
            </tr>
            <tr>
                <td>Waktu PKL</td>
                <td>:</td>
                <td>{{ date('d M Y', strtotime($internship_schedule->start_date)) }} - {{ date('d M Y', strtotime($internship_schedule->end_date)) }}</td>
            </tr>
        </table>

        <p>Demikian surat keterangan ini dibuat untuk digunakan sebagai bukti bahwa yang bersangkutan telah melaksanakan proses pemilihan tempat PKL.</p>

        <div class="signature">
            <p>Mengetahui,</p>
            {{-- <p>Administrator</p> --}}
        </div>
    </div>

</body>
</html>
