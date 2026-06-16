<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Hasil Akhir - Kelas {{ $kelas }}</title>
    <style>
        /* CSS KHUSUS PRINT FORMAL */
        body {
            font-family: 'Times New Roman', Times, serif;
            color: #000;
            background: #fff;
            margin: 0;
            padding: 20px;
        }
        .kop-surat {
            text-align: center;
            border-bottom: 3px solid #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .kop-surat h2, .kop-surat h3, .kop-surat p {
            margin: 2px 0;
        }
        .informasi-laporan {
            margin-bottom: 20px;
            font-size: 12pt;
        }
        .informasi-laporan table {
            border: none;
        }
        .informasi-laporan td {
            border: none;
            padding: 2px 10px 2px 0;
        }
        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        table.data-table th, table.data-table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
            font-size: 11pt;
        }
        table.data-table th {
            background-color: #f2f2f2;
            text-align: center;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        
        .signature-section {
            width: 100%;
            margin-top: 50px;
            display: flex;
            justify-content: flex-end;
        }
        .signature-box {
            width: 300px;
            text-align: center;
        }
        .signature-name {
            margin-top: 80px;
            font-weight: bold;
            text-decoration: underline;
        }

        /* Pengaturan Kertas saat dicetak */
        @media print {
            @page {
                size: A4;
                margin: 2cm;
            }
            body {
                padding: 0;
            }
        }
    </style>
</head>
<body onload="window.print()">

    <div class="kop-surat">
        <h2>TK RAUDLATUL HIKMAH</h2>
        <p>Jl. Contoh Alamat No. 123, Kota Surabaya, Jawa Timur</p>
        <p>Email: tk.raudlatulhikmah@example.com | Telp: (031) 123456</p>
    </div>

    <h3 class="text-center" style="margin-bottom: 20px;">LAPORAN HASIL PENENTUAN SISWA TERAMPIL</h3>

    <div class="informasi-laporan">
        <table style="width: auto;">
            <tr>
                <td><strong>Kelas</strong></td>
                <td>: {{ $kelas }}</td>
            </tr>
            <tr>
                <td><strong>Tahun Ajaran</strong></td>
                <td>: {{ $tahun }}</td>
            </tr>
            <tr>
                <td><strong>Semester</strong></td>
                <td>: {{ $semester }}</td>
            </tr>
        </table>
    </div>

    <table class="data-table">
        <thead>
            <tr>
                <th width="5%">Peringkat</th>
                <th width="15%">NIS</th>
                <th width="40%">Nama Siswa</th>
                <th width="20%">Skor Akhir (Z)</th>
                <th width="20%">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($hasilAkhir as $hasil)
                <tr>
                    <td class="text-center"><strong>{{ $hasil->peringkat }}</strong></td>
                    <td class="text-center">{{ $hasil->siswa->nis }}</td>
                    <td>{{ $hasil->siswa->nama_siswa }}</td>
                    <td class="text-center">{{ number_format($hasil->total_skor_z, 4) }}</td>
                    <td class="text-center">{{ $hasil->status }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Tidak ada data hasil akhir untuk kelas ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>