<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Raport Kelas - {{ $kelas->jenjang }} {{ $kelas->tingkat }} {{ $kelas->nama }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 11px;
            line-height: 1.4;
            color: #333;
        }
        
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .header {
            text-align: center;
            border-bottom: 3px solid #007bff;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        
        .header h1 {
            font-size: 18px;
            font-weight: bold;
            color: #007bff;
            margin-bottom: 5px;
        }
        
        .header p {
            font-size: 10px;
            color: #666;
            margin-bottom: 2px;
        }
        
        .header h2 {
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
            color: #333;
            margin-top: 15px;
            margin-bottom: 5px;
        }
        
        .header h3 {
            font-size: 14px;
            color: #007bff;
            text-transform: uppercase;
        }
        
        .kelas-info {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 30px;
        }
        
        .kelas-info h4 {
            color: #007bff;
            margin-bottom: 10px;
            font-size: 12px;
        }
        
        .kelas-info table {
            width: 100%;
        }
        
        .kelas-info td {
            padding: 3px 0;
            vertical-align: top;
        }
        
        .kelas-info .label {
            font-weight: bold;
            width: 120px;
        }
        
        .kelas-info .colon {
            width: 10px;
        }
        
        .section-title {
            font-size: 13px;
            font-weight: bold;
            color: #007bff;
            text-transform: uppercase;
            margin-bottom: 15px;
            border-bottom: 2px solid #007bff;
            padding-bottom: 5px;
        }
        
        .siswa-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
            font-size: 10px;
        }
        
        .siswa-table th,
        .siswa-table td {
            border: 1px solid #333;
            padding: 6px 4px;
            text-align: center;
            vertical-align: middle;
        }
        
        .siswa-table th {
            background-color: #007bff;
            color: white;
            font-weight: bold;
            font-size: 9px;
        }
        
        .siswa-table .nama {
            text-align: left;
            font-weight: bold;
        }
        
        .siswa-table .email {
            text-align: left;
            font-size: 9px;
        }
        
        .grade-badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 3px;
            color: white;
            font-weight: bold;
            font-size: 8px;
        }
        
        .grade-a { background-color: #28a745; }
        .grade-b { background-color: #17a2b8; }
        .grade-c { background-color: #ffc107; color: #333; }
        .grade-d { background-color: #dc3545; }
        .grade-e { background-color: #343a40; }
        
        .tuntas { color: #28a745; font-weight: bold; }
        .belum-tuntas { color: #dc3545; font-weight: bold; }
        
        .footer {
            text-align: center;
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #dee2e6;
            font-size: 9px;
            color: #666;
        }
        
        .page-break {
            page-break-before: always;
        }
        
        .text-center { text-align: center; }
        .text-left { text-align: left; }
        .text-right { text-align: right; }
        
        .text-success { color: #28a745; }
        .text-danger { color: #dc3545; }
        .text-warning { color: #ffc107; }
        .text-primary { color: #007bff; }
        
        .fw-bold { font-weight: bold; }
        
        .no-data {
            text-align: center;
            padding: 40px 20px;
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 5px;
            color: #856404;
        }
        
        .summary-stats {
            display: table;
            width: 100%;
            margin-bottom: 20px;
        }
        
        .summary-stats .col {
            display: table-cell;
            width: 25%;
            text-align: center;
            padding: 0 10px;
        }
        
        .stat-box {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 10px;
        }
        
        .stat-number {
            font-size: 18px;
            font-weight: bold;
            color: #007bff;
            margin-bottom: 3px;
        }
        
        .stat-label {
            font-size: 9px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>SMA NEGERI 1 JAKARTA</h1>
            <p>Jl. Pendidikan No. 123, Jakarta Pusat</p>
            <p>Telp: (021) 1234567 | Email: info@sman1jakarta.sch.id</p>
            
            <h2>Laporan Hasil Belajar Kelas</h2>
            <h3>{{ $kelas->jenjang }} {{ $kelas->tingkat }} {{ $kelas->nama }} - Semester {{ $semester }}</h3>
        </div>

        <!-- Info Kelas -->
        <div class="kelas-info">
            <h4>Informasi Kelas</h4>
            <table>
                <tr>
                    <td class="label">Kelas</td>
                    <td class="colon">:</td>
                    <td>{{ $kelas->jenjang }} {{ $kelas->tingkat }} {{ $kelas->nama }}</td>
                </tr>
                <tr>
                    <td class="label">Tahun Ajaran</td>
                    <td class="colon">:</td>
                    <td>{{ $kelas->tahun_ajaran_nama }}</td>
                </tr>
                <tr>
                    <td class="label">Semester</td>
                    <td class="colon">:</td>
                    <td>{{ $semester }}</td>
                </tr>
                <tr>
                    <td class="label">Total Siswa</td>
                    <td class="colon">:</td>
                    <td>{{ count($siswa_list) }} siswa</td>
                </tr>
                <tr>
                    <td class="label">Tanggal Cetak</td>
                    <td class="colon">:</td>
                    <td>{{ \Carbon\Carbon::now()->format('d F Y') }}</td>
                </tr>
            </table>
        </div>

        <!-- Statistik Kelas -->
        @php
            $totalNilai = 0;
            $rataRataKelas = 0;
            $totalTuntas = 0;
            $totalBelumTuntas = 0;
            $siswaYangPunyaNilai = 0;
            
            foreach ($raport_data as $raport) {
                if ($raport['statistik']->total_nilai > 0) {
                    $siswaYangPunyaNilai++;
                    $totalNilai += $raport['statistik']->total_nilai;
                    $rataRataKelas += $raport['statistik']->rata_rata;
                    $totalTuntas += $raport['statistik']->tuntas;
                    $totalBelumTuntas += $raport['statistik']->belum_tuntas;
                }
            }
            
            $rataRataKelas = $siswaYangPunyaNilai > 0 ? $rataRataKelas / $siswaYangPunyaNilai : 0;
            $persentaseTuntas = ($totalTuntas + $totalBelumTuntas) > 0 ? 
                                (($totalTuntas / ($totalTuntas + $totalBelumTuntas)) * 100) : 0;
        @endphp

        <div class="section-title">Statistik Kelas</div>
        <div class="summary-stats">
            <div class="col">
                <div class="stat-box">
                    <div class="stat-number">{{ count($siswa_list) }}</div>
                    <div class="stat-label">Total Siswa</div>
                </div>
            </div>
            <div class="col">
                <div class="stat-box">
                    <div class="stat-number">{{ $siswaYangPunyaNilai }}</div>
                    <div class="stat-label">Siswa Punya Nilai</div>
                </div>
            </div>
            <div class="col">
                <div class="stat-box">
                    <div class="stat-number">{{ number_format($rataRataKelas, 1) }}</div>
                    <div class="stat-label">Rata-rata Kelas</div>
                </div>
            </div>
            <div class="col">
                <div class="stat-box">
                    <div class="stat-number">{{ number_format($persentaseTuntas, 1) }}%</div>
                    <div class="stat-label">Persentase Tuntas</div>
                </div>
            </div>
        </div>

        <!-- Daftar Siswa -->
        <div class="section-title">Daftar Siswa dan Prestasi</div>
        
        @if(count($siswa_list) > 0)
            <table class="siswa-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Siswa</th>
                        <th>Email</th>
                        <th>Total Nilai</th>
                        <th>Rata-rata</th>
                        <th>Grade</th>
                        <th>Tuntas</th>
                        <th>Belum Tuntas</th>
                        <th>Ranking</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        // Urutkan siswa berdasarkan rata-rata nilai
                        $siswaWithRata = [];
                        foreach ($raport_data as $index => $raport) {
                            $siswaWithRata[] = [
                                'data' => $raport,
                                'rata_rata' => $raport['statistik']->total_nilai > 0 ? $raport['statistik']->rata_rata : 0,
                                'siswa_info' => $siswa_list[$index]
                            ];
                        }
                        
                        usort($siswaWithRata, function($a, $b) {
                            return $b['rata_rata'] <=> $a['rata_rata'];
                        });
                    @endphp
                    
                    @foreach($siswaWithRata as $index => $item)
                        @php
                            $raport = $item['data'];
                            $siswa = $raport['siswa'];
                            $stats = $raport['statistik'];
                            
                            $rataRata = $stats->total_nilai > 0 ? $stats->rata_rata : 0;
                            $grade = '';
                            $gradeClass = '';
                            
                            if ($rataRata >= 90) {
                                $grade = 'A';
                                $gradeClass = 'grade-a';
                            } elseif ($rataRata >= 80) {
                                $grade = 'B';
                                $gradeClass = 'grade-b';
                            } elseif ($rataRata >= 70) {
                                $grade = 'C';
                                $gradeClass = 'grade-c';
                            } elseif ($rataRata >= 60) {
                                $grade = 'D';
                                $gradeClass = 'grade-d';
                            } elseif ($rataRata > 0) {
                                $grade = 'E';
                                $gradeClass = 'grade-e';
                            } else {
                                $grade = '-';
                                $gradeClass = '';
                            }
                        @endphp
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td class="nama">{{ $siswa->siswa_nama }}</td>
                            <td class="email">{{ $siswa->siswa_email }}</td>
                            <td>{{ $stats->total_nilai ?: 0 }}</td>
                            <td class="fw-bold">{{ $rataRata > 0 ? number_format($rataRata, 1) : '-' }}</td>
                            <td>
                                @if($grade != '-')
                                    <span class="grade-badge {{ $gradeClass }}">{{ $grade }}</span>
                                @else
                                    -
                                @endif
                            </td>
                            <td class="text-success">{{ $stats->tuntas ?: 0 }}</td>
                            <td class="text-danger">{{ $stats->belum_tuntas ?: 0 }}</td>
                            <td class="fw-bold">{{ $rataRata > 0 ? ($index + 1) : '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="no-data">
                <h3 style="margin-bottom: 10px;">Tidak Ada Data Siswa</h3>
                <p>Belum ada siswa yang terdaftar di kelas ini.</p>
            </div>
        @endif

        <!-- Halaman baru untuk detail per siswa -->
        @foreach($raport_data as $raport)
            @if($raport['statistik']->total_nilai > 0)
                <div class="page-break">
                    <div class="header">
                        <h1>SMA NEGERI 1 JAKARTA</h1>
                        <p>Jl. Pendidikan No. 123, Jakarta Pusat</p>
                        <p>Telp: (021) 1234567 | Email: info@sman1jakarta.sch.id</p>
                        
                        <h2>Laporan Hasil Belajar Siswa</h2>
                        <h3>Semester {{ $semester }}</h3>
                    </div>

                    <!-- Data Siswa -->
                    <div style="display: table; width: 100%; margin-bottom: 30px;">
                        <div style="display: table-cell; width: 50%; vertical-align: top; padding-right: 20px;">
                            <table style="width: 100%;">
                                <tr>
                                    <td style="font-weight: bold; width: 120px; padding: 3px 0;">Nama Siswa</td>
                                    <td style="width: 10px;">:</td>
                                    <td style="padding: 3px 0;">{{ $raport['siswa']->siswa_nama }}</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold; padding: 3px 0;">Email</td>
                                    <td>:</td>
                                    <td style="padding: 3px 0;">{{ $raport['siswa']->siswa_email }}</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold; padding: 3px 0;">Kelas</td>
                                    <td>:</td>
                                    <td style="padding: 3px 0;">{{ $raport['siswa']->jenjang }} {{ $raport['siswa']->tingkat }} {{ $raport['siswa']->kelas_nama }}</td>
                                </tr>
                            </table>
                        </div>
                        <div style="display: table-cell; width: 50%; vertical-align: top;">
                            <table style="width: 100%;">
                                <tr>
                                    <td style="font-weight: bold; width: 120px; padding: 3px 0;">Semester</td>
                                    <td style="width: 10px;">:</td>
                                    <td style="padding: 3px 0;">{{ $raport['semester'] }}</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold; padding: 3px 0;">Tahun Ajaran</td>
                                    <td>:</td>
                                    <td style="padding: 3px 0;">{{ $raport['siswa']->tahun_ajaran_nama }}</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold; padding: 3px 0;">Ranking</td>
                                    <td>:</td>
                                    <td style="padding: 3px 0;">{{ $raport['ranking'] }} dari {{ $raport['total_siswa_kelas'] }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <!-- Hasil Belajar -->
                    <div class="section-title">Hasil Belajar</div>
                    
                    <table class="siswa-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Mata Pelajaran</th>
                                <th>Kode</th>
                                <th>Rata-rata</th>
                                <th>Grade</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = 1; @endphp
                            @foreach($raport['nilai_per_mapel'] as $mata_pelajaran => $data)
                                @php
                                    $rataRata = $data['rata_rata'];
                                    $grade = '';
                                    $gradeClass = '';
                                    if ($rataRata >= 90) {
                                        $grade = 'A';
                                        $gradeClass = 'grade-a';
                                    } elseif ($rataRata >= 80) {
                                        $grade = 'B';
                                        $gradeClass = 'grade-b';
                                    } elseif ($rataRata >= 70) {
                                        $grade = 'C';
                                        $gradeClass = 'grade-c';
                                    } elseif ($rataRata >= 60) {
                                        $grade = 'D';
                                        $gradeClass = 'grade-d';
                                    } else {
                                        $grade = 'E';
                                        $gradeClass = 'grade-e';
                                    }
                                @endphp
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td class="nama">{{ $mata_pelajaran }}</td>
                                    <td>{{ $data['kode'] }}</td>
                                    <td class="fw-bold">{{ number_format($rataRata, 1) }}</td>
                                    <td><span class="grade-badge {{ $gradeClass }}">{{ $grade }}</span></td>
                                    <td class="{{ $data['tuntas'] ? 'tuntas' : 'belum-tuntas' }}">
                                        {{ $data['tuntas'] ? 'TUNTAS' : 'BELUM TUNTAS' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot style="background-color: #f8f9fa;">
                            <tr>
                                <td colspan="3" class="text-center fw-bold">RATA-RATA KESELURUHAN</td>
                                <td class="fw-bold">{{ number_format($raport['statistik']->rata_rata, 1) }}</td>
                                <td>
                                    @php
                                        $overallGrade = '';
                                        $overallClass = '';
                                        if ($raport['statistik']->rata_rata >= 90) {
                                            $overallGrade = 'A';
                                            $overallClass = 'grade-a';
                                        } elseif ($raport['statistik']->rata_rata >= 80) {
                                            $overallGrade = 'B';
                                            $overallClass = 'grade-b';
                                        } elseif ($raport['statistik']->rata_rata >= 70) {
                                            $overallGrade = 'C';
                                            $overallClass = 'grade-c';
                                        } elseif ($raport['statistik']->rata_rata >= 60) {
                                            $overallGrade = 'D';
                                            $overallClass = 'grade-d';
                                        } else {
                                            $overallGrade = 'E';
                                            $overallClass = 'grade-e';
                                        }
                                    @endphp
                                    <span class="grade-badge {{ $overallClass }}">{{ $overallGrade }}</span>
                                </td>
                                <td class="{{ $raport['statistik']->rata_rata >= 75 ? 'tuntas' : 'belum-tuntas' }}">
                                    {{ $raport['statistik']->rata_rata >= 75 ? 'TUNTAS' : 'BELUM TUNTAS' }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>

                    <!-- Ringkasan singkat -->
                    <div style="margin-top: 20px;">
                        <p><strong>Ringkasan:</strong> Total {{ count($raport['nilai_per_mapel']) }} mata pelajaran, 
                        {{ $raport['statistik']->tuntas }} tuntas, {{ $raport['statistik']->belum_tuntas }} belum tuntas.
                        Ranking {{ $raport['ranking'] }} dari {{ $raport['total_siswa_kelas'] }} siswa.</p>
                    </div>
                </div>
            @endif
        @endforeach

        <!-- Footer -->
        <div class="footer">
            Dokumen ini digenerate secara otomatis oleh Sistem Informasi Akademik<br>
            Tanggal cetak: {{ \Carbon\Carbon::now()->format('d F Y') }}
        </div>
    </div>
</body>
</html>
