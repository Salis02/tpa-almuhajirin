<!DOCTYPE html>
<html>

<head>
    <title>Raport Santri - {{ $data['nama_santri'] }}</title>
    <style>
        body {
            font-family: 'Helvetica', sans-serif;
            font-size: 12px;
            color: #333;
            line-height: 1.5;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .header h2 {
            margin: 0;
            text-transform: uppercase;
        }

        .info-table {
            width: 100%;
            margin-bottom: 20px;
        }

        .info-table td {
            padding: 3px 0;
        }

        .main-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .main-table th,
        .main-table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        .main-table th {
            background-color: #f2f2f2;
            text-align: center;
        }

        .text-center {
            text-align: center;
        }

        .footer {
            margin-top: 30px;
            width: 100%;
        }

        .footer td {
            width: 50%;
            text-align: center;
        }

        .signature-space {
            height: 80px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h2>LAPORAN HASIL BELAJAR SANTRI (RAPORT)</h2>
        <p>TPA AL-MUHAJIRIN - TAHUN AJARAN {{ strtoupper($data['tahun_ajaran']) }}</p>
    </div>

    <table class="info-table">
        <tr>
            <td width="15%">Nama Santri</td>
            <td width="35%">: <strong>{{ $data['nama_santri'] }}</strong></td>
            <td width="15%">Semester</td>
            <td width="35%">: {{ $data['semester'] }}</td>
        </tr>
        <tr>
            <td>NIS</td>
            <td>: {{ $data['nis'] }}</td>
            <td>Kelas</td>
            <td>: {{ $data['kelas'] }}</td>
        </tr>
    </table>

    <table class="main-table">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="65%">Materi Pembelajaran</th>
                <th width="30%">Nilai (0-100)</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @foreach ($data['nilai'] as $materi => $skor)
                <tr>
                    <td class="text-center">{{ $no++ }}</td>
                    <td>{{ ucwords(str_replace('_', ' ', $materi)) }}</td>
                    <td class="text-center">{{ $skor }}</td>
                </tr>
            @endforeach
            <tr style="background-color: #f9f9f9; font-weight: bold;">
                <td colspan="2" class="text-center">RATA-RATA</td>
                <td class="text-center">{{ $data['rata_rata'] }}</td>
            </tr>
        </tbody>
    </table>

    <div style="margin-bottom: 10px;">
        <strong>Materi yang dipelajari:</strong><br>
        {{ $data['materi'] }}
    </div>

    <div style="margin-bottom: 20px; border: 1px solid #000; padding: 10px;">
        <strong>Catatan Ustadz/Ustadzah:</strong><br>
        <em>"{{ $data['catatan'] }}"</em>
    </div>

    <table class="footer">
        <tr>
            <td>
                Mengetahui,<br>Orang Tua/Wali Santri
                <div class="signature-space"></div>
                ( .................................... )
            </td>
            <td>
                Sidoarjo, {{ date('d F Y') }}<br>Ustadz/Ustadzah Kelas
                <div class="signature-space"></div>
                <strong>( {{ $data['ustadz'] }} )</strong>
            </td>
        </tr>
    </table>
</body>

</html>
