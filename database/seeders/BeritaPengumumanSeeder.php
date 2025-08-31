<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Artikel;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Str;

class BeritaPengumumanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil user pertama sebagai penulis (biasanya admin)
        $penulis = User::role('Admin')->first();
        
        if (!$penulis) {
            $this->command->info('Tidak ada user admin yang ditemukan. Menggunakan user pertama sebagai penulis.');
            $penulis = User::first();
            
            if (!$penulis) {
                $this->command->error('Tidak ada user yang ditemukan. Silakan buat user terlebih dahulu.');
                return;
            }
        }

        $tanggalSekarang = Carbon::now();
        $tanggalKemarin = Carbon::now()->subDay();
        $tanggalDuaHariLalu = Carbon::now()->subDays(2);
        $tanggalTigaHariLalu = Carbon::now()->subDays(3);
        $tanggalEmpatHariLalu = Carbon::now()->subDays(4);
        $tanggalLimaHariLalu = Carbon::now()->subDays(5);
        $tanggalSemingguLalu = Carbon::now()->subDays(7);
        
        $beritaPengumuman = [
            // Berita
            [
                'penulis_id' => $penulis->id,
                'jenis' => 'berita',
                'judul' => 'Prestasi Gemilang Siswa SMP 20 dalam Olimpiade Matematika',
                'ringkasan' => 'Tim Matematika SMP 20 berhasil meraih juara umum dalam Olimpiade Matematika tingkat kota yang diselenggarakan bulan ini.',
                'isi' => '<p>Dengan bangga kami sampaikan bahwa tim Matematika SMP 20 telah berhasil meraih juara umum dalam Olimpiade Matematika tingkat kota yang diselenggarakan pada tanggal 15 Agustus 2024. Tim yang terdiri dari 5 siswa terbaik kelas 8 dan 9 ini berhasil mengalahkan 25 sekolah lainnya.</p>

<p>Prestasi ini merupakan hasil dari kerja keras dan dedikasi para siswa serta bimbingan intensif dari guru matematika sekolah kita. Persiapan yang telah dilakukan selama 3 bulan terakhir terbukti membuahkan hasil yang membanggakan.</p>

<p>Berikut adalah daftar siswa yang berpartisipasi dan prestasi yang diraih:</p>
<ul>
<li>Anita Wijaya (Kelas 9A) - Medali Emas kategori perorangan</li>
<li>Budi Santoso (Kelas 9B) - Medali Perak kategori perorangan</li>
<li>Cindy Permata (Kelas 8A) - Medali Perunggu kategori perorangan</li>
<li>Deni Hermawan (Kelas 8C) - Finalis 10 besar</li>
<li>Eka Putri (Kelas 9A) - Finalis 10 besar</li>
</ul>

<p>Selain prestasi individual, tim SMP 20 juga berhasil meraih juara 1 untuk kategori beregu. Prestasi ini semakin memantapkan posisi SMP 20 sebagai salah satu sekolah dengan program matematika terbaik di kota ini.</p>

<p>Kepala Sekolah, Bapak Rizal Rusdi, M.Pd, menyampaikan apresiasinya kepada seluruh tim dan berharap prestasi ini dapat menjadi motivasi bagi siswa lainnya untuk terus berprestasi di berbagai bidang.</p>

<p>Selamat kepada seluruh tim Matematika SMP 20! Mari terus ukir prestasi untuk mengharumkan nama sekolah kita!</p>',
                'status' => 'publish',
                'tanggal_publish' => $tanggalSekarang,
                'views' => 245,
                'created_at' => $tanggalSekarang,
                'updated_at' => $tanggalSekarang,
            ],
            [
                'penulis_id' => $penulis->id,
                'jenis' => 'berita',
                'judul' => 'Kunjungan Edukatif ke Museum Nasional Indonesia',
                'ringkasan' => 'Siswa kelas 7 melakukan kunjungan edukatif ke Museum Nasional Indonesia sebagai bagian dari pembelajaran sejarah dan budaya.',
                'isi' => '<p>Pada hari Rabu, 10 Agustus 2024, seluruh siswa kelas 7 SMP 20 melakukan kunjungan edukatif ke Museum Nasional Indonesia. Kegiatan ini merupakan bagian dari program pembelajaran sejarah dan budaya yang bertujuan untuk memperkaya wawasan siswa tentang kekayaan sejarah dan budaya Indonesia.</p>

<p>Kunjungan dimulai pukul 08.00 WIB dan berlangsung hingga pukul 14.00 WIB. Siswa dibagi menjadi beberapa kelompok kecil yang didampingi oleh guru pendamping dan pemandu museum. Selama kunjungan, siswa diajak untuk mengeksplorasi berbagai koleksi artefak bersejarah, mulai dari masa prasejarah hingga masa kolonial.</p>

<p>Beberapa highlight dari kunjungan ini antara lain:</p>
<ul>
<li>Pengenalan tentang kehidupan manusia prasejarah di Indonesia</li>
<li>Eksplorasi koleksi artefak kerajaan-kerajaan besar di Nusantara</li>
<li>Penjelasan tentang pengaruh budaya asing terhadap perkembangan budaya Indonesia</li>
<li>Sesi interaktif dengan pemandu museum tentang pentingnya melestarikan warisan budaya</li>
</ul>

<p>"Kunjungan ini sangat bermanfaat bagi siswa untuk memahami sejarah dan budaya Indonesia secara lebih konkret. Melihat langsung artefak-artefak bersejarah memberikan pengalaman belajar yang tidak bisa didapatkan hanya dari buku teks," ujar Ibu Naily Fitriyah, guru sejarah yang menjadi koordinator kegiatan.</p>

<p>Sebagai tindak lanjut dari kunjungan ini, siswa akan diminta untuk membuat laporan kunjungan dan presentasi kelompok tentang topik-topik spesifik yang mereka pelajari selama di museum. Kegiatan ini diharapkan dapat meningkatkan pemahaman dan apresiasi siswa terhadap kekayaan sejarah dan budaya Indonesia.</p>',
                'status' => 'publish',
                'tanggal_publish' => $tanggalDuaHariLalu,
                'views' => 187,
                'created_at' => $tanggalDuaHariLalu,
                'updated_at' => $tanggalDuaHariLalu,
            ],
            [
                'penulis_id' => $penulis->id,
                'jenis' => 'berita',
                'judul' => 'Workshop Literasi Digital untuk Guru SMP 20',
                'ringkasan' => 'Para guru SMP 20 mengikuti workshop literasi digital untuk meningkatkan kompetensi dalam penggunaan teknologi dalam pembelajaran.',
                'isi' => '<p>Dalam rangka meningkatkan kompetensi digital para pendidik, SMP 20 menyelenggarakan Workshop Literasi Digital untuk seluruh guru pada tanggal 5-6 Agustus 2024. Workshop yang berlangsung selama dua hari ini difasilitasi oleh tim dari Pusat Teknologi Informasi dan Komunikasi Pendidikan (Pustekkom) Kementerian Pendidikan dan Kebudayaan.</p>

<p>Workshop ini mencakup berbagai topik penting terkait literasi digital dalam konteks pendidikan, antara lain:</p>
<ul>
<li>Pengenalan dan penggunaan platform pembelajaran daring</li>
<li>Pembuatan konten pembelajaran digital yang interaktif</li>
<li>Strategi asesmen berbasis teknologi</li>
<li>Keamanan data dan etika digital</li>
<li>Pemanfaatan media sosial untuk pembelajaran</li>
</ul>

<p>"Di era digital seperti sekarang, guru tidak hanya dituntut untuk menguasai materi pelajaran, tetapi juga harus mampu mengintegrasikan teknologi dalam proses pembelajaran. Workshop ini sangat membantu kami untuk mengembangkan kompetensi digital yang sangat dibutuhkan saat ini," ungkap Bapak Mohammad Salim, S.Pd, guru Bahasa Indonesia yang juga menjadi peserta workshop.</p>

<p>Selama workshop, para guru tidak hanya mendapatkan materi secara teoritis, tetapi juga melakukan praktik langsung menggunakan berbagai aplikasi dan platform pembelajaran digital. Setiap guru juga diminta untuk mengembangkan satu modul pembelajaran digital yang akan diimplementasikan di kelas masing-masing.</p>

<p>Kepala Sekolah, Bapak Rizal Rusdi, M.Pd, menekankan pentingnya literasi digital bagi para guru di era pendidikan modern. "Literasi digital bukan lagi sekadar keterampilan tambahan, tetapi sudah menjadi kompetensi dasar yang harus dimiliki oleh setiap pendidik. Kami berkomitmen untuk terus meningkatkan kapasitas guru-guru SMP 20 agar dapat memberikan layanan pendidikan terbaik bagi siswa," ujarnya.</p>

<p>Workshop ini merupakan bagian dari program pengembangan profesional berkelanjutan yang diselenggarakan oleh SMP 20 untuk meningkatkan kualitas pembelajaran. Ke depannya, sekolah berencana untuk menyelenggarakan serangkaian pelatihan lanjutan yang lebih spesifik sesuai dengan kebutuhan guru di masing-masing mata pelajaran.</p>',
                'status' => 'publish',
                'tanggal_publish' => $tanggalEmpatHariLalu,
                'views' => 156,
                'created_at' => $tanggalEmpatHariLalu,
                'updated_at' => $tanggalEmpatHariLalu,
            ],
            [
                'penulis_id' => $penulis->id,
                'jenis' => 'berita',
                'judul' => 'Tim Basket SMP 20 Lolos ke Final Kompetisi Antar Sekolah',
                'ringkasan' => 'Tim basket putra SMP 20 berhasil melaju ke babak final kompetisi basket antar SMP tingkat kota setelah mengalahkan SMP 15 dengan skor 68-62.',
                'isi' => '<p>Kabar membanggakan datang dari tim basket putra SMP 20 yang berhasil melaju ke babak final kompetisi basket antar SMP tingkat kota. Dalam pertandingan semifinal yang berlangsung sengit pada Sabtu, 3 Agustus 2024, tim SMP 20 berhasil mengalahkan tim SMP 15 dengan skor 68-62.</p>

<p>Pertandingan semifinal yang digelar di GOR Kota berlangsung sangat menegangkan. Kedua tim tampil dengan performa terbaik mereka dan saling kejar skor hingga kuarter terakhir. Pada kuarter keempat, tim SMP 20 berhasil menunjukkan mental juara dengan mencetak 22 poin dan hanya kebobolan 14 poin, sehingga berhasil membalikkan keadaan dan memenangkan pertandingan.</p>

<p>Bintang dalam pertandingan ini adalah Rafi Ahmad, siswa kelas 9C, yang mencetak 24 poin, 8 rebound, dan 5 assist. Kontribusi signifikan juga diberikan oleh Dimas Pratama (kelas 9A) dengan 18 poin dan 10 rebound, serta Fajar Ramadhan (kelas 8B) yang menyumbang 12 poin dan 7 assist.</p>

<p>"Anak-anak bermain dengan luar biasa hari ini. Mereka menunjukkan kerja sama tim yang solid dan mental juara, terutama di saat-saat kritis. Kami sangat bangga dengan pencapaian mereka," ujar Pak Andi, pelatih tim basket SMP 20.</p>

<p>Dengan kemenangan ini, tim basket putra SMP 20 akan menghadapi SMP 8, juara bertahan tahun lalu, di partai final yang akan digelar pada Sabtu, 10 Agustus 2024. Tim SMP 20 akan menjalani persiapan intensif selama seminggu ke depan untuk menghadapi lawan tangguh di final.</p>

<p>"Kami mengajak seluruh warga sekolah untuk memberikan dukungan langsung di GOR Kota pada pertandingan final nanti. Kehadiran dan dukungan dari teman-teman, guru, dan orang tua akan menjadi motivasi tambahan bagi tim untuk memberikan yang terbaik," ajak OSIS SMP 20 melalui pengumuman resmi.</p>

<p>Selamat dan sukses untuk tim basket putra SMP 20! Tunjukkan semangat juara di partai final!</p>',
                'status' => 'publish',
                'tanggal_publish' => $tanggalLimaHariLalu,
                'views' => 203,
                'created_at' => $tanggalLimaHariLalu,
                'updated_at' => $tanggalLimaHariLalu,
            ],
            [
                'penulis_id' => $penulis->id,
                'jenis' => 'berita',
                'judul' => 'Peringatan Hari Kemerdekaan di SMP 20',
                'ringkasan' => 'SMP 20 menyelenggarakan serangkaian kegiatan untuk memperingati HUT Kemerdekaan RI ke-79 dengan tema "Semangat Juang untuk Indonesia Maju".',
                'isi' => '<p>Dalam rangka memperingati Hari Ulang Tahun Kemerdekaan Republik Indonesia yang ke-79, SMP 20 menyelenggarakan serangkaian kegiatan dengan tema "Semangat Juang untuk Indonesia Maju". Kegiatan yang berlangsung dari tanggal 14-17 Agustus 2024 ini diikuti oleh seluruh warga sekolah dengan penuh semangat dan antusiasme.</p>

<p>Rangkaian kegiatan peringatan HUT RI di SMP 20 meliputi:</p>

<ol>
<li><strong>Upacara Bendera Khusus (17 Agustus)</strong><br>
Upacara bendera khusus akan dilaksanakan pada tanggal 17 Agustus 2024 pukul 07.30 WIB di lapangan sekolah. Upacara akan diikuti oleh seluruh siswa, guru, dan staf SMP 20. Pembina upacara adalah Kepala Sekolah, Bapak Rizal Rusdi, M.Pd.</li>

<li><strong>Lomba-lomba Tradisional (14-16 Agustus)</strong><br>
Berbagai lomba tradisional diselenggarakan untuk menumbuhkan semangat kebersamaan dan cinta tanah air, antara lain:
<ul>
<li>Lomba balap karung</li>
<li>Lomba makan kerupuk</li>
<li>Lomba tarik tambang</li>
<li>Lomba estafet sarung</li>
<li>Lomba panjat pinang</li>
</ul>
Lomba-lomba ini diikuti oleh perwakilan dari setiap kelas dan juga para guru.</li>

<li><strong>Pentas Seni Budaya Nusantara (16 Agustus)</strong><br>
Pentas seni yang menampilkan kekayaan budaya Indonesia dari berbagai daerah. Setiap kelas menampilkan satu pertunjukan seni yang mewakili budaya daerah tertentu di Indonesia, seperti tari tradisional, musik daerah, atau drama rakyat.</li>

<li><strong>Bakti Sosial (15 Agustus)</strong><br>
Kegiatan bakti sosial berupa pembagian sembako kepada masyarakat kurang mampu di sekitar lingkungan sekolah. Kegiatan ini bertujuan untuk menumbuhkan kepedulian sosial dan semangat berbagi di kalangan siswa.</li>
</ol>

<p>"Peringatan HUT RI tidak hanya sekadar seremonial, tetapi juga momentum untuk menanamkan nilai-nilai kebangsaan dan nasionalisme kepada para siswa. Melalui rangkaian kegiatan ini, kami berharap siswa dapat lebih menghargai perjuangan para pahlawan dan memahami makna kemerdekaan yang sesungguhnya," ujar Bapak Rizal Rusdi, M.Pd, Kepala SMP 20.</p>

<p>Seluruh warga sekolah diharapkan untuk berpartisipasi aktif dalam rangkaian kegiatan ini. Untuk informasi lebih lanjut mengenai jadwal dan teknis pelaksanaan masing-masing kegiatan, siswa dapat menghubungi wali kelas atau pengurus OSIS.</p>

<p>Mari kita rayakan HUT Kemerdekaan RI ke-79 dengan penuh semangat dan kebanggaan sebagai bangsa Indonesia!</p>',
                'status' => 'publish',
                'tanggal_publish' => $tanggalSemingguLalu,
                'views' => 278,
                'created_at' => $tanggalSemingguLalu,
                'updated_at' => $tanggalSemingguLalu,
            ],
            
            // Pengumuman
            [
                'penulis_id' => $penulis->id,
                'jenis' => 'pengumuman',
                'judul' => 'Jadwal Ujian Tengah Semester Ganjil Tahun Ajaran 2024/2025',
                'ringkasan' => 'Informasi mengenai jadwal pelaksanaan Ujian Tengah Semester Ganjil Tahun Ajaran 2024/2025 untuk seluruh siswa SMP 20.',
                'isi' => '<p>Kepada seluruh siswa SMP 20,</p>

<p>Berikut ini kami sampaikan jadwal pelaksanaan Ujian Tengah Semester Ganjil Tahun Ajaran 2024/2025 yang akan dilaksanakan pada tanggal 23-28 September 2024.</p>

<h4>Jadwal Ujian:</h4>
<table class="table table-bordered">
<thead>
<tr>
<th>Hari/Tanggal</th>
<th>Waktu</th>
<th>Mata Pelajaran</th>
<th>Kelas</th>
</tr>
</thead>
<tbody>
<tr>
<td rowspan="2">Senin, 23 September 2024</td>
<td>07.30 - 09.30</td>
<td>Bahasa Indonesia</td>
<td>7, 8, 9</td>
</tr>
<tr>
<td>10.00 - 12.00</td>
<td>IPS</td>
<td>7, 8, 9</td>
</tr>
<tr>
<td rowspan="2">Selasa, 24 September 2024</td>
<td>07.30 - 09.30</td>
<td>Matematika</td>
<td>7, 8, 9</td>
</tr>
<tr>
<td>10.00 - 12.00</td>
<td>Bahasa Inggris</td>
<td>7, 8, 9</td>
</tr>
<tr>
<td rowspan="2">Rabu, 25 September 2024</td>
<td>07.30 - 09.30</td>
<td>IPA</td>
<td>7, 8, 9</td>
</tr>
<tr>
<td>10.00 - 12.00</td>
<td>Pendidikan Agama</td>
<td>7, 8, 9</td>
</tr>
<tr>
<td rowspan="2">Kamis, 26 September 2024</td>
<td>07.30 - 09.30</td>
<td>PKn</td>
<td>7, 8, 9</td>
</tr>
<tr>
<td>10.00 - 12.00</td>
<td>Seni Budaya</td>
<td>7, 8, 9</td>
</tr>
<tr>
<td rowspan="2">Jumat, 27 September 2024</td>
<td>07.30 - 09.30</td>
<td>Prakarya</td>
<td>7, 8, 9</td>
</tr>
<tr>
<td>10.00 - 12.00</td>
<td>Bahasa Daerah</td>
<td>7, 8, 9</td>
</tr>
<tr>
<td rowspan="2">Sabtu, 28 September 2024</td>
<td>07.30 - 09.30</td>
<td>PJOK</td>
<td>7, 8, 9</td>
</tr>
<tr>
<td>10.00 - 12.00</td>
<td>Informatika</td>
<td>7, 8, 9</td>
</tr>
</tbody>
</table>

<h4>Ketentuan Ujian:</h4>
<ol>
<li>Siswa hadir di sekolah minimal 15 menit sebelum ujian dimulai.</li>
<li>Siswa wajib mengenakan seragam sekolah lengkap dan rapi.</li>
<li>Siswa membawa alat tulis sendiri (tidak diperkenankan meminjam).</li>
<li>Siswa dilarang membawa alat komunikasi elektronik ke dalam ruang ujian.</li>
<li>Siswa yang terlambat lebih dari 15 menit tidak diperkenankan mengikuti ujian pada sesi tersebut.</li>
<li>Siswa yang berhalangan hadir karena sakit harus menyerahkan surat keterangan dokter.</li>
</ol>

<p>Untuk persiapan ujian, para siswa dapat mengakses materi review di platform pembelajaran sekolah mulai tanggal 16 September 2024. Guru mata pelajaran juga akan memberikan review materi pada pertemuan terakhir sebelum ujian.</p>

<p>Demikian pengumuman ini disampaikan. Kami mengharapkan seluruh siswa dapat mempersiapkan diri dengan baik dan mengikuti ujian dengan tertib.</p>

<p>Untuk informasi lebih lanjut, silakan hubungi wali kelas masing-masing.</p>',
                'status' => 'publish',
                'tanggal_publish' => $tanggalKemarin,
                'views' => 312,
                'created_at' => $tanggalKemarin,
                'updated_at' => $tanggalKemarin,
            ],
            [
                'penulis_id' => $penulis->id,
                'jenis' => 'pengumuman',
                'judul' => 'Pendaftaran Ekstrakurikuler Semester Ganjil 2024/2025',
                'ringkasan' => 'Informasi mengenai pendaftaran kegiatan ekstrakurikuler untuk semester ganjil tahun ajaran 2024/2025.',
                'isi' => '<p>Kepada seluruh siswa SMP 20,</p>

<p>Dengan ini kami informasikan bahwa pendaftaran kegiatan ekstrakurikuler untuk semester ganjil tahun ajaran 2024/2025 akan dibuka mulai tanggal 15-25 Agustus 2024. Seluruh siswa diwajibkan untuk memilih minimal satu dan maksimal dua kegiatan ekstrakurikuler.</p>

<h4>Daftar Ekstrakurikuler yang Tersedia:</h4>
<ol>
<li><strong>Bidang Olahraga</strong>
<ul>
<li>Basket</li>
<li>Futsal</li>
<li>Voli</li>
<li>Badminton</li>
<li>Tenis Meja</li>
<li>Pencak Silat</li>
</ul>
</li>
<li><strong>Bidang Seni</strong>
<ul>
<li>Paduan Suara</li>
<li>Seni Tari</li>
<li>Teater</li>
<li>Band Sekolah</li>
<li>Seni Rupa</li>
</ul>
</li>
<li><strong>Bidang Akademik</strong>
<ul>
<li>Klub Matematika</li>
<li>Klub Sains</li>
<li>English Club</li>
<li>Jurnalistik</li>
<li>Robotika</li>
</ul>
</li>
<li><strong>Bidang Sosial & Kepemimpinan</strong>
<ul>
<li>Pramuka (wajib untuk kelas 7)</li>
<li>PMR</li>
<li>Klub Lingkungan Hidup</li>
<li>Klub Bahasa & Budaya</li>
</ul>
</li>
</ol>

<h4>Jadwal Pendaftaran:</h4>
<ul>
<li>Tanggal: 15-25 Agustus 2024</li>
<li>Metode Pendaftaran: Online melalui portal siswa</li>
<li>Pengumuman Penerimaan: 28 Agustus 2024</li>
<li>Mulai Kegiatan: 1 September 2024</li>
</ul>

<h4>Ketentuan Pendaftaran:</h4>
<ol>
<li>Setiap siswa wajib memilih minimal 1 dan maksimal 2 kegiatan ekstrakurikuler.</li>
<li>Siswa kelas 7 wajib mengikuti ekstrakurikuler Pramuka.</li>
<li>Beberapa ekstrakurikuler memiliki kuota terbatas dan akan dilakukan seleksi jika pendaftar melebihi kuota.</li>
<li>Siswa yang sudah diterima di ekstrakurikuler tertentu wajib mengikuti kegiatan secara rutin sesuai jadwal.</li>
<li>Ketidakhadiran tanpa keterangan sebanyak 3 kali berturut-turut akan dikenakan sanksi sesuai peraturan sekolah.</li>
</ol>

<p>Untuk informasi lebih detail mengenai masing-masing ekstrakurikuler, jadwal kegiatan, dan persyaratan khusus, siswa dapat mengakses buku panduan ekstrakurikuler di portal siswa atau menghubungi guru pembina ekstrakurikuler yang bersangkutan.</p>

<p>Demikian pengumuman ini disampaikan. Kami mendorong seluruh siswa untuk aktif berpartisipasi dalam kegiatan ekstrakurikuler sebagai wadah pengembangan minat dan bakat.</p>',
                'status' => 'publish',
                'tanggal_publish' => $tanggalTigaHariLalu,
                'views' => 289,
                'created_at' => $tanggalTigaHariLalu,
                'updated_at' => $tanggalTigaHariLalu,
            ],
            [
                'penulis_id' => $penulis->id,
                'jenis' => 'pengumuman',
                'judul' => 'Perubahan Jadwal Pelajaran Semester Ganjil 2024/2025',
                'ringkasan' => 'Informasi mengenai perubahan jadwal pelajaran untuk semester ganjil tahun ajaran 2024/2025 yang akan berlaku mulai 12 Agustus 2024.',
                'isi' => '<p>Kepada seluruh siswa dan orang tua/wali siswa SMP 20,</p>

<p>Dengan ini kami informasikan bahwa terdapat perubahan jadwal pelajaran untuk semester ganjil tahun ajaran 2024/2025. Jadwal baru akan mulai berlaku pada hari Senin, 12 Agustus 2024.</p>

<h4>Latar Belakang Perubahan:</h4>
<p>Perubahan jadwal ini dilakukan berdasarkan beberapa pertimbangan, antara lain:</p>
<ol>
<li>Penyesuaian dengan kurikulum terbaru</li>
<li>Optimalisasi penggunaan fasilitas sekolah</li>
<li>Penyesuaian dengan ketersediaan guru mata pelajaran</li>
<li>Masukan dari evaluasi jadwal sebelumnya</li>
</ol>

<h4>Hal-hal yang Perlu Diperhatikan:</h4>
<ol>
<li>Jadwal baru dapat diakses melalui:
<ul>
<li>Portal siswa (online)</li>
<li>Papan pengumuman sekolah</li>
<li>Wali kelas masing-masing</li>
</ul>
</li>
<li>Siswa diminta untuk memeriksa jadwal baru dan mempersiapkan buku dan perlengkapan sesuai dengan jadwal tersebut.</li>
<li>Beberapa mata pelajaran mungkin mengalami perubahan jam atau hari.</li>
<li>Jadwal piket kelas juga akan disesuaikan dengan jadwal baru.</li>
</ol>

<h4>Jam Pelajaran:</h4>
<table class="table table-bordered">
<thead>
<tr>
<th>Jam Ke-</th>
<th>Waktu</th>
<th>Keterangan</th>
</tr>
</thead>
<tbody>
<tr>
<td>0</td>
<td>06.45 - 07.15</td>
<td>Literasi/Pembinaan</td>
</tr>
<tr>
<td>1</td>
<td>07.15 - 07.55</td>
<td>Jam Pelajaran 1</td>
</tr>
<tr>
<td>2</td>
<td>07.55 - 08.35</td>
<td>Jam Pelajaran 2</td>
</tr>
<tr>
<td>3</td>
<td>08.35 - 09.15</td>
<td>Jam Pelajaran 3</td>
</tr>
<tr>
<td>-</td>
<td>09.15 - 09.30</td>
<td>Istirahat 1</td>
</tr>
<tr>
<td>4</td>
<td>09.30 - 10.10</td>
<td>Jam Pelajaran 4</td>
</tr>
<tr>
<td>5</td>
<td>10.10 - 10.50</td>
<td>Jam Pelajaran 5</td>
</tr>
<tr>
<td>6</td>
<td>10.50 - 11.30</td>
<td>Jam Pelajaran 6</td>
</tr>
<tr>
<td>-</td>
<td>11.30 - 12.10</td>
<td>Istirahat 2 / Sholat Dzuhur</td>
</tr>
<tr>
<td>7</td>
<td>12.10 - 12.50</td>
<td>Jam Pelajaran 7</td>
</tr>
<tr>
<td>8</td>
<td>12.50 - 13.30</td>
<td>Jam Pelajaran 8</td>
</tr>
</tbody>
</table>

<p>Untuk pertanyaan atau klarifikasi terkait jadwal baru, silakan menghubungi Wakil Kepala Sekolah Bidang Kurikulum atau wali kelas masing-masing.</p>

<p>Demikian pengumuman ini disampaikan. Kami mohon kerja sama dari seluruh siswa dan orang tua/wali untuk menyesuaikan dengan perubahan jadwal ini.</p>',
                'status' => 'publish',
                'tanggal_publish' => $tanggalEmpatHariLalu,
                'views' => 342,
                'created_at' => $tanggalEmpatHariLalu,
                'updated_at' => $tanggalEmpatHariLalu,
            ],
            [
                'penulis_id' => $penulis->id,
                'jenis' => 'pengumuman',
                'judul' => 'Pembayaran SPP dan Biaya Pendidikan Semester Ganjil 2024/2025',
                'ringkasan' => 'Informasi mengenai jadwal dan tata cara pembayaran SPP dan biaya pendidikan untuk semester ganjil tahun ajaran 2024/2025.',
                'isi' => '<p>Kepada Yth.<br>Orang Tua/Wali Siswa SMP 20</p>

<p>Dengan hormat,</p>

<p>Bersama ini kami sampaikan informasi mengenai pembayaran SPP dan biaya pendidikan untuk semester ganjil tahun ajaran 2024/2025.</p>

<h4>Jadwal Pembayaran:</h4>
<table class="table table-bordered">
<thead>
<tr>
<th>Bulan</th>
<th>Batas Waktu Pembayaran</th>
</tr>
</thead>
<tbody>
<tr>
<td>Juli 2024</td>
<td>15 Juli 2024</td>
</tr>
<tr>
<td>Agustus 2024</td>
<td>10 Agustus 2024</td>
</tr>
<tr>
<td>September 2024</td>
<td>10 September 2024</td>
</tr>
<tr>
<td>Oktober 2024</td>
<td>10 Oktober 2024</td>
</tr>
<tr>
<td>November 2024</td>
<td>10 November 2024</td>
</tr>
<tr>
<td>Desember 2024</td>
<td>10 Desember 2024</td>
</tr>
</tbody>
</table>

<h4>Rincian Biaya:</h4>
<table class="table table-bordered">
<thead>
<tr>
<th>Jenis Biaya</th>
<th>Jumlah (Rp)</th>
<th>Keterangan</th>
</tr>
</thead>
<tbody>
<tr>
<td>SPP Bulanan</td>
<td>500.000</td>
<td>Dibayarkan setiap bulan</td>
</tr>
<tr>
<td>Biaya Praktikum</td>
<td>250.000</td>
<td>Dibayarkan sekali di awal semester</td>
</tr>
<tr>
<td>Biaya Pengembangan</td>
<td>300.000</td>
<td>Dibayarkan sekali di awal semester</td>
</tr>
<tr>
<td>Biaya Kegiatan Siswa</td>
<td>200.000</td>
<td>Dibayarkan sekali di awal semester</td>
</tr>
</tbody>
</table>

<h4>Metode Pembayaran:</h4>
<ol>
<li><strong>Transfer Bank</strong><br>
Nama Bank: Bank Mandiri<br>
Nomor Rekening: 123-456-789-0<br>
Atas Nama: SMP 20 Jakarta<br>
<em>Catatan: Harap mencantumkan nama siswa dan kelas pada berita transfer</em></li>

<li><strong>Pembayaran Langsung</strong><br>
Tempat: Loket Pembayaran Sekolah<br>
Jam Layanan: 08.00 - 13.00 WIB (Senin-Jumat)</li>

<li><strong>Pembayaran Online</strong><br>
Melalui aplikasi pembayaran sekolah yang dapat diakses di portal orang tua</li>
</ol>

<h4>Ketentuan Penting:</h4>
<ol>
<li>Pembayaran yang melewati batas waktu akan dikenakan denda sebesar 5% dari jumlah tagihan.</li>
<li>Siswa yang memiliki tunggakan pembayaran lebih dari 2 bulan akan mendapatkan surat peringatan.</li>
<li>Bagi orang tua/wali yang mengalami kesulitan finansial, dapat mengajukan keringanan pembayaran dengan menghubungi bagian keuangan sekolah.</li>
<li>Bukti pembayaran harap disimpan dengan baik sebagai bukti jika terjadi kesalahan pencatatan.</li>
</ol>

<p>Untuk informasi lebih lanjut atau pertanyaan terkait pembayaran, silakan menghubungi Bagian Keuangan Sekolah di nomor (021) 1234567 atau email keuangan@smp20.sch.id.</p>

<p>Demikian informasi ini kami sampaikan. Terima kasih atas perhatian dan kerja sama Bapak/Ibu dalam mendukung kelancaran proses pendidikan di SMP 20.</p>',
                'status' => 'publish',
                'tanggal_publish' => $tanggalLimaHariLalu,
                'views' => 267,
                'created_at' => $tanggalLimaHariLalu,
                'updated_at' => $tanggalLimaHariLalu,
            ],
            [
                'penulis_id' => $penulis->id,
                'jenis' => 'pengumuman',
                'judul' => 'Pelatihan Persiapan Ujian Nasional untuk Kelas 9',
                'ringkasan' => 'Program pelatihan intensif persiapan Ujian Nasional untuk siswa kelas 9 yang akan dimulai pada bulan September 2024.',
                'isi' => '<p>Kepada Yth.<br>Siswa Kelas 9 dan Orang Tua/Wali</p>

<p>Dengan hormat,</p>

<p>Dalam rangka mempersiapkan siswa kelas 9 menghadapi Ujian Nasional, SMP 20 akan menyelenggarakan program pelatihan intensif yang akan dimulai pada bulan September 2024. Program ini dirancang untuk membantu siswa mempersiapkan diri secara optimal menghadapi Ujian Nasional yang akan dilaksanakan pada bulan April 2025.</p>

<h4>Informasi Program:</h4>
<ol>
<li><strong>Waktu Pelaksanaan</strong><br>
Mulai: 7 September 2024<br>
Selesai: Maret 2025<br>
Jadwal: Setiap hari Sabtu, pukul 08.00 - 12.00 WIB</li>

<li><strong>Mata Pelajaran</strong><br>
Program ini akan fokus pada 4 mata pelajaran yang diujikan dalam Ujian Nasional:
<ul>
<li>Bahasa Indonesia</li>
<li>Bahasa Inggris</li>
<li>Matematika</li>
<li>Ilmu Pengetahuan Alam (IPA)</li>
</ul>
</li>

<li><strong>Metode Pembelajaran</strong>
<ul>
<li>Pembahasan materi sesuai kisi-kisi Ujian Nasional</li>
<li>Latihan soal dan pembahasan</li>
<li>Tryout berkala untuk mengukur kemajuan</li>
<li>Konsultasi individual untuk siswa yang membutuhkan</li>
</ul>
</li>

<li><strong>Pengajar</strong><br>
Program ini akan dibimbing oleh guru-guru berpengalaman dari SMP 20 dan beberapa pengajar tamu dari lembaga pendidikan terkemuka.</li>
</ol>

<h4>Biaya Program:</h4>
<p>Biaya program pelatihan ini adalah Rp 1.500.000 untuk seluruh periode (September 2024 - Maret 2025). Biaya ini mencakup:</p>
<ul>
<li>Modul pembelajaran untuk 4 mata pelajaran</li>
<li>Buku kumpulan soal dan pembahasan</li>
<li>Tryout berkala (minimal 5 kali selama program)</li>
<li>Konsultasi dengan pengajar</li>
</ul>

<p>Pembayaran dapat dilakukan secara tunai atau transfer ke rekening sekolah paling lambat tanggal 31 Agustus 2024.</p>

<h4>Pendaftaran:</h4>
<p>Untuk mengikuti program ini, siswa/orang tua diminta untuk mengisi formulir pendaftaran yang tersedia di:</p>
<ul>
<li>Ruang Tata Usaha Sekolah</li>
<li>Portal Siswa (online)</li>
</ul>

<p>Batas waktu pendaftaran adalah tanggal 25 Agustus 2024.</p>

<h4>Pertemuan Orang Tua:</h4>
<p>Sebelum program dimulai, akan diadakan pertemuan dengan orang tua/wali siswa kelas 9 untuk menjelaskan lebih detail mengenai program ini. Pertemuan akan dilaksanakan pada:</p>
<ul>
<li>Hari/Tanggal: Sabtu, 31 Agustus 2024</li>
<li>Waktu: 09.00 - 11.00 WIB</li>
<li>Tempat: Aula SMP 20</li>
</ul>

<p>Kehadiran orang tua/wali sangat diharapkan untuk mendukung kesuksesan program ini.</p>

<p>Demikian pengumuman ini kami sampaikan. Kami berharap program ini dapat membantu siswa kelas 9 mempersiapkan diri dengan baik untuk menghadapi Ujian Nasional.</p>

<p>Untuk informasi lebih lanjut, silakan menghubungi Wakil Kepala Sekolah Bidang Kurikulum atau wali kelas masing-masing.</p>',
                'status' => 'publish',
                'tanggal_publish' => $tanggalSemingguLalu,
                'views' => 198,
                'created_at' => $tanggalSemingguLalu,
                'updated_at' => $tanggalSemingguLalu,
            ],
        ];

        foreach ($beritaPengumuman as $data) {
            Artikel::create($data);
        }

        $this->command->info('Berhasil membuat ' . count($beritaPengumuman) . ' artikel (5 berita, 5 pengumuman)');
    }
}