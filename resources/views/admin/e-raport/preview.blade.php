@extends('admin.layouts.app')

@section('title', 'Preview E-Raport - ' . $siswa->siswa_nama)

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Preview E-Raport</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="/admin/">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="/admin/e-raport/">E-Raport</a></li>
        <li class="breadcrumb-item active">Preview - {{ $siswa->siswa_nama }}</li>
    </ol>

    <!-- Action Buttons -->
    <div class="row mb-4">
        <div class="col-md-8">
            <a href="/admin/e-raport/?kelas_id={{ $siswa->kelas_id }}&semester={{ $semester }}" class="btn btn-outline-primary">
                <i class="fas fa-arrow-left"></i> Kembali ke Daftar
            </a>
        </div>
        <div class="col-md-4 text-end">
            <a href="/admin/e-raport/download/{{ $siswa->siswa_id }}?kelas_id={{ $siswa->kelas_id }}&semester={{ $semester }}" 
               class="btn btn-success">
                <i class="fas fa-download"></i> Download PDF
            </a>
            <button onclick="window.print()" class="btn btn-info">
                <i class="fas fa-print"></i> Print
            </button>
        </div>
    </div>

    <!-- Raport Content -->
    <div class="card shadow-lg border-0" id="raportContent">
        <div class="card-body p-5">
            <!-- Header Raport -->
            <div class="raport-header text-center border-bottom pb-4 mb-4">
                <div class="row align-items-center">
                    <div class="col-2">
                        <img src="/img/logo-sekolah.png" alt="Logo" class="img-fluid" style="max-height: 80px;" 
                             onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iODAiIGhlaWdodD0iODAiIHZpZXdCb3g9IjAgMCA4MCA4MCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHJlY3Qgd2lkdGg9IjgwIiBoZWlnaHQ9IjgwIiBmaWxsPSIjMDA3YmZmIi8+Cjx0ZXh0IHg9IjQwIiB5PSI0NSIgZm9udC1mYW1pbHk9IkFyaWFsLCBzYW5zLXNlcmlmIiBmb250LXNpemU9IjI0IiBmaWxsPSJ3aGl0ZSIgdGV4dC1hbmNob3I9Im1pZGRsZSI+U01BPC90ZXh0Pgo8L3N2Zz4K'">
                    </div>
                    <div class="col-8">
                        <h2 class="mb-1 text-primary">SMA NEGERI 1 JAKARTA</h2>
                        <p class="mb-1">Jl. Pendidikan No. 123, Jakarta Pusat</p>
                        <p class="mb-0">Telp: (021) 1234567 | Email: info@sman1jakarta.sch.id</p>
                    </div>
                    <div class="col-2">
                        <div class="stamp-area border rounded p-2 text-center bg-light">
                            <small class="text-muted">STEMPEL<br>SEKOLAH</small>
                        </div>
                    </div>
                </div>
                <hr class="my-3">
                <h3 class="text-uppercase fw-bold text-dark">LAPORAN HASIL BELAJAR SISWA</h3>
                <h4 class="text-uppercase text-primary">SEMESTER {{ $semester }}</h4>
            </div>

            <!-- Data Siswa -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <td width="30%" class="fw-bold">Nama Siswa</td>
                            <td width="5%">:</td>
                            <td>{{ $siswa->siswa_nama }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Email</td>
                            <td>:</td>
                            <td>{{ $siswa->siswa_email }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Kelas</td>
                            <td>:</td>
                            <td>{{ $siswa->jenjang }} {{ $siswa->tingkat }} {{ $siswa->kelas_nama }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <td width="30%" class="fw-bold">Semester</td>
                            <td width="5%">:</td>
                            <td>{{ $semester }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Tahun Ajaran</td>
                            <td>:</td>
                            <td>{{ $siswa->tahun_ajaran_nama }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Tanggal Cetak</td>
                            <td>:</td>
                            <td>{{ $tanggal_cetak }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- Nilai Per Mata Pelajaran -->
            <div class="mb-4">
                <h5 class="mb-3 text-primary fw-bold">HASIL BELAJAR</h5>
                
                @if(count($nilai_per_mapel) > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="table-primary">
                                <tr class="text-center">
                                    <th rowspan="2" class="align-middle">No</th>
                                    <th rowspan="2" class="align-middle">Mata Pelajaran</th>
                                    <th rowspan="2" class="align-middle">Kode</th>
                                    <th colspan="5">Jenis Penilaian</th>
                                    <th rowspan="2" class="align-middle">Rata-rata</th>
                                    <th rowspan="2" class="align-middle">Grade</th>
                                    <th rowspan="2" class="align-middle">Keterangan</th>
                                </tr>
                                <tr class="text-center">
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
                                        $gradeColor = '';
                                        if ($rataRata >= 90) {
                                            $grade = 'A';
                                            $gradeColor = 'success';
                                        } elseif ($rataRata >= 80) {
                                            $grade = 'B';
                                            $gradeColor = 'info';
                                        } elseif ($rataRata >= 70) {
                                            $grade = 'C';
                                            $gradeColor = 'warning';
                                        } elseif ($rataRata >= 60) {
                                            $grade = 'D';
                                            $gradeColor = 'danger';
                                        } else {
                                            $grade = 'E';
                                            $gradeColor = 'dark';
                                        }
                                        
                                        // Group nilai berdasarkan jenis
                                        $nilaiByJenis = $data['nilai_detail']->groupBy('jenis_nilai');
                                    @endphp
                                    <tr>
                                        <td class="text-center">{{ $no++ }}</td>
                                        <td class="fw-bold">{{ $mata_pelajaran }}</td>
                                        <td class="text-center">{{ $data['kode'] }}</td>
                                        <td class="text-center">
                                            @if(isset($nilaiByJenis['UTS']))
                                                {{ number_format($nilaiByJenis['UTS']->avg('nilai'), 0) }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if(isset($nilaiByJenis['UAS']))
                                                {{ number_format($nilaiByJenis['UAS']->avg('nilai'), 0) }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if(isset($nilaiByJenis['Tugas']))
                                                {{ number_format($nilaiByJenis['Tugas']->avg('nilai'), 0) }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if(isset($nilaiByJenis['Kuis']))
                                                {{ number_format($nilaiByJenis['Kuis']->avg('nilai'), 0) }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if(isset($nilaiByJenis['Praktik']))
                                                {{ number_format($nilaiByJenis['Praktik']->avg('nilai'), 0) }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="text-center fw-bold
                                            @if($rataRata >= 85) text-success
                                            @elseif($rataRata >= 75) text-warning
                                            @elseif($rataRata >= 60) text-info
                                            @else text-danger
                                            @endif">
                                            {{ number_format($rataRata, 1) }}
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-{{ $gradeColor }}">{{ $grade }}</span>
                                        </td>
                                        <td class="text-center">
                                            @if($data['tuntas'])
                                                <span class="text-success fw-bold">TUNTAS</span>
                                            @else
                                                <span class="text-danger fw-bold">BELUM TUNTAS</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="table-light">
                                <tr>
                                    <td colspan="7" class="text-center fw-bold">RATA-RATA KESELURUHAN</td>
                                    <td class="text-center fw-bold text-primary">
                                        {{ number_format($statistik->rata_rata, 1) }}
                                    </td>
                                    <td class="text-center">
                                        @php
                                            $overallGrade = '';
                                            $overallColor = '';
                                            if ($statistik->rata_rata >= 90) {
                                                $overallGrade = 'A';
                                                $overallColor = 'success';
                                            } elseif ($statistik->rata_rata >= 80) {
                                                $overallGrade = 'B';
                                                $overallColor = 'info';
                                            } elseif ($statistik->rata_rata >= 70) {
                                                $overallGrade = 'C';
                                                $overallColor = 'warning';
                                            } elseif ($statistik->rata_rata >= 60) {
                                                $overallGrade = 'D';
                                                $overallColor = 'danger';
                                            } else {
                                                $overallGrade = 'E';
                                                $overallColor = 'dark';
                                            }
                                        @endphp
                                        <span class="badge bg-{{ $overallColor }}">{{ $overallGrade }}</span>
                                    </td>
                                    <td class="text-center">
                                        @if($statistik->rata_rata >= 75)
                                            <span class="text-success fw-bold">TUNTAS</span>
                                        @else
                                            <span class="text-danger fw-bold">BELUM TUNTAS</span>
                                        @endif
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                @else
                    <div class="alert alert-warning text-center">
                        <h5><i class="fas fa-exclamation-triangle"></i> Belum Ada Nilai</h5>
                        <p class="mb-0">Siswa ini belum memiliki nilai untuk semester {{ $semester }}.</p>
                    </div>
                @endif
            </div>

            <!-- Ringkasan Prestasi -->
            @if($statistik->total_nilai > 0)
                <div class="row mb-4">
                    <div class="col-md-8">
                        <h5 class="mb-3 text-primary fw-bold">RINGKASAN PRESTASI</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="prestasi-item">
                                    <div class="row mb-2">
                                        <div class="col-8">Total Mata Pelajaran:</div>
                                        <div class="col-4 fw-bold">{{ count($nilai_per_mapel) }}</div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-8">Total Nilai:</div>
                                        <div class="col-4 fw-bold">{{ $statistik->total_nilai }}</div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-8">Nilai Tertinggi:</div>
                                        <div class="col-4 fw-bold text-success">{{ $statistik->nilai_tertinggi }}</div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-8">Nilai Terendah:</div>
                                        <div class="col-4 fw-bold text-danger">{{ $statistik->nilai_terendah }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="prestasi-item">
                                    <div class="row mb-2">
                                        <div class="col-8">Mata Pelajaran Tuntas:</div>
                                        <div class="col-4 fw-bold text-success">{{ $statistik->tuntas }}</div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-8">Mata Pelajaran Belum Tuntas:</div>
                                        <div class="col-4 fw-bold text-danger">{{ $statistik->belum_tuntas }}</div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-8">Persentase Ketuntasan:</div>
                                        <div class="col-4 fw-bold">
                                            {{ number_format(($statistik->tuntas / count($nilai_per_mapel)) * 100, 1) }}%
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-8">Ranking di Kelas:</div>
                                        <div class="col-4 fw-bold text-primary">{{ $ranking }} dari {{ $total_siswa_kelas }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <h6 class="mb-3">Distribusi Grade</h6>
                        <div class="grade-distribution">
                            <div class="row mb-1">
                                <div class="col-4"><span class="badge bg-success">A</span></div>
                                <div class="col-8">{{ $statistik->grade_a }} nilai</div>
                            </div>
                            <div class="row mb-1">
                                <div class="col-4"><span class="badge bg-info">B</span></div>
                                <div class="col-8">{{ $statistik->grade_b }} nilai</div>
                            </div>
                            <div class="row mb-1">
                                <div class="col-4"><span class="badge bg-warning">C</span></div>
                                <div class="col-8">{{ $statistik->grade_c }} nilai</div>
                            </div>
                            <div class="row mb-1">
                                <div class="col-4"><span class="badge bg-danger">D</span></div>
                                <div class="col-8">{{ $statistik->grade_d }} nilai</div>
                            </div>
                            <div class="row mb-1">
                                <div class="col-4"><span class="badge bg-dark">E</span></div>
                                <div class="col-8">{{ $statistik->grade_e }} nilai</div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Catatan dan Tanda Tangan -->
            <div class="mt-5">
                <div class="row">
                    <div class="col-md-8">
                        <h6 class="fw-bold">CATATAN WALI KELAS:</h6>
                        <div class="border rounded p-3 bg-light" style="min-height: 120px;">
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
                    <div class="col-md-4">
                        <div class="signature-area text-center">
                            <p class="mb-1">Jakarta, {{ $tanggal_cetak }}</p>
                            <p class="mb-4">Wali Kelas</p>
                            <div class="signature-box border rounded p-3 bg-light" style="height: 80px;">
                                <!-- Ruang untuk tanda tangan -->
                            </div>
                            <p class="mt-2 mb-0 fw-bold">_________________</p>
                            <p class="mb-0"><small>NIP. 19800101 200501 1 001</small></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="text-center mt-4 pt-3 border-top">
                <small class="text-muted">
                    Dokumen ini digenerate secara otomatis oleh Sistem Informasi Akademik | 
                    Tanggal cetak: {{ $tanggal_cetak }}
                </small>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
@media print {
    .container-fluid {
        max-width: none !important;
        padding: 0 !important;
    }
    
    .breadcrumb, .btn, .card-header {
        display: none !important;
    }
    
    .card {
        border: none !important;
        box-shadow: none !important;
    }
    
    body {
        font-size: 12px !important;
    }
    
    .table {
        font-size: 11px !important;
    }
    
    .badge {
        font-size: 10px !important;
    }
}

.raport-header {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-radius: 0.5rem;
    padding: 2rem;
    margin-bottom: 2rem;
}

.prestasi-item {
    background: #f8f9fa;
    padding: 1rem;
    border-radius: 0.375rem;
    border-left: 4px solid #007bff;
}

.signature-area {
    background: #f8f9fa;
    padding: 1.5rem;
    border-radius: 0.375rem;
}

.table th {
    background-color: #007bff !important;
    color: white !important;
    font-weight: 600;
    text-align: center;
}

.table td {
    vertical-align: middle;
}

.stamp-area {
    min-height: 80px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.grade-distribution {
    background: #f8f9fa;
    padding: 1rem;
    border-radius: 0.375rem;
}

.card {
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
    border: none;
}

.badge {
    font-size: 0.75em;
}

.signature-box {
    border-style: dashed !important;
}
</style>
@endpush

@push('scripts')
<script>
// Auto print functionality
function autoPrint() {
    if (window.location.search.includes('auto_print=1')) {
        setTimeout(() => {
            window.print();
        }, 1000);
    }
}

document.addEventListener('DOMContentLoaded', autoPrint);
</script>
@endpush
