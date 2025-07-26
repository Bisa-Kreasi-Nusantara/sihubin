<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Keterangan PKL</title>
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
        <div class="document-title">SURAT KETERANGAN PRAKTIK KERJA LAPANGAN (PKL)</div>
        {{-- <div class="document-number">Nomor : {{kode_jurusan}}/PK.03.04.06/SMKN 4 Bekasi</div> --}}

        <!-- Content -->
        <div class="content">
            <p>Yang bertanda tangan di bawah ini menerangkan bahwa:</p>

            <table class="student-info">
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


            <table class="grades-table">
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
