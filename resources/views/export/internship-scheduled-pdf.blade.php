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
                <td>Perusahaan Tujuan</td>
                <td>:</td>
                <td>{{$internship_schedule->company->name}}</td>
            </tr>
            <tr>
                <td>Alamat Perusahaan</td>
                <td>:</td>
                <td>{{$internship_schedule->company->address}}</td>
            </tr>
            <tr>
                <td>Waktu PKL</td>
                <td>:</td>
                <td>{{ date('d M Y', strtotime($internship_schedule->start_date)) }} - {{ date('d M Y', strtotime($internship_schedule->end_date)) }}</td>
            </tr>
        </table>

        <table border="1">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama Siswa</th>
                    <th>Email</th>
                    <th>Nilai Rata-Rata</th>
                    <th>Weighing Scores</th>
                </tr>
            </thead>
            <tbody style="text-align: center;">
                @foreach ($users as $user)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$user['fullname']}}</td>
                        <td>{{$user['email']}}</td>
                        <td>{{round($user['student']['avg_scores'], 3)}}</td>
                        <td>{{$user['weighing_scores']}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <p>Demikian surat keterangan ini dibuat untuk digunakan sebagai bukti bahwa yang bersangkutan telah melaksanakan proses pemilihan tempat PKL.</p>

        <div class="signature">
            <p>{{ date('d M Y') }}</p>
            <p>Mengetahui,</p>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <p>___________________</p>
        </div>
    </div>

</body>
</html>
