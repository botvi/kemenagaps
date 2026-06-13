<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Data Jemaah Haji - KEMENHAJ KUANSING</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Arial', sans-serif;
            font-size: 11px;
            color: #1a1a1a;
            background: #fff;
        }

        /* ====== KOP SURAT ====== */
        .kop {
            display: flex;
            align-items: center;
            gap: 18px;
            padding: 14px 20px 10px;
            border-bottom: 3px solid #16a34a;
        }
        .kop img {
            height: 80px;
            width: auto;
            object-fit: contain;
            flex-shrink: 0;
        }
        .kop-text { line-height: 1.45; }
        .kop-text .instansi {
            font-size: 18px;
            font-weight: 800;
            color: #15803d;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }
        .kop-text .alamat {
            font-size: 10.5px;
            color: #444;
            margin-top: 2px;
        }
        .kop-text .sub-line {
            font-size: 10px;
            color: #666;
        }

        /* ====== JUDUL LAPORAN ====== */
        .judul-box {
            text-align: center;
            padding: 10px 0 6px;
            border-bottom: 1px solid #ccc;
            margin-bottom: 10px;
        }
        .judul-box h1 {
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .judul-box .sub {
            font-size: 10px;
            color: #555;
            margin-top: 2px;
        }

        /* ====== INFO FILTER ====== */
        .filter-info {
            display: flex;
            flex-wrap: wrap;
            gap: 6px 20px;
            font-size: 10.5px;
            padding: 6px 20px 10px;
            color: #444;
        }
        .filter-info span strong { color: #111; }

        /* ====== TABEL ====== */
        .wrap { padding: 0 20px 20px; }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10.5px;
        }
        thead tr th {
            background: #15803d;
            color: #fff;
            padding: 7px 6px;
            text-align: center;
            font-weight: 700;
            border: 1px solid #15803d;
        }
        tbody tr td {
            padding: 6px 6px;
            border: 1px solid #d1d5db;
            vertical-align: top;
        }
        tbody tr:nth-child(even) { background: #f0fdf4; }
        tbody tr:nth-child(odd)  { background: #fff; }

        .text-center { text-align: center; }
        .text-muted  { color: #888; }

        /* Badge status */
        .badge {
            display: inline-block;
            padding: 2px 7px;
            border-radius: 10px;
            font-size: 9.5px;
            font-weight: 700;
            color: #fff;
        }
        .badge-warning   { background: #d97706; }
        .badge-success   { background: #16a34a; }
        .badge-danger    { background: #dc2626; }
        .badge-secondary { background: #6b7280; }
        .badge-info      { background: #0ea5e9; }
        .badge-pink      { background: #db2777; }

        /* ====== FOOTER ====== */
        .footer-sign {
            display: flex;
            justify-content: flex-end;
            padding: 20px 20px 0;
        }
        .sign-box {
            text-align: center;
            width: 200px;
        }
        .sign-box .place-date { font-size: 10.5px; margin-bottom: 60px; }
        .sign-box .name { font-weight: 700; border-top: 1px solid #111; padding-top: 4px; }
        .sign-box .jabatan { font-size: 10px; color: #555; }

        .print-info {
            font-size: 9px;
            color: #aaa;
            text-align: center;
            padding: 10px 0 4px;
            border-top: 1px solid #eee;
            margin: 16px 20px 0;
        }

        /* ====== PRINT ====== */
        @media print {
            body { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .no-print { display: none !important; }
            thead th { background: #15803d !important; -webkit-print-color-adjust: exact; }
            tbody tr:nth-child(even) { background: #f0fdf4 !important; }
        }
    </style>
</head>
<body>

    <!-- Tombol Cetak (hilang saat print) -->
    <div class="no-print" style="text-align:center; padding: 12px; background: #f1f5f9;">
        <button onclick="window.print()"
            style="background:#16a34a;color:#fff;border:none;padding:9px 28px;border-radius:6px;font-size:13px;font-weight:600;cursor:pointer;margin-right:8px;">
            🖨️ Cetak / Print
        </button>
        <button onclick="window.close()"
            style="background:#6b7280;color:#fff;border:none;padding:9px 18px;border-radius:6px;font-size:13px;cursor:pointer;">
            ✕ Tutup
        </button>
    </div>

    <!-- KOP SURAT -->
    <div class="kop">
        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSA3ejR6sDhtz1fhMAM3-GDxUQO4Y6EYcsxOg&s"
             alt="Logo KEMENHAJ KUANSING"
             onerror="this.style.display='none'">
        <div class="kop-text">
            <div class="instansi">KEMENHAJ KUANTAN SINGINGI</div>
            <div class="alamat">Jalan Simpang Barangan, Kelurahan Beringin, Kecamatan Kuantan Tengah</div>
            <div class="sub-line">Teluk Kuantan, Provinsi Riau</div>
        </div>
    </div>

    <!-- JUDUL -->
    <div class="judul-box">
        <h1>Laporan Data Jemaah Haji</h1>
        <div class="sub">Dicetak pada: {{ \Carbon\Carbon::now()->translatedFormat('d F Y, H:i') }} WIB</div>
    </div>

    <!-- INFO FILTER -->
    @php
        $statusLabel = [
            'aktif'    => 'Aktif',
            'nonaktif' => 'Nonaktif',
        ];
    @endphp
    <div class="filter-info">
        <span><strong>Status Akun&nbsp;&nbsp;&nbsp;:</strong>
            {{ isset($filters['status']) && $filters['status'] ? ($statusLabel[$filters['status']] ?? $filters['status']) : 'Semua' }}
        </span>
        <span><strong>Jenis Kelamin :</strong>
            {{ $filters['jenis_kelamin'] ?? 'Semua' }}
        </span>
        <span><strong>Rentang Usia :</strong>
            @if(($filters['usia_min'] ?? '') || ($filters['usia_max'] ?? ''))
                {{ $filters['usia_min'] ?? '0' }} &ndash; {{ $filters['usia_max'] ?? '∞' }} tahun
            @else
                Semua
            @endif
        </span>
        <span><strong>Total Data&nbsp;&nbsp;&nbsp;:</strong> {{ $jemaahs->count() }} jemaah</span>
    </div>

    <!-- TABEL DATA -->
    <div class="wrap">
        <table>
            <thead>
                <tr>
                    <th style="width:28px;">No</th>
                    <th style="width:130px;">Nama Jemaah</th>
                    <th style="width:90px;">No. WA</th>
                    <th style="width:40px;">Usia</th>
                    <th style="width:65px;">Jenis Kelamin</th>
                    <th style="width:110px;">Paket Haji</th>
                    <th style="width:75px;">Status Akun</th>
                    <th style="width:75px;">Tgl Daftar</th>
                </tr>
            </thead>
            <tbody>
                @forelse($jemaahs as $item)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $item->user->name ?? '-' }}</td>
                    <td>{{ $item->user->no_wa ?? '-' }}</td>
                    <td class="text-center">{{ $item->user->usia ?? '-' }}</td>
                    <td class="text-center">
                        @if($item->user->jenis_kelamin == 'Laki-laki')
                            <span class="badge badge-info">L</span>
                        @elseif($item->user->jenis_kelamin == 'Perempuan')
                            <span class="badge badge-pink">P</span>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    <td>{{ $item->paketHaji->nama_paket ?? '-' }}</td>
                    <td class="text-center">
                        @if(($item->user->status ?? 'aktif') == 'aktif')
                            <span class="badge badge-success">Aktif</span>
                        @else
                            <span class="badge badge-danger">Nonaktif</span>
                        @endif
                    </td>
                    <td class="text-center">
                        {{ $item->created_at->translatedFormat('d M Y') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="10" class="text-center text-muted" style="padding:16px;">
                        Tidak ada data yang sesuai dengan filter.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Tanda Tangan -->
    <div class="footer-sign">
        <div class="sign-box">
            <div class="place-date">Teluk Kuantan, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</div>
            <div class="name">Kepala KEMENHAJ KUANSING</div>
            <div class="jabatan">_________________________</div>
        </div>
    </div>

    <!-- Info Cetak -->
    <div class="print-info">
        Dokumen ini dicetak secara otomatis oleh Sistem Informasi KEMENHAJ KUANTAN SINGINGI &bull;
        {{ \Carbon\Carbon::now()->translatedFormat('d F Y H:i') }} WIB
    </div>

    <script>
        // Auto print saat halaman dibuka
        window.onload = function() {
            // Beri jeda agar gambar logo sempat dimuat
        };
    </script>
</body>
</html>
