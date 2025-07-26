<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>SURAT KETERANGAN HASIL PENGAJUAN PKL</title>
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
            margin-top: 20px;
            font-size: 12pt;
        }
        .content table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }
        .content td {
            padding: 8px 0;
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
        <div class="title">SURAT KETERANGAN HASIL PENGAJUAN PKL</div>
        {{-- <div>Nomor: {{$weighing_result->code}}</div> --}}
    </div>

    <div class="content">
        <p>Yang bertanda tangan di bawah ini menerangkan bahwa:</p>

        <table>
            <tr>
                <td style="width: 30%;">Nama Lengkap</td>
                <td style="width: 5%;">:</td>
                <td>{{$internship_request->user->fullname}}</td>
            </tr>
            <tr>
                <td style="width: 30%;">Nilai Rata-Rata</td>
                <td style="width: 5%;">:</td>
                <td>{{round($internship_request->user->student->avg_scores, 3)}}</td>
            </tr>
            <tr>
                <td>Tanggal Pengajuan</td>
                <td>:</td>
                <td>{{ date('d M Y', strtotime($internship_request->created_at)) }}</td>
            </tr>
            <tr>
                <td>Perusahaan yang Diminta</td>
                <td>:</td>
                <td>{{$internship_request->company->name}}</td>
            </tr>
            <tr>
                <td>Hasil Skor Penimbangan</td>
                <td>:</td>
                <td>{{$internship_request->weighing_scores}}</td>
            </tr>
            <tr>
                <td>Status</td>
                <td>:</td>
                <td><strong>{{strtoupper($internship_request->status)}}</strong></td>
            </tr>
            <tr>
                <td>Catatan</td>
                <td>:</td>
                <td>{{$internship_request->notes ?? '-'}}</td>
            </tr>
        </table>

        <p>Demikian surat keterangan ini dibuat untuk dipergunakan sebagaimana mestinya.</p>

        <div class="signature">
            <p>Diterbitkan pada: {{ date('d M Y') }}</p>
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
