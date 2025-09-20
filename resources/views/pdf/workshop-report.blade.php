<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Workshop Report - {{ $workshop->title }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            margin: 0;
            padding: 20px;
        }

        .header {
            text-align: center;
            border-bottom: 3px solid #007bff;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .header h1 {
            color: #007bff;
            font-size: 24px;
            margin: 0;
            font-weight: bold;
        }

        .header .subtitle {
            color: #666;
            font-size: 14px;
            margin-top: 10px;
        }

        .section {
            margin-bottom: 30px;
            page-break-inside: avoid;
        }

        .section-title {
            background-color: #007bff;
            color: white;
            padding: 10px 15px;
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .info-grid {
            display: table;
            width: 100%;
            border-collapse: collapse;
        }

        .info-row {
            display: table-row;
        }

        .info-label {
            display: table-cell;
            font-weight: bold;
            padding: 8px 10px;
            background-color: #f8f9fa;
            border: 1px solid #ddd;
            width: 30%;
        }

        .info-value {
            display: table-cell;
            padding: 8px 10px;
            border: 1px solid #ddd;
        }

        .participants-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .participants-table th {
            background-color: #007bff;
            color: white;
            padding: 10px;
            text-align: left;
            font-weight: bold;
            border: 1px solid #0056b3;
        }

        .participants-table td {
            padding: 8px 10px;
            border: 1px solid #ddd;
            background-color: #f9f9f9;
        }

        .participants-table tr:nth-child(even) td {
            background-color: #ffffff;
        }

        /* Stats Cards */
        .stats-grid {
            display: flex;
            gap: 15px;
            margin: 15px 0;
            flex-wrap: wrap;
        }

        .stats-card {
            flex: 1;
            min-width: 120px;
            background: linear-gradient(135deg, #007bff, #0056b3);
            color: white;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .stats-number {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .stats-label {
            font-size: 10px;
            opacity: 0.9;
        }

        /* Progress Bar Style - Simplified for PDF */
        .progress-container {
            margin: 15px 0;
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            padding: 15px;
        }

        .progress-item {
            margin-bottom: 12px;
        }

        .progress-label {
            margin-bottom: 4px;
            font-weight: bold;
            font-size: 11px;
        }

        .progress-bar {
            width: 100%;
            height: 25px;
            background-color: #e9ecef;
            border: 1px solid #ccc;
            position: relative;
        }

        .progress-fill {
            height: 100%;
            position: relative;
        }

        /* Solid colors for PDF compatibility */
        .progress-fill.color-1 {
            background-color: #007bff;
        }

        .progress-fill.color-2 {
            background-color: #28a745;
        }

        .progress-fill.color-3 {
            background-color: #ffc107;
        }

        .progress-fill.color-4 {
            background-color: #dc3545;
        }

        .progress-fill.color-5 {
            background-color: #6c757d;
        }

        .progress-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 10px;
            font-weight: bold;
            color: white;
            text-align: center;
        }

        .progress-label-flex {
            display: table;
            width: 100%;
        }

        .progress-label-left {
            display: table-cell;
            text-align: left;
        }

        .progress-label-right {
            display: table-cell;
            text-align: right;
        }

        /* Table with Visual Bars for Rating */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
            background-color: white;
            border: 1px solid #dee2e6;
        }

        .data-table th {
            background-color: #007bff;
            color: white;
            padding: 12px 8px;
            text-align: left;
            font-weight: bold;
            border: 1px solid #0056b3;
            font-size: 11px;
        }

        .data-table td {
            padding: 10px 8px;
            border: 1px solid #dee2e6;
            font-size: 11px;
        }

        .data-table tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        /* Visual Bar for Rating - Simplified for PDF */
        .visual-bar {
            height: 20px;
            position: relative;
            border: 1px solid #ccc;
        }

        /* Solid colors for rating bars */
        .visual-bar.rating-5 {
            background-color: #28a745;
        }

        .visual-bar.rating-4 {
            background-color: #17a2b8;
        }

        .visual-bar.rating-3 {
            background-color: #ffc107;
        }

        .visual-bar.rating-2 {
            background-color: #fd7e14;
        }

        .visual-bar.rating-1 {
            background-color: #dc3545;
        }

        .visual-bar-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 9px;
            font-weight: bold;
            color: white;
        }

        /* Horizontal Bar Style - Simplified for PDF */
        .horizontal-bars {
            margin: 15px 0;
        }

        .bar-item {
            margin-bottom: 10px;
            border-bottom: 1px solid #eee;
            padding-bottom: 8px;
        }

        .bar-item-header {
            display: table;
            width: 100%;
            margin-bottom: 5px;
        }

        .bar-label {
            display: table-cell;
            width: 120px;
            font-size: 11px;
            font-weight: bold;
            text-align: left;
            vertical-align: middle;
        }

        .bar-value {
            display: table-cell;
            text-align: right;
            font-size: 11px;
            font-weight: bold;
            vertical-align: middle;
        }

        .bar-visual {
            width: 100%;
            height: 25px;
            background-color: #e9ecef;
            border: 1px solid #ccc;
            position: relative;
        }

        .bar-fill {
            height: 100%;
            position: relative;
        }

        /* Solid colors for horizontal bars */
        .bar-fill.color-1 {
            background-color: #007bff;
        }

        .bar-fill.color-2 {
            background-color: #28a745;
        }

        .bar-fill.color-3 {
            background-color: #ffc107;
        }

        .bar-fill.color-4 {
            background-color: #dc3545;
        }

        .bar-fill.color-5 {
            background-color: #6c757d;
        }

        .bar-text {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            font-size: 10px;
            font-weight: bold;
            color: white;
        }

        .question-container {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 6px;
            padding: 20px;
            margin: 20px 0;
        }

        .question-title {
            font-size: 14px;
            font-weight: bold;
            color: #007bff;
            margin-bottom: 15px;
            text-align: center;
        }

        .question-stats {
            text-align: center;
            margin-bottom: 15px;
            font-size: 11px;
            color: #666;
        }

        .no-data {
            text-align: center;
            color: #666;
            font-style: italic;
            padding: 20px;
            background-color: #f8f9fa;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .footer {
            position: fixed;
            bottom: 20px;
            right: 20px;
            font-size: 10px;
            color: #666;
        }

        .page-break {
            page-break-before: always;
        }

        /* Responsive adjustments for PDF */
        @media print {
            .stats-grid {
                display: block;
            }

            .stats-card {
                display: inline-block;
                width: 23%;
                margin: 1%;
            }
        }
    </style>
</head>

<body>
    <!-- Header -->
    <div class="header">
        <h1>LAPORAN WORKSHOP</h1>
        <div class="subtitle">{{ $workshop->title }}</div>
        <div class="subtitle">Tanggal: {{ \Carbon\Carbon::parse($workshop->date)->format('d/m/Y') }}</div>
    </div>

    <!-- Workshop Details Section -->
    <div class="section">
        <div class="section-title">Detail Workshop</div>

        <div class="info-grid">
            <div class="info-row">
                <div class="info-label">Judul Workshop</div>
                <div class="info-value">{{ $workshop->title }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Deskripsi</div>
                <div class="info-value">{{ $workshop->description ?? 'Tidak ada deskripsi' }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Tanggal</div>
                <div class="info-value">{{ \Carbon\Carbon::parse($workshop->date)->format('d F Y') }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Waktu</div>
                <div class="info-value">{{ $workshop->time_start }} - {{ $workshop->time_end }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Lokasi</div>
                <div class="info-value">{{ $workshop->location ?? 'Tidak ditentukan' }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Manfaat</div>
                <div class="info-value">{{ $workshop->benefit ?? 'Tidak ada manfaat yang tercantum' }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Status</div>
                <div class="info-value">{{ ucfirst($workshop->status) }}</div>
            </div>
        </div>

        <!-- Dynamic Stats from Backend -->
        <div class="stats-grid">
            <div class="stats-card">
                <div class="stats-number">{{ $stats['total_participants'] }}</div>
                <div class="stats-label">Total Peserta</div>
            </div>
            <div class="stats-card">
                <div class="stats-number">{{ $stats['quota'] }}</div>
                <div class="stats-label">Kuota Maksimal</div>
            </div>
            <div class="stats-card">
                <div class="stats-number">{{ $stats['completion_rate'] }}%</div>
                <div class="stats-label">Tingkat Partisipasi</div>
            </div>
            @if ($stats['overall_satisfaction'] > 0)
                <div class="stats-card">
                    <div class="stats-number">{{ $stats['overall_satisfaction'] }}</div>
                    <div class="stats-label">Rating Rata-rata</div>
                </div>
            @endif
        </div>
    </div>

    <!-- Participants Section -->
    <div class="section page-break">
        <div class="section-title">Daftar Peserta ({{ $participants->count() }} Orang)</div>

        @if ($participants->count() > 0)
            <table class="participants-table">
                <thead>
                    <tr>
                        <th style="width: 5%;">No</th>
                        <th style="width: 25%;">Nama</th>
                        <th style="width: 25%;">Email</th>
                        <th style="width: 15%;">WhatsApp</th>
                        <th style="width: 20%;">Kampus</th>
                        <th style="width: 10%;">Jurusan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($participants as $index => $participant)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $participant->name }}</td>
                            <td>{{ $participant->email }}</td>
                            <td>{{ $participant->whatsapp }}</td>
                            <td>{{ $participant->campus ?? '-' }}</td>
                            <td>{{ $participant->major ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="no-data">Belum ada peserta yang terdaftar</div>
        @endif
    </div>

    <!-- Analytics Section with Dynamic Data -->
    <div class="section page-break">
        <div class="section-title">Analisis Feedback</div>

        @if (count($analytics) > 0)
            @foreach ($analytics as $analytic)
                <div class="question-container">
                    <div class="question-title">{{ $analytic['question'] }}</div>
                    <div class="question-stats">
                        Total Responden: {{ $analytic['total_responses'] }}
                        | Tipe: {{ ucfirst(str_replace('_', ' ', $analytic['type'])) }}
                        @if (isset($analytic['average_rating']))
                            | Rata-rata: {{ $analytic['average_rating'] }}/5
                        @endif
                    </div>

                    @if ($analytic['chart_type'] === 'progress_bar')
                        {{-- Progress Bar for Multiple Choice (≤4 options) --}}
                        <div class="progress-container">
                            @foreach ($analytic['data'] as $index => $item)
                                <div class="progress-item">
                                    <div class="progress-label-flex">
                                        <div class="progress-label-left">{{ $item['label'] }}</div>
                                        <div class="progress-label-right">{{ $item['value'] }}
                                            ({{ $item['percentage'] }}%)</div>
                                    </div>
                                    <div class="progress-bar">
                                        <div class="progress-fill color-{{ ($index % 5) + 1 }}"
                                            style="width: {{ max($item['percentage'], 3) }}%">
                                            <div class="progress-text">{{ $item['percentage'] }}%</div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @elseif ($analytic['chart_type'] === 'horizontal_bar')
                        {{-- Horizontal Bar for Multiple Choice (>4 options) --}}
                        <div class="horizontal-bars">
                            @foreach ($analytic['data'] as $index => $item)
                                <div class="bar-item">
                                    <div class="bar-item-header">
                                        <div class="bar-label">{{ $item['label'] }}</div>
                                        <div class="bar-value">{{ $item['value'] }} ({{ $item['percentage'] }}%)</div>
                                    </div>
                                    <div class="bar-visual">
                                        <div class="bar-fill color-{{ ($index % 5) + 1 }}"
                                            style="width: {{ max($item['percentage'], 3) }}%">
                                            <div class="bar-text">{{ $item['percentage'] }}%</div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @elseif ($analytic['chart_type'] === 'rating_table')
                        {{-- Table with Visual Bars for Rating Questions --}}
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Rating</th>
                                    <th>Jumlah</th>
                                    <th>Persentase</th>
                                    <th>Visualisasi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($analytic['data'] as $item)
                                    <tr>
                                        <td>{{ $item['label'] }}</td>
                                        <td>{{ $item['value'] }}</td>
                                        <td>{{ $item['percentage'] }}%</td>
                                        <td>
                                            @if ($item['percentage'] > 0)
                                                <div class="visual-bar rating-{{ $item['rating'] }}"
                                                    style="width: {{ max($item['percentage'], 3) }}%">
                                                    <div class="visual-bar-text">{{ $item['percentage'] }}%</div>
                                                </div>
                                            @else
                                                <div style="color: #999; font-style: italic;">-</div>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div style="text-align: center; margin-top: 10px; font-weight: bold; color: #007bff;">
                            Rata-rata Rating: {{ $analytic['average_rating'] }}/5
                        </div>
                    @endif
                </div>
            @endforeach
        @else
            <div class="no-data">Belum ada data feedback untuk dianalisis</div>
        @endif
    </div>

    <!-- Footer -->
    <div class="footer">
        Laporan dibuat pada: {{ $generatedAt }}
    </div>
</body>

</html>
