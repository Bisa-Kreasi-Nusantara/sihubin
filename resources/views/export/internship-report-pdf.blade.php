<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SURAT KETERANGAN HASIL PENGAJUAN PKL</title>
    <style>
        @page {
            size: A4;
            margin: 0;
        }
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #000;
            width: 210mm;
            height: 297mm;
            background-color: white;
        }
        .container {
            width: 190mm;
            margin: 10mm auto;
            padding: 0;
            box-sizing: border-box;
        }
        .header {
            display: table;
            width: 100%;
            margin-bottom: 20px;
        }
        .header-row {
            display: table-row;
        }
        .logo-cell {
            display: table-cell;
            width: 120px;
            vertical-align: middle;
            text-align: center;
        }
        .title-cell {
            display: table-cell;
            vertical-align: middle;
            text-align: center;
            padding-left: 20px;
        }
        .logo {
            width: 100px;
        }
        .title {
            font-size: 16px;
            font-weight: bold;
            text-align: center;
            margin: 0;
        }
        .subtitle {
            font-size: 14px;
            text-align: center;
            margin: 5px 0;
        }
        .school-name {
            font-size: 18px;
            font-weight: bold;
            text-align: center;
            margin: 5px 0;
        }
        .address {
            font-size: 12px;
            text-align: center;
            margin: 5px 0;
        }
        .divider {
            border-top: 3px solid #000;
        }
        .document-title {
            font-size: 16px;
            font-weight: bold;
            text-align: center;
            margin: 20px 0 10px;
            text-decoration: underline;
        }
        .document-number {
            font-size: 14px;
            text-align: center;
            margin: -5px 0 20px;
        }
        .content {
            font-size: 12px;
            line-height: 1.5;
            text-align: justify;
        }
        .student-info {
            width: 100%;
            border-collapse: collapse;
        }
        .student-info td {
            padding: 5px;
            vertical-align: top;
        }
        .student-info td:first-child {
            width: 200px;
        }
        .grades-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        .grades-table th, .grades-table td {
            border: 1px solid #000;
            padding: 3px;
            text-align: center;
        }
        .grades-table th {
            background-color: #f2f2f2;
        }
        .footer {
            margin-top: 30px;
            text-align: right;
        }
        .signature {
            margin-top: 80px;
            text-align: center;
            width: 250px;
            float: right;
        }
        .signature-box {
            /* padding: 10px; */
            /* margin-top: px; */
            height: 100px;
        }
        .signature-name {
            margin-top: 10px;
            font-weight: bold;
        }
        .signature-title {
            margin-top: 5px;
            font-size: 12px;
        }
        .note {
            font-size: 12px;
            margin-top: 20px;
            font-style: italic;
        }
        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }
        @media print {
            body {
                width: 210mm;
                height: 297mm;
            }
            .container {
                width: 190mm;
                margin: 10mm;
                padding: 0;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header with logo and title -->
        <table class="header" width="100%">
            <tr>
                <td width="90" align="center" valign="middle">
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSer3E2_VMuzsukSWlV3ue5013RoNxWIoQO4A&s" alt="Logo Sekolah" width="100">
                </td>
                <td align="center" valign="middle">
                    <p class="title">PEMERINTAH DAERAH PROVINSI JAWA BARAT</p>
                    <p class="subtitle">DINAS PENDIDIKAN</p>
                    <p class="subtitle">CABANG DINAS PENDIDIKAN WILAYAH III</p>
                    <p class="school-name">SEKOLAH MENENGAH KEJURUAN NEGERI 4 BEKASI</p>
                    <p class="address">Jl. Gandaria Kranggan Wetan Kel. Jatiranga Kec. Jatisampurna Tlp.(021) - 29064472</p>
                    <p class="address">Website : smkn4kotabekasi.sch.id, e-mail : smkneger4bekasi@gmail.com</p>
                    <p class="address">Kota Bekasi 17434</p>
                </td>
            </tr>
        </table>

        <div class="divider"></div>

        <!-- Document title and number -->
        <div class="document-title">SURAT KETERANGAN HASIL PENGAJUAN PKL</div>
        {{-- <div class="document-number">Nomor : {{kode_jurusan}}/PK.03.04.06/SMKN 4 Bekasi</div> --}}

        <!-- Content -->
        <div class="content">
            <p>Yang bertanda tangan di bawah ini menerangkan bahwa:</p>

            <table class="student-info">
                <tr>
                    <td>Nama</td>
                    <td>:</td>
                    <td>{{$internship_request->user->fullname}}</td>
                </tr>
                <tr>
                    <td>Nilai Rata-Rata</td>
                    <td>:</td>
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
            <div class="clearfix">
                <div class="footer">
                    <p>Bekasi, {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('l, d F Y') }}</p>
                    <p>Mengetahui,</p>
                    <br>
                    <br>
                    <br>
                    <br>
                    <p>___________________</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
