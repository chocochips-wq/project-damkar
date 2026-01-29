<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 3px solid #e74c3c;
        }
        .header h1 {
            font-size: 28px;
            color: #c0392b;
            margin-bottom: 10px;
        }
        .header p {
            color: #666;
            font-size: 14px;
        }
        .content {
            margin-bottom: 30px;
        }
        .content h2 {
            font-size: 18px;
            color: #2c3e50;
            margin-top: 20px;
            margin-bottom: 10px;
            padding-bottom: 5px;
            border-bottom: 2px solid #3498db;
        }
        .content p {
            margin-bottom: 10px;
            text-align: justify;
            font-size: 14px;
        }
        .info-grid {
            display: table;
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
        }
        .info-row {
            display: table-row;
        }
        .info-label {
            display: table-cell;
            width: 30%;
            padding: 8px;
            font-weight: bold;
            background-color: #ecf0f1;
            border: 1px solid #bdc3c7;
        }
        .info-value {
            display: table-cell;
            width: 70%;
            padding: 8px;
            border: 1px solid #bdc3c7;
        }
        .thumbnail {
            max-width: 400px;
            margin: 20px 0;
            text-align: center;
        }
        .thumbnail img {
            max-width: 100%;
            height: auto;
            border: 1px solid #bdc3c7;
            border-radius: 5px;
        }
        .section-title {
            margin-top: 30px;
            font-size: 16px;
            font-weight: bold;
            color: #2c3e50;
            padding: 10px;
            background-color: #ecf0f1;
            border-left: 4px solid #3498db;
        }
        .footer {
            text-align: center;
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #bdc3c7;
            font-size: 12px;
            color: #7f8c8d;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>LAPORAN DOKUMENTASI</h1>
        <p>Dinas Pemadam Kebakaran</p>
    </div>

    <!-- Info Grid -->
    <div class="info-grid">
        <div class="info-row">
            <div class="info-label">Nama Kegiatan</div>
            <div class="info-value">{{ $dokumentasi->nama_kegiatan }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Tanggal Kegiatan</div>
            <div class="info-value">{{ $dokumentasi->tanggal_kegiatan->format('d F Y') }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Tanggal Laporan</div>
            <div class="info-value">{{ now()->format('d F Y') }}</div>
        </div>
    </div>

    <!-- Content -->
    <div class="content">
        <div class="section-title">Keterangan</div>
        <p>{!! nl2br(e($dokumentasi->keterangan)) !!}</p>
    </div>

    <!-- Thumbnail -->
    @if($dokumentasi->thumbnail && !str_starts_with($dokumentasi->thumbnail, 'http'))
        <div class="thumbnail">
            <img src="{{ asset('storage/' . $dokumentasi->thumbnail) }}" alt="Thumbnail">
        </div>
    @endif

    <!-- Files Section -->
    @if($dokumentasi->files && $dokumentasi->files->count() > 0)
        <div class="section-title">Foto & File Dokumentasi ({{ $dokumentasi->files->count() }} item)</div>
        <p style="margin-bottom: 15px; color: #666;">Berikut adalah dokumentasi foto kegiatan {{ $dokumentasi->nama_kegiatan }}:</p>
        
        @foreach($dokumentasi->files as $file)
            @if($file->file_url && !str_starts_with($file->file_url, 'http'))
                <div style="page-break-inside: avoid; margin-bottom: 25px;">
                    <img src="{{ asset('storage/' . $file->file_url) }}" 
                         alt="Foto" 
                         style="max-width: 100%; height: auto; border: 1px solid #bdc3c7; border-radius: 5px;">
                </div>
            @endif
        @endforeach
    @endif

    <!-- Footer -->
    <div class="footer">
        <p>Dokumen ini dibuat pada {{ now()->format('d F Y H:i') }}</p>
        <p>Sistem Manajemen Dokumentasi - Dinas Pemadam Kebakaran</p>
    </div>
</body>
</html>
