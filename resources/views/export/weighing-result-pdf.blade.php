<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Keterangan Hasil Penimbangan</title>
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
        <div class="title">SURAT KETERANGAN HASIL PENIMBANGAN</div>
        <div>Nomor: {{$weighing_result->code}}</div>
    </div>

    <div class="content">
        <p>Yang bertanda tangan di bawah ini menerangkan bahwa:</p>

        <table>
            <tr>
                <td style="width: 30%;">Nama Lengkap</td>
                <td style="width: 5%;">:</td>
                <td>{{$weighing_result->user->fullname}}</td>
            </tr>
            <tr>
                <td>Perusahaan yang Diminta</td>
                <td>:</td>
                <td>{{$weighing_result->company->name}}</td>
            </tr>
            <tr>
                <td>Hasil Skor Penimbangan</td>
                <td>:</td>
                <td>{{$weighing_result->scores}}</td>
            </tr>
            <tr>
                <td>Status</td>
                <td>:</td>
                <td><strong>{{$weighing_result->status}}</strong></td>
            </tr>
            <tr>
                <td>Catatan</td>
                <td>:</td>
                <td>{{$weighing_result->notes ?? '-'}}</td>
            </tr>
        </table>

        <p>Demikian surat keterangan ini dibuat untuk dipergunakan sebagaimana mestinya.</p>

        <div class="signature">
            <p>Diterbitkan pada: {{ date('d M Y', strtotime($weighing_result->created_at)) }}</p>
            <p>{{$weighing_result->proceedBy->fullname}}</p>
        </div>
    </div>

</body>
</html>
