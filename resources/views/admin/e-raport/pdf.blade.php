<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Raport - {{ $siswa->siswa_nama }}</title>
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
        
        .data-siswa {
            display: table;
            width: 100%;
            margin-bottom: 30px;
        }
        
        .data-siswa .col {
            display: table-cell;
            width: 50%;
            vertical-align: top;
            padding-right: 20px;
        }
        
        .data-table {
            width: 100%;
        }
        
        .data-table td {
            padding: 3px 0;
            vertical-align: top;
        }
        
        .data-table .label {
            font-weight: bold;
            width: 120px;
        }
        
        .data-table .colon {
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
        
        .nilai-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
            font-size: 10px;
        }
        
        .nilai-table th,
        .nilai-table td {
            border: 1px solid #333;
            padding: 6px 4px;
            text-align: center;
            vertical-align: middle;
        }
        
        .nilai-table th {
            background-color: #007bff;
            color: white;
            font-weight: bold;
            font-size: 9px;
        }
        
        .nilai-table .mapel {
            text-align: left;
            font-weight: bold;
        }
        
        .nilai-table .rata-rata {
            font-weight: bold;
        }
        
        .nilai-table .tuntas {
            color: #28a745;
            font-weight: bold;
        }
        
        .nilai-table .belum-tuntas {
            color: #dc3545;
            font-weight: bold;
        }
        
        .nilai-table tfoot {
            background-color: #f8f9fa;
        }
        
        .nilai-table tfoot td {
            font-weight: bold;
        }
        
        .grade-badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 3px;
            color: white;
            font-weight: bold;
            font-size: 9px;
        }
        
        .grade-a { background-color: #28a745; }
        .grade-b { background-color: #17a2b8; }
        .grade-c { background-color: #ffc107; color: #333; }
        .grade-d { background-color: #dc3545; }
        .grade-e { background-color: #343a40; }
        
        .ringkasan {
            display: table;
            width: 100%;
            margin-bottom: 30px;
        }
        
        .ringkasan .col {
            display: table-cell;
            width: 33.33%;
            vertical-align: top;
            padding-right: 15px;
        }
        
        .prestasi-box {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 15px;
        }
        
        .prestasi-item {
            display: table;
            width: 100%;
            margin-bottom: 5px;
        }
        
        .prestasi-item .left {
            display: table-cell;
            width: 70%;
        }
        
        .prestasi-item .right {
            display: table-cell;
            width: 30%;
            font-weight: bold;
            text-align: right;
        }
        
        .grade-dist-item {
            display: table;
            width: 100%;
            margin-bottom: 3px;
        }
        
        .grade-dist-item .grade {
            display: table-cell;
            width: 30%;
        }
        
        .grade-dist-item .count {
            display: table-cell;
            width: 70%;
        }
        
        .catatan-section {
            margin-top: 40px;
        }
        
        .catatan-box {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 15px;
            min-height: 100px;
            margin-bottom: 20px;
        }
        
        .signature-area {
            text-align: center;
            margin-top: 30px;
        }
        
        .signature-box {
            border: 1px dashed #666;
            height: 60px;
            margin: 20px 0;
            background-color: #f8f9fa;
        }
        
        .footer {
            text-align: center;
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #dee2e6;
            font-size: 9px;
            color: #666;
        }
        
        .text-center { text-align: center; }
        .text-left { text-align: left; }
        .text-right { text-align: right; }
        
        .text-success { color: #28a745; }
        .text-danger { color: #dc3545; }
        .text-warning { color: #ffc107; }
        .text-primary { color: #007bff; }
        
        .fw-bold { font-weight: bold; }
        
        .no-nilai {
            text-align: center;
            padding: 40px 20px;
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 5px;
            color: #856404;
        }
        
        .page-break {
            page-break-before: always;
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
            
            <h2>Laporan Hasil Belajar Siswa</h2>
            <h3>Semester {{ $semester }}</h3>
        </div>

        <!-- Data Siswa -->
        <div class="data-siswa">
            <div class="col">
                <table class="data-table">
                    <tr>
                        <td class="label">Nama Siswa</td>
                        <td class="colon">:</td>
                        <td>{{ $siswa->siswa_nama }}</td>
                    </tr>
                    <tr>
                        <td class="label">Email</td>
                        <td class="colon">:</td>
                        <td>{{ $siswa->siswa_email }}</td>
                    </tr>
                    <tr>
                        <td class="label">Kelas</td>
                        <td class="colon">:</td>
                        <td>{{ $siswa->jenjang }} {{ $siswa->tingkat }} {{ $siswa->kelas_nama }}</td>
                    </tr>
                </table>
            </div>
            <div class="col">
                <table class="data-table">
                    <tr>
                        <td class="label">Semester</td>
                        <td class="colon">:</td>
                        <td>{{ $semester }}</td>
                    </tr>
                    <tr>
                        <td class="label">Tahun Ajaran</td>
                        <td class="colon">:</td>
                        <td>{{ $siswa->tahun_ajaran_nama }}</td>
                    </tr>
                    <tr>
                        <td class="label">Tanggal Cetak</td>
                        <td class="colon">:</td>
                        <td>{{ $tanggal_cetak }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Hasil Belajar -->
        <div class="section-title">Hasil Belajar</div>
        
        @if(count($nilai_per_mapel) > 0)
            <table class="nilai-table">
                <thead>
                    <tr>
                        <th rowspan="2">No</th>
                        <th rowspan="2">Mata Pelajaran</th>
                        <th rowspan="2">Kode</th>
                        <th colspan="5">Jenis Penilaian</th>
                        <th rowspan="2">Rata-rata</th>
                        <th rowspan="2">Grade</th>
                        <th rowspan="2">Keterangan</th>
                    </tr>
                    <tr>
                        <th>UTS</th>
                        <th>UAS</th>
                        <th>Tugas</th>
                        <th>Kuis</th>
                        <th>Praktik</th>
                    </tr>
                </thead>
                <tbody>
                    @php $no = 1; @endphp
                    @foreach($nilai_per_mapel as $mata_pelajaran => $data)
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
                            
                            $nilaiByJenis = $data['nilai_detail']->groupBy('jenis_nilai');
                        @endphp
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td class="mapel">{{ $mata_pelajaran }}</td>
                            <td>{{ $data['kode'] }}</td>
                            <td>
                                @if(isset($nilaiByJenis['UTS']))
                                    {{ number_format($nilaiByJenis['UTS']->avg('nilai'), 0) }}
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                @if(isset($nilaiByJenis['UAS']))
                                    {{ number_format($nilaiByJenis['UAS']->avg('nilai'), 0) }}
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                @if(isset($nilaiByJenis['Tugas']))
                                    {{ number_format($nilaiByJenis['Tugas']->avg('nilai'), 0) }}
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                @if(isset($nilaiByJenis['Kuis']))
                                    {{ number_format($nilaiByJenis['Kuis']->avg('nilai'), 0) }}
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                @if(isset($nilaiByJenis['Praktik']))
                                    {{ number_format($nilaiByJenis['Praktik']->avg('nilai'), 0) }}
                                @else
                                    -
                                @endif
                            </td>
                            <td class="rata-rata">{{ number_format($rataRata, 1) }}</td>
                            <td><span class="grade-badge {{ $gradeClass }}">{{ $grade }}</span></td>
                            <td class="{{ $data['tuntas'] ? 'tuntas' : 'belum-tuntas' }}">
                                {{ $data['tuntas'] ? 'TUNTAS' : 'BELUM TUNTAS' }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="7" class="text-center">RATA-RATA KESELURUHAN</td>
                        <td class="rata-rata">{{ number_format($statistik->rata_rata, 1) }}</td>
                        <td>
                            @php
                                $overallGrade = '';
                                $overallClass = '';
                                if ($statistik->rata_rata >= 90) {
                                    $overallGrade = 'A';
                                    $overallClass = 'grade-a';
                                } elseif ($statistik->rata_rata >= 80) {
                                    $overallGrade = 'B';
                                    $overallClass = 'grade-b';
                                } elseif ($statistik->rata_rata >= 70) {
                                    $overallGrade = 'C';
                                    $overallClass = 'grade-c';
                                } elseif ($statistik->rata_rata >= 60) {
                                    $overallGrade = 'D';
                                    $overallClass = 'grade-d';
                                } else {
                                    $overallGrade = 'E';
                                    $overallClass = 'grade-e';
                                }
                            @endphp
                            <span class="grade-badge {{ $overallClass }}">{{ $overallGrade }}</span>
                        </td>
                        <td class="{{ $statistik->rata_rata >= 75 ? 'tuntas' : 'belum-tuntas' }}">
                            {{ $statistik->rata_rata >= 75 ? 'TUNTAS' : 'BELUM TUNTAS' }}
                        </td>
                    </tr>
                </tfoot>
            </table>

            <!-- Ringkasan Prestasi -->
            <div class="section-title">Ringkasan Prestasi</div>
            <div class="ringkasan">
                <div class="col">
                    <div class="prestasi-box">
                        <h4 style="margin-bottom: 10px; font-size: 11px; color: #007bff;">Statistik Umum</h4>
                        <div class="prestasi-item">
                            <div class="left">Total Mata Pelajaran:</div>
                            <div class="right">{{ count($nilai_per_mapel) }}</div>
                        </div>
                        <div class="prestasi-item">
                            <div class="left">Total Nilai:</div>
                            <div class="right">{{ $statistik->total_nilai }}</div>
                        </div>
                        <div class="prestasi-item">
                            <div class="left">Nilai Tertinggi:</div>
                            <div class="right text-success">{{ $statistik->nilai_tertinggi }}</div>
                        </div>
                        <div class="prestasi-item">
                            <div class="left">Nilai Terendah:</div>
                            <div class="right text-danger">{{ $statistik->nilai_terendah }}</div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="prestasi-box">
                        <h4 style="margin-bottom: 10px; font-size: 11px; color: #007bff;">Ketuntasan</h4>
                        <div class="prestasi-item">
                            <div class="left">Mata Pelajaran Tuntas:</div>
                            <div class="right text-success">{{ $statistik->tuntas }}</div>
                        </div>
                        <div class="prestasi-item">
                            <div class="left">Mata Pelajaran Belum Tuntas:</div>
                            <div class="right text-danger">{{ $statistik->belum_tuntas }}</div>
                        </div>
                        <div class="prestasi-item">
                            <div class="left">Persentase Ketuntasan:</div>
                            <div class="right">{{ number_format(($statistik->tuntas / count($nilai_per_mapel)) * 100, 1) }}%</div>
                        </div>
                        <div class="prestasi-item">
                            <div class="left">Ranking di Kelas:</div>
                            <div class="right text-primary">{{ $ranking }} dari {{ $total_siswa_kelas }}</div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="prestasi-box">
                        <h4 style="margin-bottom: 10px; font-size: 11px; color: #007bff;">Distribusi Grade</h4>
                        <div class="grade-dist-item">
                            <div class="grade"><span class="grade-badge grade-a">A</span></div>
                            <div class="count">{{ $statistik->grade_a }} nilai</div>
                        </div>
                        <div class="grade-dist-item">
                            <div class="grade"><span class="grade-badge grade-b">B</span></div>
                            <div class="count">{{ $statistik->grade_b }} nilai</div>
                        </div>
                        <div class="grade-dist-item">
                            <div class="grade"><span class="grade-badge grade-c">C</span></div>
                            <div class="count">{{ $statistik->grade_c }} nilai</div>
                        </div>
                        <div class="grade-dist-item">
                            <div class="grade"><span class="grade-badge grade-d">D</span></div>
                            <div class="count">{{ $statistik->grade_d }} nilai</div>
                        </div>
                        <div class="grade-dist-item">
                            <div class="grade"><span class="grade-badge grade-e">E</span></div>
                            <div class="count">{{ $statistik->grade_e }} nilai</div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="no-nilai">
                <h3 style="margin-bottom: 10px;">Belum Ada Nilai</h3>
                <p>Siswa ini belum memiliki nilai untuk semester {{ $semester }}.</p>
            </div>
        @endif

        <!-- Catatan Wali Kelas -->
        <div class="catatan-section">
            <div style="display: table; width: 100%;">
                <div style="display: table-cell; width: 65%; vertical-align: top; padding-right: 20px;">
                    <div class="section-title">Catatan Wali Kelas</div>
                    <div class="catatan-box">
                        @if($statistik->total_nilai > 0)
                            @if($statistik->rata_rata >= 85)
                                Prestasi siswa sangat baik. Pertahankan dan tingkatkan terus motivasi belajar.
                            @elseif($statistik->rata_rata >= 75)
                                Prestasi siswa cukup baik. Diharapkan dapat meningkatkan hasil belajar di semester berikutnya.
                            @elseif($statistik->rata_rata >= 60)
                                Prestasi siswa perlu ditingkatkan. Sebaiknya lebih fokus dan rajin dalam belajar.
                            @else
                                Prestasi siswa masih kurang. Perlu bimbingan khusus dan peningkatan motivasi belajar.
                            @endif
                            <br><br>
                            Mata pelajaran yang perlu mendapat perhatian khusus:
                            @php
                                $mapelBelumTuntas = array_filter($nilai_per_mapel, function($data) {
                                    return !$data['tuntas'];
                                });
                            @endphp
                            @if(count($mapelBelumTuntas) > 0)
                                {{ implode(', ', array_keys($mapelBelumTuntas)) }}.
                            @else
                                Semua mata pelajaran sudah tuntas.
                            @endif
                        @else
                            Siswa belum memiliki nilai untuk semester ini. Diharapkan segera melengkapi tugas dan ujian yang belum diselesaikan.
                        @endif
                    </div>
                </div>
                <div style="display: table-cell; width: 35%; vertical-align: top;">
                    <div class="signature-area">
                        <p style="margin-bottom: 5px;">Jakarta, {{ $tanggal_cetak }}</p>
                        <p style="margin-bottom: 20px;">Wali Kelas</p>
                        <div class="signature-box"></div>
                        <p style="margin-bottom: 2px; font-weight: bold;">_________________</p>
                        <p style="font-size: 9px;">NIP. 19800101 200501 1 001</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            Dokumen ini digenerate secara otomatis oleh Sistem Informasi Akademik<br>
            Tanggal cetak: {{ $tanggal_cetak }}
        </div>
    </div>
</body>
</html>
