<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Halaman;
use App\Models\User;
use Illuminate\Support\Str;

class HalamanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil user dengan role Admin sebagai penulis
        $penulis = User::role('Admin')->first();
        
        if (!$penulis) {
            $this->command->info('Tidak ada user Admin yang ditemukan. Silakan buat user Admin terlebih dahulu.');
            return;
        }

        $halaman = [
            [
                'penulis_id' => $penulis->id,
                'judul' => 'Tentang Kami',
                'slug' => 'tentang-kami',
                'isi' => '<h2>Sejarah Sekolah</h2>
<p>SMP Negeri 20 Jakarta didirikan pada tahun 1977 dan telah menjadi salah satu lembaga pendidikan terkemuka di Jakarta. Selama lebih dari empat dekade, sekolah kami telah mendidik ribuan siswa yang kini telah menjadi individu sukses di berbagai bidang.</p>

<h2>Visi dan Misi</h2>
<h3>Visi</h3>
<p>Menjadi lembaga pendidikan yang unggul dalam pembentukan karakter, prestasi akademik, dan keterampilan hidup untuk menghasilkan generasi yang kompetitif di era global.</p>

<h3>Misi</h3>
<ul>
<li>Menyelenggarakan pendidikan yang berkualitas dengan mengedepankan nilai-nilai karakter dan budi pekerti</li>
<li>Mengembangkan potensi siswa secara optimal melalui kegiatan akademik dan non-akademik</li>
<li>Membekali siswa dengan keterampilan teknologi dan bahasa untuk menghadapi tantangan global</li>
<li>Menciptakan lingkungan belajar yang kondusif, aman, dan nyaman</li>
<li>Menjalin kerjasama dengan berbagai pihak untuk meningkatkan kualitas pendidikan</li>
</ul>

<h2>Fasilitas</h2>
<p>Sekolah kami dilengkapi dengan berbagai fasilitas modern untuk mendukung proses pembelajaran:</p>
<ul>
<li>Ruang kelas ber-AC dengan smart board</li>
<li>Laboratorium IPA, Komputer, dan Bahasa</li>
<li>Perpustakaan digital</li>
<li>Lapangan olahraga multifungsi</li>
<li>Aula serbaguna</li>
<li>Kantin sehat</li>
<li>Ruang UKS</li>
<li>Masjid</li>
</ul>',
                'status' => 'publish',
                'tanggal_publish' => now(),
                'views' => 325,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'penulis_id' => $penulis->id,
                'judul' => 'Tata Tertib Sekolah',
                'slug' => 'tata-tertib-sekolah',
                'isi' => '<h2>Tata Tertib Siswa</h2>
<p>Berikut adalah tata tertib yang harus dipatuhi oleh seluruh siswa SMP Negeri 20 Jakarta:</p>

<h3>Kehadiran</h3>
<ol>
<li>Siswa wajib hadir di sekolah paling lambat pukul 06.45 WIB</li>
<li>Siswa yang terlambat harus melapor ke guru piket</li>
<li>Siswa yang tidak hadir wajib menyerahkan surat keterangan</li>
<li>Siswa dilarang meninggalkan sekolah tanpa izin selama jam pelajaran</li>
</ol>

<h3>Seragam</h3>
<ol>
<li>Senin-Selasa: Seragam putih-biru dengan atribut lengkap</li>
<li>Rabu-Kamis: Seragam batik sekolah</li>
<li>Jumat: Seragam pramuka</li>
<li>Sepatu hitam dan kaos kaki putih</li>
</ol>

<h3>Kerapian</h3>
<ol>
<li>Siswa laki-laki: rambut pendek rapi, tidak diwarnai</li>
<li>Siswa perempuan: rambut diikat rapi jika panjang</li>
<li>Dilarang menggunakan perhiasan berlebihan</li>
<li>Kuku harus pendek dan bersih</li>
</ol>

<h3>Perilaku</h3>
<ol>
<li>Siswa wajib menghormati guru dan staf sekolah</li>
<li>Dilarang membawa senjata tajam, rokok, atau zat terlarang</li>
<li>Dilarang berkelahi atau melakukan tindakan bullying</li>
<li>Menjaga kebersihan dan ketertiban lingkungan sekolah</li>
</ol>

<h3>Sanksi</h3>
<p>Pelanggaran terhadap tata tertib akan dikenakan sanksi sesuai dengan tingkat pelanggarannya, mulai dari teguran lisan, peringatan tertulis, pemanggilan orang tua, hingga skorsing.</p>',
                'status' => 'publish',
                'tanggal_publish' => now()->subDays(5),
                'views' => 210,
                'created_at' => now()->subDays(5),
                'updated_at' => now()->subDays(5),
            ],
            [
                'penulis_id' => $penulis->id,
                'judul' => 'Program Unggulan',
                'slug' => 'program-unggulan',
                'isi' => '<h2>Program Unggulan SMP Negeri 20 Jakarta</h2>
<p>SMP Negeri 20 Jakarta memiliki berbagai program unggulan yang dirancang untuk mengembangkan potensi siswa secara optimal:</p>

<h3>1. Program Kelas Unggulan Sains dan Matematika</h3>
<p>Program ini dirancang khusus untuk siswa yang memiliki minat dan bakat di bidang sains dan matematika. Kurikulum diperkaya dengan materi-materi pengayaan dan kegiatan praktikum yang lebih intensif.</p>

<h3>2. English Immersion Program</h3>
<p>Program ini menekankan pada penguasaan bahasa Inggris melalui pendekatan komunikatif. Siswa dilatih untuk menggunakan bahasa Inggris secara aktif dalam berbagai konteks komunikasi.</p>

<h3>3. Program Pengembangan Karakter</h3>
<p>Program ini bertujuan untuk membentuk karakter siswa yang tangguh, jujur, disiplin, dan bertanggung jawab melalui berbagai kegiatan seperti outbound, leadership training, dan community service.</p>

<h3>4. Program Literasi Digital</h3>
<p>Program ini membekali siswa dengan keterampilan teknologi informasi dan komunikasi yang dibutuhkan di era digital. Siswa belajar coding, desain grafis, dan pengembangan aplikasi sederhana.</p>

<h3>5. Program Kewirausahaan</h3>
<p>Program ini bertujuan untuk menumbuhkan jiwa kewirausahaan pada siswa. Siswa belajar membuat business plan, marketing strategy, dan mengelola keuangan sederhana.</p>

<h3>6. Program Seni dan Budaya</h3>
<p>Program ini mengembangkan apresiasi siswa terhadap seni dan budaya Indonesia. Siswa belajar berbagai jenis tarian tradisional, musik, dan seni rupa.</p>

<h3>7. Program Olahraga Prestasi</h3>
<p>Program ini dirancang untuk siswa yang memiliki bakat di bidang olahraga. Sekolah menyediakan pelatih profesional dan fasilitas yang memadai untuk berbagai cabang olahraga.</p>',
                'status' => 'publish',
                'tanggal_publish' => now()->subDays(10),
                'views' => 178,
                'created_at' => now()->subDays(10),
                'updated_at' => now()->subDays(10),
            ],
            [
                'penulis_id' => $penulis->id,
                'judul' => 'Ekstrakurikuler',
                'slug' => 'ekstrakurikuler',
                'isi' => '<h2>Kegiatan Ekstrakurikuler</h2>
<p>SMP Negeri 20 Jakarta menyediakan berbagai kegiatan ekstrakurikuler untuk mengembangkan minat dan bakat siswa di luar kegiatan akademik:</p>

<h3>Bidang Olahraga</h3>
<ul>
<li><strong>Futsal</strong> - Latihan setiap Senin dan Rabu pukul 15.00-17.00</li>
<li><strong>Basket</strong> - Latihan setiap Selasa dan Kamis pukul 15.00-17.00</li>
<li><strong>Voli</strong> - Latihan setiap Senin dan Jumat pukul 15.00-17.00</li>
<li><strong>Badminton</strong> - Latihan setiap Rabu pukul 15.00-17.00</li>
<li><strong>Taekwondo</strong> - Latihan setiap Sabtu pukul 09.00-11.00</li>
</ul>

<h3>Bidang Seni</h3>
<ul>
<li><strong>Paduan Suara</strong> - Latihan setiap Selasa pukul 15.00-17.00</li>
<li><strong>Seni Tari</strong> - Latihan setiap Kamis pukul 15.00-17.00</li>
<li><strong>Band</strong> - Latihan setiap Jumat pukul 15.00-17.00</li>
<li><strong>Teater</strong> - Latihan setiap Rabu pukul 15.00-17.00</li>
<li><strong>Seni Rupa</strong> - Latihan setiap Sabtu pukul 09.00-11.00</li>
</ul>

<h3>Bidang Akademik</h3>
<ul>
<li><strong>Karya Ilmiah Remaja</strong> - Pertemuan setiap Senin pukul 15.00-17.00</li>
<li><strong>English Club</strong> - Pertemuan setiap Selasa pukul 15.00-17.00</li>
<li><strong>Matematika Club</strong> - Pertemuan setiap Rabu pukul 15.00-17.00</li>
<li><strong>Robotika</strong> - Pertemuan setiap Kamis pukul 15.00-17.00</li>
<li><strong>Jurnalistik</strong> - Pertemuan setiap Jumat pukul 15.00-17.00</li>
</ul>

<h3>Bidang Sosial dan Kepemimpinan</h3>
<ul>
<li><strong>Pramuka</strong> - Wajib untuk kelas 7, setiap Jumat pukul 15.00-17.00</li>
<li><strong>PMR</strong> - Pertemuan setiap Sabtu pukul 09.00-11.00</li>
<li><strong>Pecinta Alam</strong> - Pertemuan setiap Sabtu pukul 09.00-11.00</li>
</ul>

<p>Pendaftaran ekstrakurikuler dibuka pada awal tahun ajaran. Setiap siswa diwajibkan mengikuti minimal satu kegiatan ekstrakurikuler.</p>',
                'status' => 'publish',
                'tanggal_publish' => now()->subDays(15),
                'views' => 245,
                'created_at' => now()->subDays(15),
                'updated_at' => now()->subDays(15),
            ],
            [
                'penulis_id' => $penulis->id,
                'judul' => 'Fasilitas Sekolah',
                'slug' => 'fasilitas-sekolah',
                'isi' => '<h2>Fasilitas SMP Negeri 20 Jakarta</h2>
<p>SMP Negeri 20 Jakarta memiliki berbagai fasilitas modern untuk mendukung kegiatan belajar mengajar:</p>

<h3>Fasilitas Akademik</h3>
<ul>
<li><strong>Ruang Kelas</strong> - 24 ruang kelas dilengkapi dengan AC, LCD projector, dan smart board</li>
<li><strong>Laboratorium IPA</strong> - Laboratorium Fisika, Kimia, dan Biologi dengan peralatan lengkap</li>
<li><strong>Laboratorium Komputer</strong> - 2 ruang dengan 40 unit komputer terhubung internet</li>
<li><strong>Laboratorium Bahasa</strong> - Dilengkapi dengan 40 booth dan perangkat audio visual</li>
<li><strong>Perpustakaan</strong> - Koleksi lebih dari 5000 buku dan akses ke perpustakaan digital</li>
</ul>

<h3>Fasilitas Olahraga</h3>
<ul>
<li><strong>Lapangan Basket</strong> - Lapangan standar dengan tribun penonton</li>
<li><strong>Lapangan Futsal</strong> - Dengan rumput sintetis dan penerangan</li>
<li><strong>Lapangan Voli</strong> - 2 lapangan standar</li>
<li><strong>Lapangan Badminton</strong> - 3 lapangan indoor</li>
<li><strong>Ruang Fitness</strong> - Dilengkapi dengan peralatan gym modern</li>
</ul>

<h3>Fasilitas Seni dan Budaya</h3>
<ul>
<li><strong>Aula Serbaguna</strong> - Kapasitas 500 orang dengan sistem audio visual lengkap</li>
<li><strong>Ruang Musik</strong> - Dilengkapi dengan berbagai alat musik</li>
<li><strong>Ruang Tari</strong> - Dengan cermin dan lantai kayu</li>
<li><strong>Ruang Seni Rupa</strong> - Dilengkapi dengan peralatan lukis dan kerajinan</li>
</ul>

<h3>Fasilitas Penunjang</h3>
<ul>
<li><strong>Kantin Sehat</strong> - Menyediakan makanan bergizi dengan harga terjangkau</li>
<li><strong>UKS</strong> - Dilengkapi dengan 4 tempat tidur dan peralatan medis dasar</li>
<li><strong>Masjid</strong> - Kapasitas 200 jamaah</li>
<li><strong>Ruang OSIS</strong> - Untuk kegiatan organisasi siswa</li>
<li><strong>Ruang BK</strong> - Untuk konseling siswa</li>
<li><strong>Area Parkir</strong> - Luas dan aman</li>
<li><strong>Taman Belajar</strong> - Area outdoor dengan wifi untuk belajar santai</li>
</ul>

<p>Semua fasilitas dirawat dengan baik dan diperbarui secara berkala untuk memastikan kenyamanan dan keamanan seluruh warga sekolah.</p>',
                'status' => 'draft',
                'tanggal_publish' => null,
                'views' => 0,
                'created_at' => now()->subDays(2),
                'updated_at' => now()->subDays(2),
            ],
        ];

        foreach ($halaman as $item) {
            Halaman::create($item);
        }
    }
}