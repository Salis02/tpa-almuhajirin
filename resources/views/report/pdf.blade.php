<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Raport Santri</title>
    <style>
        * {
            box-sizing: border-box;
        }
        
        body {
            font-family: "DejaVu Sans", Arial, sans-serif;
            margin: 0;
            padding: 20px;
            font-size: 12px;
            color: #2c3e50;
            line-height: 1.4;
            background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
        }
        
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            border-radius: 8px;
            overflow: hidden;
        }
        
        .header {
            background: linear-gradient(135deg, #34495e 0%, #2c3e50 100%);
            color: white;
            padding: 25px 20px;
            text-align: center;
            position: relative;
        }
        
        .header::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #3498db, #2ecc71, #f39c12, #e74c3c);
        }
        
        .header h2 {
            margin: 0 0 8px 0;
            font-size: 24px;
            font-weight: 700;
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
        }
        
        .header h3 {
            margin: 0 0 12px 0;
            font-size: 16px;
            font-weight: 400;
            opacity: 0.9;
        }
        
        .header p {
            margin: 4px 0;
            font-size: 13px;
            opacity: 0.8;
        }
        
        .content {
            padding: 25px;
        }
        
        .info-section {
            background: #f8f9fa;
            border-left: 4px solid #3498db;
            padding: 15px 20px;
            margin: 20px 0;
            border-radius: 0 6px 6px 0;
        }
        
        .info-section strong {
            color: #2c3e50;
            font-weight: 600;
        }
        
        .info-row {
            display: flex;
            margin-bottom: 8px;
        }
        
        .info-row:last-child {
            margin-bottom: 0;
        }
        
        .info-label {
            min-width: 120px;
            font-weight: 600;
            color: #34495e;
        }
        
        .info-value {
            flex: 1;
            color: #2c3e50;
        }
        
        .table-wrapper {
            margin: 25px 0;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }
        
        th {
            background: linear-gradient(135deg, #34495e 0%, #2c3e50 100%);
            color: white;
            padding: 12px 8px;
            text-align: center;
            font-weight: 600;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        td {
            padding: 10px 8px;
            text-align: center;
            border-bottom: 1px solid #e9ecef;
            font-size: 11px;
        }
        
        tbody tr:nth-child(even) {
            background: #f8f9fa;
        }
        
        tbody tr:hover {
            background: #e3f2fd;
            transition: background-color 0.2s ease;
        }
        
        .score-excellent { color: #27ae60; font-weight: 600; }
        .score-good { color: #3498db; font-weight: 600; }
        .score-fair { color: #f39c12; font-weight: 600; }
        .score-poor { color: #e74c3c; font-weight: 600; }
        
        .summary-section {
            background: linear-gradient(135deg, #ecf0f1 0%, #f8f9fa 100%);
            border-radius: 8px;
            padding: 20px;
            margin: 25px 0;
            border-top: 3px solid #3498db;
        }
        
        .summary-item {
            margin-bottom: 12px;
            padding: 8px 0;
            border-bottom: 1px solid #dee2e6;
        }
        
        .summary-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
        }
        
        .summary-label {
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 4px;
        }
        
        .summary-value {
            color: #34495e;
            font-size: 13px;
        }
        
        .overall-score {
            text-align: center;
            background: #3498db;
            color: white;
            padding: 15px;
            border-radius: 6px;
            margin-top: 15px;
        }
        
        .overall-score .score {
            font-size: 24px;
            font-weight: 700;
            margin-top: 5px;
        }
        
        .footer {
            margin-top: 40px;
            padding-top: 25px;
            border-top: 2px solid #e9ecef;
        }
        
        .signature {
            text-align: center;
            flex: 1;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 6px;
        }
        .signature-wrapper {
            display: grid;
            grid-template-columns: 1fr 1fr; /* dua kolom */
            gap: 40px;
            margin-top: 10px; /* jarak antara tanggal dan tanda tangan */
        }
        
        .signature-title {
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 50px;
        }
        
        .signature-line {
            border-top: 2px solid #34495e;
            margin-top: 10px;
            padding-top: 5px;
            font-size: 11px;
            color: #7f8c8d;
        }
        
        .date {
            font-weight: 600;
        }
        
        @media print {
            body { background: white; }
            .container { box-shadow: none; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>RAPORT SANTRI</h2>
            <h3>TPA {{ $report->santri->tpaClass->display_name ?? '-' }}</h3>
            <p><strong>Periode:</strong> {{ $report->period_start }} - {{ $report->period_end }}</p>
            <p><strong>Tahun Ajaran:</strong> {{ $report->academic_year }}</p>
        </div>
        
        <div class="content">
            <div class="info-section">
                <div class="info-row">
                    <div class="info-label">Nama Santri:</div>
                    <div class="info-value">{{ $report->santri->full_name }}</div>
                    {{-- @dd($report) --}}
                </div>
                <div class="info-row">
                    <div class="info-label">Kelas:</div>
                    <div class="info-value">{{ $report->santri->tpaClass->name ?? '-' }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Status:</div>
                    <div class="info-value">{{ ucfirst($report->status) }}</div>
                </div>
            </div>

            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th style="width: 5%">No</th>
                            <th style="width: 20%">Kategori</th>
                            <th style="width: 25%">Aspek</th>
                            <th style="width: 10%">Nilai</th>
                            <th style="width: 10%">Skor</th>
                            <th style="width: 30%">Catatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($report->reportDetails as $i => $detail)
                            <tr>
                                <td>{{ $i+1 }}</td>
                                <td>{{ $detail->assessment->assessmentCategory->display_name }}</td>
                                <td style="text-align: left; padding-left: 12px;">{{ $detail->assessment->name }}</td>
                                <td class="score-{{ strtolower($detail->score_value) }}">{{ $detail->score_value }}</td>
                                <td><strong>{{ $detail->numeric_score }}</strong></td>
                                <td style="text-align: left; padding-left: 12px;">{{ $detail->notes ?: '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="summary-section">
                <div class="summary-item">
                    <div class="summary-label">Catatan Guru:</div>
                    <div class="summary-value">{{ $report->teacher_notes ?: 'Tidak ada catatan khusus.' }}</div>
                </div>
                <div class="summary-item">
                    <div class="summary-label">Rekomendasi:</div>
                    <div class="summary-value">{{ $report->recommendations ?: 'Terus pertahankan dan tingkatkan prestasi.' }}</div>
                </div>
                
                <div class="overall-score">
                    <div>SKOR KESELURUHAN</div>
                    <div class="score">{{ $report->overall_score }}</div>
                </div>
            </div>

            <div class="footer">
    <!-- Baris tanggal -->
    <div class="date" style="text-align: right; width: 100%;">
        Bantul, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
    </div>

    <!-- Baris tanda tangan -->
    <div class="signature-wrapper">
        <div class="signature">
            <div class="signature-title">Orang Tua/Wali</div>
            <div class="signature-line">Tanda Tangan & Nama</div>
        </div>
        <div class="signature">
            <div class="signature-title">Guru/Ustadz</div>
            <div class="signature-line">Tanda Tangan & Nama</div>
        </div>
    </div>
</div>

        </div>
    </div>
</body>
</html>