/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19-11.7.2-MariaDB, for osx10.19 (x86_64)
--
-- Host: 127.0.0.1    Database: lms_smp20
-- ------------------------------------------------------
-- Server version	11.7.2-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*M!100616 SET @OLD_NOTE_VERBOSITY=@@NOTE_VERBOSITY, NOTE_VERBOSITY=0 */;

--
-- Table structure for table `acara_akademik`
--

DROP TABLE IF EXISTS `acara_akademik`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `acara_akademik` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `judul` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai` date DEFAULT NULL,
  `sepanjang_hari` tinyint(1) NOT NULL DEFAULT 1,
  `warna_latar` varchar(20) NOT NULL DEFAULT '#4CAF50',
  `warna_teks` varchar(20) NOT NULL DEFAULT '#FFFFFF',
  `tahun_ajaran_id` bigint(20) unsigned DEFAULT NULL,
  `tipe` varchar(255) NOT NULL DEFAULT 'umum',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `acara_akademik_tahun_ajaran_id_foreign` (`tahun_ajaran_id`),
  CONSTRAINT `acara_akademik_tahun_ajaran_id_foreign` FOREIGN KEY (`tahun_ajaran_id`) REFERENCES `tahun_ajaran` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `acara_akademik`
--

LOCK TABLES `acara_akademik` WRITE;
/*!40000 ALTER TABLE `acara_akademik` DISABLE KEYS */;
/*!40000 ALTER TABLE `acara_akademik` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `artikel`
--

DROP TABLE IF EXISTS `artikel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `artikel` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `penulis_id` bigint(20) unsigned NOT NULL,
  `jenis` enum('berita','pengumuman') NOT NULL,
  `judul` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `ringkasan` text DEFAULT NULL,
  `isi` longtext NOT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `status` enum('draft','publish') NOT NULL DEFAULT 'draft',
  `tanggal_publish` timestamp NULL DEFAULT NULL,
  `views` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `kategori_id` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `artikel_slug_unique` (`slug`),
  KEY `artikel_penulis_id_foreign` (`penulis_id`),
  KEY `artikel_kategori_id_foreign` (`kategori_id`),
  CONSTRAINT `artikel_kategori_id_foreign` FOREIGN KEY (`kategori_id`) REFERENCES `kategori_artikel` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `artikel_penulis_id_foreign` FOREIGN KEY (`penulis_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `artikel`
--

LOCK TABLES `artikel` WRITE;
/*!40000 ALTER TABLE `artikel` DISABLE KEYS */;
INSERT INTO `artikel` VALUES
(4,1,'berita','SMPN 20 Jakarta Gelar Kegiatan Sedekah Minyak Jelantah','smpn-20-jakarta-gelar-kegiatan-sedekah-minyak-jelantah','Jakarta – Jumat, 18 Juli 2025, SMPN 20 Jakarta kembali menunjukkan komitmennya dalam mengembangkan budaya peduli lingkungan melalui kegiatan bertajuk','<p>Jakarta &ndash; Jumat, 18 Juli 2025, SMPN 20 Jakarta kembali menunjukkan komitmennya dalam mengembangkan budaya peduli lingkungan melalui kegiatan bertajuk &ldquo;Sedekah Minyak Jelantah&rdquo;. Kegiatan ini dilaksanakan di Lapangan Olahraga SMPN 20 Jakarta mulai pukul 07.30 WIB hingga selesai, dan diikuti oleh seluruh warga sekolah dengan antusias.</p>\r\n<p>Dalam kegiatan ini, peserta didik, guru, dan tenaga kependidikan diminta membawa minyak jelantah bekas pakai rumah tangga yang dikemas dalam botol ukuran 600ml atau lebih. Minyak tersebut kemudian dikumpulkan untuk didaur ulang dan dimanfaatkan kembali melalui mitra pengelola limbah ramah lingkungan.</p>\r\n<p>Kegiatan ini dipandu oleh Tim Sekolah Tersenyum SMPN 20 Jakarta yang telah aktif menggerakkan berbagai program Adiwiyata berbasis aksi nyata. Selain bertujuan mengurangi pencemaran lingkungan akibat pembuangan minyak jelantah sembarangan, kegiatan ini juga mendidik peserta didik agar lebih bertanggung jawab terhadap sampah rumah tangga.</p>\r\n<p>Kepala SMPN 20 Jakarta, Bapak Drs. Tugimin, M.MPd., dalam keterangannya menyampaikan apresiasi atas semangat seluruh peserta didik dalam mengikuti kegiatan ini. Beliau menegaskan bahwa pendidikan karakter dapat dibangun melalui aksi nyata seperti sedekah minyak, yang menggabungkan kepedulian sosial dan pelestarian lingkungan.</p>\r\n<p>Kegiatan ini juga menjadi bagian dari pembelajaran kontekstual yang sejalan dengan Kurikulum Merdeka, serta memperkuat budaya sekolah yang peduli lingkungan.</p>\r\n<p>Salam Lestari, Salam Hijau, Salam Mendaur!</p>','artikel-1757212036.png','publish','2025-09-07 02:27:16',3,'2025-09-07 02:27:16','2025-09-13 07:32:15',NULL),
(5,1,'pengumuman','Projek P5 Suara Demokrasi Pemilihan Ketua OSIS masa bakti 2024-2025','projek-p5-suara-demokrasi-pemilihan-ketua-osis-masa-bakti-2024-2025','Proyek P5 Suara Demokrasi: Pemilihan Ketua OSIS di SMPN 20 Jakarta (Fase D)\r\nPendahuluan\r\nDi SMPN 20 Jakarta, implementasi Kurikulum Merdeka difokuska','<p><strong>Proyek P5 Suara Demokrasi: Pemilihan Ketua OSIS di SMPN 20 Jakarta (Fase D)</strong></p>\r\n<p><strong>Pendahuluan</strong></p>\r\n<p>Di SMPN 20 Jakarta, implementasi Kurikulum Merdeka difokuskan untuk membangun karakter siswa melalui Proyek Penguatan Profil Pelajar Pancasila (P5). Salah satu tema yang relevan untuk Fase D (kelas 7-9) adalah&nbsp;<em>Suara Demokrasi</em>, di mana siswa dilibatkan dalam proses simulasi demokrasi, khususnya dalam pemilihan Ketua OSIS. Proyek ini dirancang untuk memberikan pengalaman belajar yang kontekstual, membina kesadaran demokrasi, serta meningkatkan keterampilan berpikir kritis dan partisipasi sosial siswa.</p>\r\n<p><strong>Latar Belakang SMPN 20 Jakarta</strong></p>\r\n<p>Sebagai sekolah yang aktif dalam menerapkan prinsip keberlanjutan melalui program Projek P5, SMPN 20 Jakarta mengintegrasikan nilai-nilai demokrasi dengan penguatan kepemimpinan melalui kegiatan OSIS. Pemilihan Ketua OSIS menjadi salah satu momen penting dalam siklus demokrasi sekolah yang melibatkan siswa dalam praktik demokrasi secara langsung.</p>\r\n<p><strong>Tujuan Pembelajaran</strong></p>\r\n<ol>\r\n<li><strong>Memahami Prinsip Demokrasi dan Pemilu</strong>: Siswa belajar bagaimana sistem pemilihan umum berjalan dan bagaimana hak-hak politik mereka diakui dan dihargai.</li>\r\n<li><strong>Berpikir Kritis dan Analitis</strong>: Siswa dilatih untuk menganalisis visi-misi para calon Ketua OSIS dan menilai kelayakan program yang diajukan.</li>\r\n<li><strong>Mengembangkan Komunikasi dan Kolaborasi</strong>: Dalam proses kampanye dan debat, siswa berlatih menyampaikan gagasan secara jelas, mendengarkan pendapat lain, serta bekerja sama dalam tim.</li>\r\n<li><strong>Memperkuat Kepemimpinan dan Tanggung Jawab</strong>: Calon Ketua OSIS dan tim kampanye belajar bagaimana mengelola program kerja, berinteraksi dengan pemilih, dan mengambil tanggung jawab atas keputusan yang mereka buat.</li>\r\n</ol>\r\n<p><strong>Langkah-Langkah Proyek</strong></p>\r\n<ol>\r\n<li>\r\n<p><strong>Tahap Persiapan</strong>:</p>\r\n<ul>\r\n<li>Guru memberikan pengantar mengenai konsep demokrasi, peran OSIS, dan prinsip-prinsip dasar pemilu yang adil dan jujur.</li>\r\n<li>Pembentukan panitia pemilihan oleh siswa yang terdiri dari kelas 7 hingga 9, bertanggung jawab untuk menyusun jadwal pemilu, menyiapkan logistik, serta mengelola jalannya kampanye dan debat.</li>\r\n</ul>\r\n</li>\r\n<li>\r\n<p><strong>Tahap Pencalonan</strong>:</p>\r\n<ul>\r\n<li>Proses seleksi calon Ketua OSIS dilakukan dengan meminta siswa yang berminat untuk mendaftarkan diri dan menyusun program kerja yang inovatif dan relevan dengan kebutuhan sekolah, termasuk program yang mendukung keberlanjutan sekolah Adiwiyata.</li>\r\n<li>Para calon Ketua OSIS diwajibkan membuat kampanye digital dan fisik dengan materi yang menarik, seperti poster, video pendek, dan infografis.</li>\r\n</ul>\r\n</li>\r\n<li>\r\n<p><strong>Kampanye dan Debat Terbuka</strong>:</p>\r\n<ul>\r\n<li>Setiap calon akan diberi kesempatan untuk mempresentasikan visi dan misi mereka di depan seluruh siswa. Dalam kampanye ini, mereka juga harus menunjukkan bagaimana program kerja mereka mendukung lingkungan sekolah yang ramah dan berkelanjutan.</li>\r\n<li>Debat terbuka akan diadakan, di mana calon Ketua OSIS saling menanggapi pertanyaan dari panitia pemilihan, guru, dan pemilih.</li>\r\n</ul>\r\n</li>\r\n<li>\r\n<p><strong>Pemungutan Suara</strong>:</p>\r\n<ul>\r\n<li>Pemilu dilaksanakan di seluruh sekolah dengan sistem pemungutan suara, sesuai dengan prinsip&nbsp;<em>paperless</em>&nbsp;yang diusung oleh sekolah dalam upaya menjaga keberlanjutan.</li>\r\n<li>Setiap siswa diberikan hak suara yang sama, dan hasil pemilihan diumumkan secara terbuka.</li>\r\n</ul>\r\n</li>\r\n<li>\r\n<p><strong>Evaluasi dan Refleksi</strong>:</p>\r\n<ul>\r\n<li>Setelah pemilu selesai, seluruh proses dievaluasi oleh guru dan siswa. Refleksi ini meliputi pembahasan tentang bagaimana proses demokrasi berjalan, apa saja tantangan yang dihadapi, serta bagaimana keterlibatan siswa dalam pemilihan ini membantu mereka memahami pentingnya demokrasi.</li>\r\n</ul>\r\n</li>\r\n</ol>\r\n<p><strong>Profil Pelajar Pancasila yang Dikuatkan</strong></p>\r\n<p>Melalui proyek ini, siswa SMPN 20 Jakarta menguatkan berbagai dimensi Profil Pelajar Pancasila:</p>\r\n<ul>\r\n<li><strong>Beriman, Bertakwa kepada Tuhan YME, dan Berakhlak Mulia</strong>: Siswa menghormati perbedaan pendapat, mengedepankan nilai-nilai moral dalam berkompetisi.</li>\r\n<li><strong>Berkebinekaan Global</strong>: Siswa belajar menghargai keragaman latar belakang dan pendapat dalam proses pemilihan.</li>\r\n<li><strong>Gotong Royong</strong>: Siswa bekerja sama dalam tim kampanye, panitia pemilihan, serta dalam proses pemungutan suara.</li>\r\n<li><strong>Mandiri</strong>: Siswa berlatih mengambil keputusan secara mandiri berdasarkan analisis program kerja para calon.</li>\r\n<li><strong>Bernalar Kritis</strong>: Siswa terlibat dalam berpikir kritis saat mengevaluasi calon Ketua OSIS dan program kerja yang ditawarkan.</li>\r\n<li><strong>Kreatif</strong>: Siswa menciptakan berbagai kampanye yang inovatif dengan menggunakan berbagai media, baik digital maupun fisik.</li>\r\n</ul>\r\n<p><strong>Penutup</strong></p>\r\n<p>Proyek P5&nbsp;<em>Suara Demokrasi</em> di SMPN 20 Jakarta memberikan ruang bagi siswa untuk memahami dan menerapkan prinsip-prinsip demokrasi melalui pengalaman nyata. Melalui pemilihan Ketua OSIS, siswa tidak hanya belajar tentang proses pemilihan umum, tetapi juga bagaimana menjadi warga negara yang aktif dan bertanggung jawab. Keterlibatan siswa dalam proyek ini juga mendukung tujuan sekolah untuk menciptakan lingkungan belajar yang berkelanjutan dan partisipatif, sejalan dengan visi Adiwiyata yang dijunjung tinggi di SMPN 20 Jakarta.</p>','artikel-1757212613.png','publish','2025-09-07 02:36:53',11,'2025-09-07 02:36:53','2025-09-13 07:35:00',NULL),
(6,1,'berita','SMPN 20 Jakarta Gelar Upacara Bendera Rutin, Bangun Semangat Menjadi Pribadi Berkualitas','smpn-20-jakarta-gelar-upacara-bendera-rutin-bangun-semangat-menjadi-pribadi-berkualitas','Jakarta, 28 Juli 2025 – SMP Negeri 20 Jakarta kembali melaksanakan kegiatan upacara bendera rutin pada hari Senin, 28 Juli 2025. Upacara berlangsung d','<p>Jakarta, 28 Juli 2025 &ndash; SMP Negeri 20 Jakarta kembali melaksanakan kegiatan upacara bendera rutin pada hari Senin, 28 Juli 2025. Upacara berlangsung dengan khidmat di lapangan utama sekolah dan diikuti oleh seluruh peserta didik, dewan guru, serta tenaga kependidikan. Kegiatan ini merupakan bagian dari pembiasaan positif dalam membentuk karakter disiplin dan cinta tanah air di lingkungan sekolah.</p>\r\n<p>Upacara dimulai tepat pukul 06.30 WIB, dengan peserta didik telah hadir di lapangan sejak pukul 06.20 WIB untuk melakukan persiapan dan pengecekan atribut. Petugas upacara pada kesempatan ini berasal dari kelas 9A, yang telah menjalankan tugasnya dengan baik dan penuh tanggung jawab.</p>\r\n<p>Adapun susunan petugas upacara adalah sebagai berikut:</p>\r\n<ul>\r\n<li>Pemimpin Upacara: Mehrzad</li>\r\n<li>Pengatur Upacara: Arif</li>\r\n<li>Pengibar Bendera: Khiran, Sakura, Diandra</li>\r\n<li>Komandan Pleton:</li>\r\n<li>Pleton 1: Zaid</li>\r\n<li>Pleton 2: Faqih</li>\r\n<li>Pleton 3: Fatan</li>\r\n<li>MC (Pembawa Acara): Farah</li>\r\n<li>Pembaca UUD 1945: Rayya</li>\r\n<li>Pembaca Janji Siswa: Silla</li>\r\n<li>Pembaca Doa: Rizieq</li>\r\n<li>Pembawa Teks Pancasila: Dara</li>\r\n</ul>\r\n<p>Sebagai pembina upacara, Ibu Nena Amelia, S.Pd menyampaikan amanat yang mengangkat tema &ldquo;Teruslah berjuang, belajar, dan berkembang untuk menjadi pribadi yang berkualitas dan bermanfaat bagi lingkungan sekitar.&rdquo; Dalam amanatnya, beliau mengajak seluruh peserta didik untuk selalu meningkatkan semangat belajar, membangun sikap positif, dan berkontribusi bagi lingkungan sekolah maupun masyarakat.</p>\r\n<p>&ldquo;Menjadi pribadi yang berkualitas tidak cukup hanya dengan prestasi akademik, tetapi juga harus diiringi dengan karakter yang baik, tangguh, dan bermanfaat bagi sesama,&rdquo; ujar beliau di hadapan peserta upacara.</p>\r\n<p>Kegiatan ini merupakan bagian dari komitmen sekolah dalam menanamkan nilai-nilai religius, nasionalis, dan berkarakter, sesuai dengan slogan SMPN 20 Jakarta: Religius, Nasionalis, dan Berkarakter. Selain sebagai bentuk penghormatan terhadap simbol negara, upacara juga menjadi sarana pendidikan karakter yang konsisten dilaksanakan setiap pekan.</p>\r\n<p>Kepala SMPN 20 Jakarta, Bapak Drs. Tugimin, M.M.Pd, memberikan apresiasi atas kinerja tim petugas upacara dan berharap semangat yang ditanamkan melalui kegiatan ini dapat terus menjadi budaya positif di lingkungan sekolah.</p>\r\n<p>Penulis: Tim Redaksi Website SMPN 20 Jakarta</p>','artikel-1757219570.png','publish','2025-09-07 04:32:50',9,'2025-09-07 04:32:50','2025-09-13 07:31:49',1),
(7,1,'berita','Tim Paskibra SMPN 20 Jakarta Raih Juara Bina 1 di Ajang AKABSI Tingkat Se-Jabodetabek','tim-paskibra-smpn-20-jakarta-raih-juara-bina-1-di-ajang-akabsi-tingkat-se-jabodetabek','Tim Paskibra SMPN 20 Jakarta Raih Juara Bina 1 di Ajang AKABSI Tingkat Se-Jabodetabek\r\nSMPN 20 Jakarta — Prestasi membanggakan kembali ditorehkan oleh','<p><strong>Tim Paskibra SMPN 20 Jakarta Raih Juara Bina 1 di Ajang AKABSI Tingkat Se-Jabodetabek</strong></p>\r\n<p><em>SMPN 20 Jakarta &mdash;</em>&nbsp;Prestasi membanggakan kembali ditorehkan oleh Tim Pasukan Pengibar Bendera (Paskibra) SMPN 20 Jakarta. Dalam ajang&nbsp;<strong>AKABSI (Ajang Kreasi Anak Bangsa Berprestasi)</strong>&nbsp;yang digelar pada&nbsp;<strong>10 Mei 2025</strong>&nbsp;di&nbsp;<strong>SMPN 245 Jakarta</strong>, tim Paskibra berhasil meraih&nbsp;<strong>Juara Bina 1</strong>&nbsp;pada kompetisi bergengsi tingkat&nbsp;<strong>Se-Jabodetabek</strong>&nbsp;tersebut.</p>\r\n<p>Kegiatan ini diikuti oleh berbagai sekolah dari wilayah Jabodetabek yang menampilkan ketangkasan baris-berbaris serta kekompakan tim. SMPN 20 Jakarta tampil gemilang di bawah bimbingan&nbsp;<strong>pembina Ibu Eka Salma, S.Pd</strong>&nbsp;dan pelatih andal&nbsp;<strong>Alrega</strong>, yang telah membimbing para anggota dengan penuh dedikasi dan semangat juang tinggi.</p>\r\n<p>Kepala SMPN 20 Jakarta,&nbsp;<strong>Bapak Drs. Tugimin, M.M.Pd</strong>, menyampaikan rasa bangga dan apresiasinya atas pencapaian luar biasa ini. \"Prestasi ini menjadi bukti bahwa semangat disiplin, kerja sama tim, dan latihan yang konsisten mampu membawa hasil yang membanggakan. Selamat untuk seluruh tim, pembina, dan pelatih,\" ujarnya.</p>\r\n<p>Berikut adalah nama-nama siswa anggota tim Paskibra SMPN 20 Jakarta yang mengukir prestasi pada lomba AKABSI 2025:</p>\r\n<ol>\r\n<li>\r\n<p>Aldes Arya Dwipangga Aulia Akbar (8H)</p>\r\n</li>\r\n<li>\r\n<p>Athalia Pugita Hayu (8B)</p>\r\n</li>\r\n<li>\r\n<p>Muhammad Rheyvan Ibrahim (9A)</p>\r\n</li>\r\n<li>\r\n<p>Kayla Betari Oktavia (7F)</p>\r\n</li>\r\n<li>\r\n<p>Kynthia Rafa Parcira (8A)</p>\r\n</li>\r\n<li>\r\n<p>Muhammad Rama Faqih (8A)</p>\r\n</li>\r\n<li>\r\n<p>Muthia Shafa Khalifah (8A)</p>\r\n</li>\r\n<li>\r\n<p>Nataneila Quena Aisyah (8C)</p>\r\n</li>\r\n<li>\r\n<p>Qheysha Dewi Aryani (8D)</p>\r\n</li>\r\n<li>\r\n<p>Septian Ahmad (8G) -&nbsp;<em>Danton</em></p>\r\n</li>\r\n<li>\r\n<p>Suci Ramadhani (8G)</p>\r\n</li>\r\n<li>\r\n<p>Wildan Julianto (8I)</p>\r\n</li>\r\n<li>\r\n<p>Yusli Oksman Siddik (8A)</p>\r\n</li>\r\n<li>\r\n<p>Zahban Nur (8E)</p>\r\n</li>\r\n<li>\r\n<p>Farand Razak (8A)</p>\r\n</li>\r\n<li>\r\n<p>Wiramukti Adi Luhung (8G)</p>\r\n</li>\r\n</ol>\r\n<p>Prestasi ini menjadi pemicu semangat seluruh warga sekolah untuk terus berkarya dan berprestasi di berbagai bidang. Semoga Tim Paskibra SMPN 20 Jakarta terus menginspirasi dan mempertahankan semangat juang dalam setiap langkah.</p>\r\n<p><strong>#SMPN20Jakarta #PaskibraJuara #AKABSI2025 #SekolahBerprestasi #BanggaMenjadi20</strong></p>','artikel-1757219955.png','publish','2025-09-07 04:39:15',18,'2025-09-07 04:39:15','2025-09-13 07:35:22',3),
(8,1,'berita','SMPN 20 Jakarta Gelar Penyuluhan Pencegahan Anemia untuk Remaja','smpn-20-jakarta-gelar-penyuluhan-pencegahan-anemia-untuk-remaja','Jakarta - Jumat, 25 Juli 2025SMPN 20 Jakarta menyelenggarakan kegiatan Penyuluhan Pencegahan Anemia bagi Remaja yang diikuti oleh peserta didik pada J','<p>Jakarta - Jumat, 25 Juli 2025<br>SMPN 20 Jakarta menyelenggarakan kegiatan Penyuluhan Pencegahan Anemia bagi Remaja yang diikuti oleh peserta didik pada Jumat, 25 Juli 2025. Kegiatan edukatif ini bertujuan untuk meningkatkan kesadaran siswa terhadap pentingnya menjaga kesehatan, khususnya dalam mencegah anemia yang rentan dialami oleh remaja.</p>\r\n<p>Hadir sebagai narasumber, dr. Sartika dan dr. Nani dari tim kesehatan Puskesmas Kelurahan Tengah, yang memberikan penjelasan komprehensif mengenai gejala, penyebab, dan langkah pencegahan anemia. Para siswa tampak antusias mengikuti sesi penyuluhan, yang disampaikan secara interaktif dan komunikatif.</p>\r\n<p>Kegiatan ini merupakan hasil kolaborasi antara tim UKS dan PMR SMPN 20 Jakarta dengan bimbingan dari tim Bimbingan Konseling (BK) serta dukungan dari bidang Kesiswaan. Sinergi antarbidang ini menjadi wujud nyata komitmen sekolah dalam membentuk generasi sehat dan berpengetahuan.</p>\r\n<p>Kepala SMPN 20 Jakarta, Bapak Drs. Tugimin, M.M.Pd menyampaikan apresiasi atas terselenggaranya kegiatan ini. \"Kami mendukung penuh kegiatan yang bertujuan meningkatkan kesadaran kesehatan peserta didik. Semoga anak-anak kita tumbuh menjadi remaja yang sehat, tangguh, dan berkarakter,\" ujarnya.</p>\r\n<p>Dengan penyuluhan ini, diharapkan para siswa dapat menerapkan pola hidup sehat sejak dini dan menjadi agen perubahan dalam lingkungan keluarga dan masyarakat.</p>\r\n<p>#PMRDupul<br>#RemajaSehat<br>#CegahAnemia</p>','artikel-1757220335.png','publish','2025-09-13 07:52:53',6,'2025-09-07 04:40:25','2025-09-13 07:52:53',1),
(10,1,'berita','uhuy','uhuy','uhy','<p>uhy</p>',NULL,'draft',NULL,4,'2025-09-13 07:15:05','2025-09-13 07:53:07',2);
/*!40000 ALTER TABLE `artikel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `galeri`
--

DROP TABLE IF EXISTS `galeri`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `galeri` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `kategori_galeri_id` bigint(20) unsigned NOT NULL,
  `judul` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `tipe` enum('foto','video') NOT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `youtube_url` varchar(255) DEFAULT NULL,
  `youtube_thumbnail` varchar(255) DEFAULT NULL,
  `tanggal_foto` date DEFAULT NULL,
  `fotografer` varchar(255) DEFAULT NULL,
  `urutan` int(11) NOT NULL DEFAULT 0,
  `status` enum('aktif','nonaktif') NOT NULL DEFAULT 'aktif',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `galeri_kategori_galeri_id_foreign` (`kategori_galeri_id`),
  CONSTRAINT `galeri_kategori_galeri_id_foreign` FOREIGN KEY (`kategori_galeri_id`) REFERENCES `kategori_galeri` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `galeri`
--

LOCK TABLES `galeri` WRITE;
/*!40000 ALTER TABLE `galeri` DISABLE KEYS */;
INSERT INTO `galeri` VALUES
(4,1,'Labore eu animi del','Labore repudiandae c','foto','galeri-1757832929-1.png',NULL,NULL,'1979-04-27','Laboris vitae qui om',1,'nonaktif','2025-09-14 06:55:29','2025-09-14 06:59:59');
/*!40000 ALTER TABLE `galeri` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `halaman`
--

DROP TABLE IF EXISTS `halaman`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `halaman` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `penulis_id` bigint(20) unsigned NOT NULL,
  `judul` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `isi` longtext NOT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `status` enum('draft','publish') NOT NULL DEFAULT 'draft',
  `tanggal_publish` timestamp NULL DEFAULT NULL,
  `views` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `halaman_slug_unique` (`slug`),
  KEY `halaman_penulis_id_foreign` (`penulis_id`),
  CONSTRAINT `halaman_penulis_id_foreign` FOREIGN KEY (`penulis_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `halaman`
--

LOCK TABLES `halaman` WRITE;
/*!40000 ALTER TABLE `halaman` DISABLE KEYS */;
/*!40000 ALTER TABLE `halaman` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hasil_kuis`
--

DROP TABLE IF EXISTS `hasil_kuis`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `hasil_kuis` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tugas_id` bigint(20) unsigned NOT NULL,
  `kuis_id` bigint(20) unsigned NOT NULL,
  `siswa_id` bigint(20) unsigned NOT NULL,
  `nilai_total` double NOT NULL DEFAULT 0,
  `jumlah_benar` int(11) NOT NULL DEFAULT 0,
  `jumlah_salah` int(11) NOT NULL DEFAULT 0,
  `jumlah_tidak_dijawab` int(11) NOT NULL DEFAULT 0,
  `waktu_mulai` timestamp NULL DEFAULT NULL,
  `waktu_selesai` timestamp NULL DEFAULT NULL,
  `status` enum('belum_mulai','sedang_mengerjakan','selesai') NOT NULL DEFAULT 'belum_mulai',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `hasil_kuis_siswa_id_kuis_id_tugas_id_unique` (`siswa_id`,`kuis_id`,`tugas_id`),
  KEY `hasil_kuis_tugas_id_foreign` (`tugas_id`),
  KEY `hasil_kuis_kuis_id_foreign` (`kuis_id`),
  CONSTRAINT `hasil_kuis_kuis_id_foreign` FOREIGN KEY (`kuis_id`) REFERENCES `kuis` (`id`) ON DELETE CASCADE,
  CONSTRAINT `hasil_kuis_siswa_id_foreign` FOREIGN KEY (`siswa_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `hasil_kuis_tugas_id_foreign` FOREIGN KEY (`tugas_id`) REFERENCES `tugas` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hasil_kuis`
--

LOCK TABLES `hasil_kuis` WRITE;
/*!40000 ALTER TABLE `hasil_kuis` DISABLE KEYS */;
/*!40000 ALTER TABLE `hasil_kuis` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `informasi_sekolah`
--

DROP TABLE IF EXISTS `informasi_sekolah`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `informasi_sekolah` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nama_sekolah` varchar(255) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `nomor_telepon` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `nomor_handphone` varchar(255) DEFAULT NULL,
  `latitude` varchar(255) DEFAULT NULL,
  `longitude` varchar(255) DEFAULT NULL,
  `tagline` text DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `favicon` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `informasi_sekolah`
--

LOCK TABLES `informasi_sekolah` WRITE;
/*!40000 ALTER TABLE `informasi_sekolah` DISABLE KEYS */;
INSERT INTO `informasi_sekolah` VALUES
(1,'SMPN 20 Jakarta','Enim enim velit et','021 12345678','admin@lms.it','+62 (123) 968-8205',NULL,NULL,'Odit ut commodi sequ','1757085214.png','2025-09-05 14:31:31','2025-09-13 07:43:23','1757085365.png');
/*!40000 ALTER TABLE `informasi_sekolah` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jadwal_pelajaran`
--

DROP TABLE IF EXISTS `jadwal_pelajaran`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `jadwal_pelajaran` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `kelas_id` bigint(20) unsigned NOT NULL,
  `mata_pelajaran_id` bigint(20) unsigned NOT NULL,
  `guru_id` bigint(20) unsigned NOT NULL,
  `hari` enum('senin','selasa','rabu','kamis','jumat','sabtu') NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL,
  `ruangan` varchar(255) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `jadwal_pelajaran_mata_pelajaran_id_foreign` (`mata_pelajaran_id`),
  KEY `jadwal_pelajaran_kelas_id_hari_index` (`kelas_id`,`hari`),
  KEY `jadwal_pelajaran_guru_id_hari_index` (`guru_id`,`hari`),
  CONSTRAINT `jadwal_pelajaran_guru_id_foreign` FOREIGN KEY (`guru_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `jadwal_pelajaran_kelas_id_foreign` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`) ON DELETE CASCADE,
  CONSTRAINT `jadwal_pelajaran_mata_pelajaran_id_foreign` FOREIGN KEY (`mata_pelajaran_id`) REFERENCES `mata_pelajaran` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jadwal_pelajaran`
--

LOCK TABLES `jadwal_pelajaran` WRITE;
/*!40000 ALTER TABLE `jadwal_pelajaran` DISABLE KEYS */;
/*!40000 ALTER TABLE `jadwal_pelajaran` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jawaban_kuis`
--

DROP TABLE IF EXISTS `jawaban_kuis`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `jawaban_kuis` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `pertanyaan_id` bigint(20) unsigned NOT NULL,
  `jawaban` text NOT NULL,
  `is_benar` tinyint(1) NOT NULL DEFAULT 0,
  `urutan` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `jawaban_kuis_pertanyaan_id_foreign` (`pertanyaan_id`),
  CONSTRAINT `jawaban_kuis_pertanyaan_id_foreign` FOREIGN KEY (`pertanyaan_id`) REFERENCES `pertanyaan_kuis` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jawaban_kuis`
--

LOCK TABLES `jawaban_kuis` WRITE;
/*!40000 ALTER TABLE `jawaban_kuis` DISABLE KEYS */;
/*!40000 ALTER TABLE `jawaban_kuis` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jawaban_siswa_kuis`
--

DROP TABLE IF EXISTS `jawaban_siswa_kuis`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `jawaban_siswa_kuis` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tugas_id` bigint(20) unsigned NOT NULL,
  `kuis_id` bigint(20) unsigned NOT NULL,
  `siswa_id` bigint(20) unsigned NOT NULL,
  `pertanyaan_id` bigint(20) unsigned NOT NULL,
  `jawaban_teks` text DEFAULT NULL,
  `jawaban_id` bigint(20) unsigned DEFAULT NULL,
  `is_benar` tinyint(1) DEFAULT NULL,
  `nilai` double DEFAULT NULL,
  `waktu_mulai` timestamp NULL DEFAULT NULL,
  `waktu_selesai` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `jawaban_siswa_kuis_siswa_id_pertanyaan_id_tugas_id_unique` (`siswa_id`,`pertanyaan_id`,`tugas_id`),
  KEY `jawaban_siswa_kuis_tugas_id_foreign` (`tugas_id`),
  KEY `jawaban_siswa_kuis_kuis_id_foreign` (`kuis_id`),
  KEY `jawaban_siswa_kuis_pertanyaan_id_foreign` (`pertanyaan_id`),
  KEY `jawaban_siswa_kuis_jawaban_id_foreign` (`jawaban_id`),
  CONSTRAINT `jawaban_siswa_kuis_jawaban_id_foreign` FOREIGN KEY (`jawaban_id`) REFERENCES `jawaban_kuis` (`id`) ON DELETE SET NULL,
  CONSTRAINT `jawaban_siswa_kuis_kuis_id_foreign` FOREIGN KEY (`kuis_id`) REFERENCES `kuis` (`id`) ON DELETE CASCADE,
  CONSTRAINT `jawaban_siswa_kuis_pertanyaan_id_foreign` FOREIGN KEY (`pertanyaan_id`) REFERENCES `pertanyaan_kuis` (`id`) ON DELETE CASCADE,
  CONSTRAINT `jawaban_siswa_kuis_siswa_id_foreign` FOREIGN KEY (`siswa_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `jawaban_siswa_kuis_tugas_id_foreign` FOREIGN KEY (`tugas_id`) REFERENCES `tugas` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jawaban_siswa_kuis`
--

LOCK TABLES `jawaban_siswa_kuis` WRITE;
/*!40000 ALTER TABLE `jawaban_siswa_kuis` DISABLE KEYS */;
/*!40000 ALTER TABLE `jawaban_siswa_kuis` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kabupatens`
--

DROP TABLE IF EXISTS `kabupatens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `kabupatens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `kode` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `kode_provinsi` varchar(255) NOT NULL,
  `lat` decimal(10,7) DEFAULT NULL,
  `lng` decimal(10,7) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `kabupatens_kode_unique` (`kode`),
  KEY `kabupatens_kode_provinsi_foreign` (`kode_provinsi`),
  CONSTRAINT `kabupatens_kode_provinsi_foreign` FOREIGN KEY (`kode_provinsi`) REFERENCES `provinsis` (`kode`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kabupatens`
--

LOCK TABLES `kabupatens` WRITE;
/*!40000 ALTER TABLE `kabupatens` DISABLE KEYS */;
/*!40000 ALTER TABLE `kabupatens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kategori_artikel`
--

DROP TABLE IF EXISTS `kategori_artikel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `kategori_artikel` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kategori_artikel`
--

LOCK TABLES `kategori_artikel` WRITE;
/*!40000 ALTER TABLE `kategori_artikel` DISABLE KEYS */;
INSERT INTO `kategori_artikel` VALUES
(1,'PPDB 2026','ppdb-2026','2025-09-07 08:29:03','2025-09-07 08:29:03'),
(2,'Ekskul','ekskul','2025-09-07 08:58:23','2025-09-07 08:58:23'),
(3,'Informasi Sekolah','informasi-sekolah','2025-09-07 08:58:43','2025-09-07 08:58:43');
/*!40000 ALTER TABLE `kategori_artikel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kategori_galeri`
--

DROP TABLE IF EXISTS `kategori_galeri`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `kategori_galeri` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nama_kategori` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `gambar_cover` varchar(255) DEFAULT NULL,
  `status` enum('aktif','nonaktif') NOT NULL DEFAULT 'aktif',
  `urutan` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `kategori_galeri_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kategori_galeri`
--

LOCK TABLES `kategori_galeri` WRITE;
/*!40000 ALTER TABLE `kategori_galeri` DISABLE KEYS */;
INSERT INTO `kategori_galeri` VALUES
(1,'Dokumentasi Lomba Paskibra','dokumentasi-lomba-paskibra',NULL,'kategori-1757236022.png','aktif',0,'2025-09-07 09:07:02','2025-09-07 09:07:02');
/*!40000 ALTER TABLE `kategori_galeri` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `keanggotaan_kelas`
--

DROP TABLE IF EXISTS `keanggotaan_kelas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `keanggotaan_kelas` (
  `kelas_id` bigint(20) unsigned NOT NULL,
  `siswa_id` bigint(20) unsigned NOT NULL,
  `tanggal_pendaftaran` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`kelas_id`,`siswa_id`),
  KEY `keanggotaan_kelas_siswa_id_foreign` (`siswa_id`),
  CONSTRAINT `keanggotaan_kelas_kelas_id_foreign` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`) ON DELETE CASCADE,
  CONSTRAINT `keanggotaan_kelas_siswa_id_foreign` FOREIGN KEY (`siswa_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `keanggotaan_kelas`
--

LOCK TABLES `keanggotaan_kelas` WRITE;
/*!40000 ALTER TABLE `keanggotaan_kelas` DISABLE KEYS */;
/*!40000 ALTER TABLE `keanggotaan_kelas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kecamatans`
--

DROP TABLE IF EXISTS `kecamatans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `kecamatans` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `kode` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `kode_kabupaten` varchar(255) NOT NULL,
  `lat` decimal(10,7) DEFAULT NULL,
  `lng` decimal(10,7) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `kecamatans_kode_unique` (`kode`),
  KEY `kecamatans_kode_kabupaten_foreign` (`kode_kabupaten`),
  CONSTRAINT `kecamatans_kode_kabupaten_foreign` FOREIGN KEY (`kode_kabupaten`) REFERENCES `kabupatens` (`kode`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kecamatans`
--

LOCK TABLES `kecamatans` WRITE;
/*!40000 ALTER TABLE `kecamatans` DISABLE KEYS */;
/*!40000 ALTER TABLE `kecamatans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kehadiran`
--

DROP TABLE IF EXISTS `kehadiran`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `kehadiran` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `kelas_id` bigint(20) unsigned NOT NULL,
  `siswa_id` bigint(20) unsigned NOT NULL,
  `tanggal` date DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `kehadiran_kelas_id_foreign` (`kelas_id`),
  KEY `kehadiran_siswa_id_foreign` (`siswa_id`),
  CONSTRAINT `kehadiran_kelas_id_foreign` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`) ON DELETE CASCADE,
  CONSTRAINT `kehadiran_siswa_id_foreign` FOREIGN KEY (`siswa_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kehadiran`
--

LOCK TABLES `kehadiran` WRITE;
/*!40000 ALTER TABLE `kehadiran` DISABLE KEYS */;
/*!40000 ALTER TABLE `kehadiran` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kehadiran_pegawai`
--

DROP TABLE IF EXISTS `kehadiran_pegawai`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `kehadiran_pegawai` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `pegawai_id` bigint(20) unsigned NOT NULL,
  `tanggal` date NOT NULL,
  `status` enum('hadir','izin','sakit','tanpa_keterangan') NOT NULL DEFAULT 'hadir',
  `jam_masuk` time DEFAULT NULL,
  `jam_keluar` time DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `kehadiran_pegawai_pegawai_id_tanggal_unique` (`pegawai_id`,`tanggal`),
  CONSTRAINT `kehadiran_pegawai_pegawai_id_foreign` FOREIGN KEY (`pegawai_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kehadiran_pegawai`
--

LOCK TABLES `kehadiran_pegawai` WRITE;
/*!40000 ALTER TABLE `kehadiran_pegawai` DISABLE KEYS */;
/*!40000 ALTER TABLE `kehadiran_pegawai` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kelas`
--

DROP TABLE IF EXISTS `kelas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `kelas` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `guru_id` bigint(20) unsigned DEFAULT NULL,
  `tahun_ajaran_id` bigint(20) unsigned DEFAULT NULL,
  `mata_pelajaran_id` bigint(20) unsigned DEFAULT NULL,
  `nama` varchar(255) NOT NULL,
  `kode_kelas` varchar(50) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `jenjang` varchar(10) DEFAULT NULL,
  `tingkat` tinyint(4) DEFAULT NULL,
  `tahun_ajaran` varchar(255) DEFAULT NULL,
  `semester` tinyint(4) DEFAULT NULL,
  `kapasitas_siswa` int(11) NOT NULL DEFAULT 30,
  `status` enum('aktif','non-aktif','selesai') NOT NULL DEFAULT 'aktif',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `kelas_kode_kelas_unique` (`kode_kelas`),
  KEY `kelas_guru_id_foreign` (`guru_id`),
  KEY `kelas_mata_pelajaran_id_foreign` (`mata_pelajaran_id`),
  KEY `kelas_tahun_ajaran_id_mata_pelajaran_id_status_index` (`tahun_ajaran_id`,`mata_pelajaran_id`,`status`),
  KEY `kelas_jenjang_tingkat_status_index` (`jenjang`,`tingkat`,`status`),
  CONSTRAINT `kelas_guru_id_foreign` FOREIGN KEY (`guru_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `kelas_mata_pelajaran_id_foreign` FOREIGN KEY (`mata_pelajaran_id`) REFERENCES `mata_pelajaran` (`id`) ON DELETE CASCADE,
  CONSTRAINT `kelas_tahun_ajaran_id_foreign` FOREIGN KEY (`tahun_ajaran_id`) REFERENCES `tahun_ajaran` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kelas`
--

LOCK TABLES `kelas` WRITE;
/*!40000 ALTER TABLE `kelas` DISABLE KEYS */;
/*!40000 ALTER TABLE `kelas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kelurahans`
--

DROP TABLE IF EXISTS `kelurahans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `kelurahans` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `kode` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `kode_kecamatan` varchar(255) NOT NULL,
  `lat` decimal(10,7) DEFAULT NULL,
  `lng` decimal(10,7) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `kelurahans_kode_unique` (`kode`),
  KEY `kelurahans_kode_kecamatan_foreign` (`kode_kecamatan`),
  CONSTRAINT `kelurahans_kode_kecamatan_foreign` FOREIGN KEY (`kode_kecamatan`) REFERENCES `kecamatans` (`kode`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kelurahans`
--

LOCK TABLES `kelurahans` WRITE;
/*!40000 ALTER TABLE `kelurahans` DISABLE KEYS */;
/*!40000 ALTER TABLE `kelurahans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kontak`
--

DROP TABLE IF EXISTS `kontak`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `kontak` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) NOT NULL,
  `jabatan` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `telepon` varchar(255) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `urutan` int(11) NOT NULL DEFAULT 0,
  `aktif` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kontak`
--

LOCK TABLES `kontak` WRITE;
/*!40000 ALTER TABLE `kontak` DISABLE KEYS */;
INSERT INTO `kontak` VALUES
(1,'Rivaldi','Guru','rivaldi@gmail.com','0895365441554','Jl. Sawo RT08/RW01 Kel. Balekambang, Kec. Kramat Jati',NULL,1,1,'2025-09-13 14:39:10','2025-09-13 14:39:10');
/*!40000 ALTER TABLE `kontak` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kuis`
--

DROP TABLE IF EXISTS `kuis`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `kuis` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `pembuat_id` bigint(20) unsigned NOT NULL,
  `judul` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `tipe` enum('pilihan_ganda','essay','campuran') NOT NULL DEFAULT 'pilihan_ganda',
  `jumlah_soal` int(11) NOT NULL DEFAULT 0,
  `nilai_maksimum` int(11) NOT NULL DEFAULT 100,
  `acak_soal` tinyint(1) NOT NULL DEFAULT 0,
  `tampilkan_hasil` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `kuis_pembuat_id_foreign` (`pembuat_id`),
  CONSTRAINT `kuis_pembuat_id_foreign` FOREIGN KEY (`pembuat_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kuis`
--

LOCK TABLES `kuis` WRITE;
/*!40000 ALTER TABLE `kuis` DISABLE KEYS */;
/*!40000 ALTER TABLE `kuis` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `log_aktivitas`
--

DROP TABLE IF EXISTS `log_aktivitas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `log_aktivitas` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `aktivitas` text DEFAULT NULL,
  `waktu` datetime DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `ip_address` varchar(255) DEFAULT NULL,
  `tipe` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `log_aktivitas_user_id_foreign` (`user_id`),
  CONSTRAINT `log_aktivitas_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=91 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `log_aktivitas`
--

LOCK TABLES `log_aktivitas` WRITE;
/*!40000 ALTER TABLE `log_aktivitas` DISABLE KEYS */;
INSERT INTO `log_aktivitas` VALUES
(1,NULL,'Memperbarui informasi sekolah admin_lms','2025-09-05 21:31:31','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36','127.0.0.1',NULL,'2025-09-05 14:31:31','2025-09-05 14:31:31'),
(2,NULL,'admin_lms memperbarui informasi sekolah','2025-09-05 21:33:23','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36','127.0.0.1',NULL,'2025-09-05 14:33:23','2025-09-05 14:33:23'),
(3,NULL,'admin_lms memperbarui informasi sekolah','2025-09-05 21:34:34','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36','127.0.0.1',NULL,'2025-09-05 14:34:34','2025-09-05 14:34:34'),
(4,NULL,'admin_lms memperbarui informasi sekolah','2025-09-05 22:11:12','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36','127.0.0.1',NULL,'2025-09-05 15:11:12','2025-09-05 15:11:12'),
(5,NULL,'admin_lms memperbarui informasi sekolah','2025-09-05 22:13:34','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36','127.0.0.1',NULL,'2025-09-05 15:13:34','2025-09-05 15:13:34'),
(6,NULL,'admin_lms Kategori artikel berhasil ditambahkan','2025-09-07 12:32:16','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36','127.0.0.1',NULL,'2025-09-07 05:32:16','2025-09-07 05:32:16'),
(7,NULL,'admin_lms Kategori artikel berhasil dihapus','2025-09-07 12:38:23','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36','127.0.0.1',NULL,'2025-09-07 05:38:23','2025-09-07 05:38:23'),
(8,NULL,'admin_lms Kategori artikel berhasil ditambahkan','2025-09-07 12:38:32','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36','127.0.0.1',NULL,'2025-09-07 05:38:32','2025-09-07 05:38:32'),
(9,NULL,'admin_lms Kategori artikel berhasil ditambahkan','2025-09-07 14:16:18','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36','127.0.0.1',NULL,'2025-09-07 07:16:18','2025-09-07 07:16:18'),
(10,NULL,'admin_lms Kategori artikel berhasil ditambahkan','2025-09-07 15:29:04','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36','127.0.0.1',NULL,'2025-09-07 08:29:04','2025-09-07 08:29:04'),
(11,NULL,'admin_lms Kategori artikel berhasil ditambahkan','2025-09-07 15:58:24','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36','127.0.0.1',NULL,'2025-09-07 08:58:24','2025-09-07 08:58:24'),
(12,NULL,'admin_lms Kategori artikel berhasil ditambahkan','2025-09-07 15:58:44','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36','127.0.0.1',NULL,'2025-09-07 08:58:44','2025-09-07 08:58:44'),
(13,NULL,'admin_lms memperbarui informasi sekolah','2025-09-13 14:06:37','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36','127.0.0.1',NULL,'2025-09-13 07:06:37','2025-09-13 07:06:37'),
(14,NULL,'admin_lms memperbarui informasi sekolah','2025-09-13 14:43:23','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36','127.0.0.1',NULL,'2025-09-13 07:43:23','2025-09-13 07:43:23'),
(15,NULL,'admin_lms SMPN 20 Jakarta Gelar Penyuluhan Pencegahan Anemia untuk Remaja berhasil dijadikan draft','2025-09-13 14:52:45','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36','127.0.0.1',NULL,'2025-09-13 07:52:45','2025-09-13 07:52:45'),
(16,NULL,'admin_lms SMPN 20 Jakarta Gelar Penyuluhan Pencegahan Anemia untuk Remaja berhasil dipublish','2025-09-13 14:52:53','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36','127.0.0.1',NULL,'2025-09-13 07:52:53','2025-09-13 07:52:53'),
(17,NULL,'admin_lms ahahhhaa berhasil dihapus','2025-09-13 14:53:00','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36','127.0.0.1',NULL,'2025-09-13 07:53:00','2025-09-13 07:53:00'),
(18,NULL,'admin_lms uhuy berhasil dijadikan draft','2025-09-13 14:53:07','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36','127.0.0.1',NULL,'2025-09-13 07:53:07','2025-09-13 07:53:07'),
(19,NULL,'admin_lms Menu berhasil ditambahkan','2025-09-13 16:31:10','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36','127.0.0.1',NULL,'2025-09-13 09:31:10','2025-09-13 09:31:10'),
(20,NULL,'admin_lms Menu berhasil ditambahkan','2025-09-13 16:31:42','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36','127.0.0.1',NULL,'2025-09-13 09:31:42','2025-09-13 09:31:42'),
(21,NULL,'admin_lms Menu berhasil ditambahkan','2025-09-13 16:32:08','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36','127.0.0.1',NULL,'2025-09-13 09:32:08','2025-09-13 09:32:08'),
(22,NULL,'admin_lms Menu berhasil ditambahkan','2025-09-13 16:32:25','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36','127.0.0.1',NULL,'2025-09-13 09:32:25','2025-09-13 09:32:25'),
(23,NULL,'admin_lms Menu berhasil ditambahkan','2025-09-13 16:34:23','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36','127.0.0.1',NULL,'2025-09-13 09:34:23','2025-09-13 09:34:23'),
(24,NULL,'admin_lms Menu berhasil ditambahkan','2025-09-13 16:34:51','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36','127.0.0.1',NULL,'2025-09-13 09:34:51','2025-09-13 09:34:51'),
(25,NULL,'admin_lms Menu berhasil diupdate','2025-09-13 16:35:03','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36','127.0.0.1',NULL,'2025-09-13 09:35:03','2025-09-13 09:35:03'),
(26,NULL,'admin_lms Menu berhasil ditambahkan','2025-09-13 16:35:37','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36','127.0.0.1',NULL,'2025-09-13 09:35:37','2025-09-13 09:35:37'),
(27,NULL,'admin_lms Menu berhasil ditambahkan','2025-09-13 16:36:13','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36','127.0.0.1',NULL,'2025-09-13 09:36:13','2025-09-13 09:36:13'),
(28,NULL,'admin_lms Menu berhasil diupdate','2025-09-13 16:36:22','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36','127.0.0.1',NULL,'2025-09-13 09:36:22','2025-09-13 09:36:22'),
(29,NULL,'admin_lms Menu berhasil ditambahkan','2025-09-13 20:31:53','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36','127.0.0.1',NULL,'2025-09-13 13:31:53','2025-09-13 13:31:53'),
(30,NULL,'admin_lms Social Media berhasil ditambahkan','2025-09-13 20:50:25','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36','127.0.0.1',NULL,'2025-09-13 13:50:25','2025-09-13 13:50:25'),
(31,NULL,'admin_lms Social Media berhasil diupdate','2025-09-13 21:18:40','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36','127.0.0.1',NULL,'2025-09-13 14:18:40','2025-09-13 14:18:40'),
(32,NULL,'admin_lms Social Media berhasil diupdate','2025-09-13 21:23:35','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36','127.0.0.1',NULL,'2025-09-13 14:23:35','2025-09-13 14:23:35'),
(33,NULL,'admin_lms Social Media berhasil ditambahkan','2025-09-13 21:24:31','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36','127.0.0.1',NULL,'2025-09-13 14:24:31','2025-09-13 14:24:31'),
(34,NULL,'admin_lms Kontak berhasil ditambahkan','2025-09-13 21:39:11','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36','127.0.0.1',NULL,'2025-09-13 14:39:11','2025-09-13 14:39:11'),
(35,NULL,'Inka Cornelia (Guru) Ubah profile','2025-09-13 21:47:18','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36','127.0.0.1',NULL,'2025-09-13 14:47:18','2025-09-13 14:47:18'),
(36,NULL,'Inka Cornelia (Guru) Ubah profile Inka Cornelia (Guru)','2025-09-13 21:49:01','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36','127.0.0.1',NULL,'2025-09-13 14:49:01','2025-09-13 14:49:01'),
(37,NULL,'Inka Cornelia (Guru) Ubah foto profile Inka Cornelia (Guru)','2025-09-13 21:49:40','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36','127.0.0.1',NULL,'2025-09-13 14:49:40','2025-09-13 14:49:40'),
(38,NULL,'admin_lms Hapus user','2025-09-14 08:54:39','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36','127.0.0.1',NULL,'2025-09-14 01:54:39','2025-09-14 01:54:39'),
(39,NULL,'admin_lms Hapus user','2025-09-14 08:55:01','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36','127.0.0.1',NULL,'2025-09-14 01:55:01','2025-09-14 01:55:01'),
(40,NULL,'admin_lms Hapus user','2025-09-14 08:55:06','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36','127.0.0.1',NULL,'2025-09-14 01:55:06','2025-09-14 01:55:06'),
(41,NULL,'admin_lms Hapus user','2025-09-14 08:55:11','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36','127.0.0.1',NULL,'2025-09-14 01:55:11','2025-09-14 01:55:11'),
(42,NULL,'admin_lms Hapus user','2025-09-14 08:55:16','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36','127.0.0.1',NULL,'2025-09-14 01:55:16','2025-09-14 01:55:16'),
(43,NULL,'admin_lms Hapus user yost.ceasar','2025-09-14 08:56:04','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36','127.0.0.1',NULL,'2025-09-14 01:56:04','2025-09-14 01:56:04'),
(44,NULL,'admin_lms Hapus user presley.schroeder','2025-09-14 08:56:35','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36','127.0.0.1',NULL,'2025-09-14 01:56:35','2025-09-14 01:56:35'),
(45,NULL,'admin_lms Buat user','2025-09-14 09:13:25','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36','127.0.0.1',NULL,'2025-09-14 02:13:25','2025-09-14 02:13:25'),
(46,NULL,'admin_lms Gagal buat user Consequatur Volupta siswa','2025-09-14 12:27:36','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36','127.0.0.1',NULL,'2025-09-14 05:27:36','2025-09-14 05:27:36'),
(47,NULL,'admin_lms Buat user Impedit laborum Co ','2025-09-14 12:29:44','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36','127.0.0.1',NULL,'2025-09-14 05:29:44','2025-09-14 05:29:44'),
(48,NULL,'admin_lms Hapus user schneider.abdul','2025-09-14 12:31:40','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36','127.0.0.1',NULL,'2025-09-14 05:31:40','2025-09-14 05:31:40'),
(49,NULL,'admin_lms Hapus user ltoy','2025-09-14 12:31:45','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36','127.0.0.1',NULL,'2025-09-14 05:31:45','2025-09-14 05:31:45'),
(50,NULL,'admin_lms Hapus user steuber.brandi','2025-09-14 12:31:49','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36','127.0.0.1',NULL,'2025-09-14 05:31:49','2025-09-14 05:31:49'),
(51,NULL,'admin_lms Buat user Agung ','2025-09-14 12:32:27','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36','127.0.0.1',NULL,'2025-09-14 05:32:27','2025-09-14 05:32:27'),
(52,NULL,'admin_lms Buat user Adipisci placeat et ','2025-09-14 12:34:51','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36','127.0.0.1',NULL,'2025-09-14 05:34:51','2025-09-14 05:34:51'),
(53,NULL,'admin_lms Buat user Maxime voluptatibus ','2025-09-14 12:36:34','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36','127.0.0.1',NULL,'2025-09-14 05:36:34','2025-09-14 05:36:34'),
(54,NULL,'admin_lms Buat user Veniam sit deserun ','2025-09-14 12:36:59','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36','127.0.0.1',NULL,'2025-09-14 05:36:59','2025-09-14 05:36:59'),
(55,NULL,'admin_lms Hapus user diego.ritchie','2025-09-14 12:39:42','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36','127.0.0.1',NULL,'2025-09-14 05:39:42','2025-09-14 05:39:42'),
(56,NULL,'admin_lms Hapus user lester39','2025-09-14 12:39:46','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36','127.0.0.1',NULL,'2025-09-14 05:39:46','2025-09-14 05:39:46'),
(57,NULL,'admin_lms Hapus user ncrist','2025-09-14 12:39:50','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36','127.0.0.1',NULL,'2025-09-14 05:39:50','2025-09-14 05:39:50'),
(58,NULL,'admin_lms Hapus user holden.hammes','2025-09-14 12:39:56','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36','127.0.0.1',NULL,'2025-09-14 05:39:56','2025-09-14 05:39:56'),
(60,NULL,'admin_lms Gagal hapus user','2025-09-14 12:39:57','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36','127.0.0.1',NULL,'2025-09-14 05:39:57','2025-09-14 05:39:57'),
(61,NULL,'admin_lms Hapus user rigoberto.mcclure','2025-09-14 12:40:00','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36','127.0.0.1',NULL,'2025-09-14 05:40:00','2025-09-14 05:40:00'),
(62,NULL,'admin_lms Hapus user reichel.johnny','2025-09-14 12:40:04','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36','127.0.0.1',NULL,'2025-09-14 05:40:04','2025-09-14 05:40:04'),
(63,NULL,'admin_lms Hapus user america65','2025-09-14 12:40:09','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36','127.0.0.1',NULL,'2025-09-14 05:40:09','2025-09-14 05:40:09'),
(64,NULL,'admin_lms Buat user Rivalda siswa','2025-09-14 12:40:42','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36','127.0.0.1',NULL,'2025-09-14 05:40:42','2025-09-14 05:40:42'),
(65,NULL,'admin_lms Buat user Aspri (Guru) siswa','2025-09-14 12:41:17','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36','127.0.0.1',NULL,'2025-09-14 05:41:17','2025-09-14 05:41:17'),
(66,NULL,'admin_lms Hapus user Aspri (Guru)','2025-09-14 12:42:10','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36','127.0.0.1',NULL,'2025-09-14 05:42:10','2025-09-14 05:42:10'),
(67,NULL,'admin_lms Buat user Ahmadd guru','2025-09-14 12:42:39','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36','127.0.0.1',NULL,'2025-09-14 05:42:39','2025-09-14 05:42:39'),
(68,NULL,'admin_lms Gagal ubah profile user','2025-09-14 12:56:21','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36','127.0.0.1',NULL,'2025-09-14 05:56:21','2025-09-14 05:56:21'),
(69,NULL,'admin_lms Gagal ubah profile user','2025-09-14 12:56:32','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36','127.0.0.1',NULL,'2025-09-14 05:56:32','2025-09-14 05:56:32'),
(70,NULL,'admin_lms Update user Rivalda Siswa','2025-09-14 13:04:06','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36','127.0.0.1',NULL,'2025-09-14 06:04:06','2025-09-14 06:04:06'),
(71,NULL,'admin_lms Update user Rivalda Siswa','2025-09-14 13:05:00','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36','127.0.0.1',NULL,'2025-09-14 06:05:00','2025-09-14 06:05:00'),
(72,NULL,'admin_lms Update user Rivalda Nih BOS Siswa','2025-09-14 13:06:11','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36','127.0.0.1',NULL,'2025-09-14 06:06:11','2025-09-14 06:06:11'),
(73,NULL,'admin_lms Update user bins.nettie Siswa','2025-09-14 13:10:45','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36','127.0.0.1',NULL,'2025-09-14 06:10:45','2025-09-14 06:10:45'),
(74,NULL,'admin_lms Update user Rivalda Nih BOS Siswa','2025-09-14 13:11:02','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36','127.0.0.1',NULL,'2025-09-14 06:11:02','2025-09-14 06:11:02'),
(75,NULL,'admin_lms Update user Rivalda Nih BOS Siswa','2025-09-14 13:12:08','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36','127.0.0.1',NULL,'2025-09-14 06:12:08','2025-09-14 06:12:08'),
(76,NULL,'admin_lms Update user Rivalda Nih BOS Siswa','2025-09-14 13:12:55','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36','127.0.0.1',NULL,'2025-09-14 06:12:55','2025-09-14 06:12:55'),
(77,NULL,'admin_lms Update user Rivalda Nih BOS Siswa','2025-09-14 13:13:17','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36','127.0.0.1',NULL,'2025-09-14 06:13:17','2025-09-14 06:13:17'),
(78,NULL,'admin_lms Hapus user mona91','2025-09-14 13:13:45','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36','127.0.0.1',NULL,'2025-09-14 06:13:45','2025-09-14 06:13:45'),
(79,NULL,'admin_lms Hapus user lehner.mckenna','2025-09-14 13:13:49','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36','127.0.0.1',NULL,'2025-09-14 06:13:49','2025-09-14 06:13:49'),
(80,NULL,'admin_lms Hapus user pfannerstill.kristofer','2025-09-14 13:13:55','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36','127.0.0.1',NULL,'2025-09-14 06:13:55','2025-09-14 06:13:55'),
(81,NULL,'admin_lms Hapus user raynor.ramiro','2025-09-14 13:14:00','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36','127.0.0.1',NULL,'2025-09-14 06:14:00','2025-09-14 06:14:00'),
(82,NULL,'admin_lms Berhasil hapus galeri','2025-09-14 13:52:46','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36','127.0.0.1',NULL,'2025-09-14 06:52:46','2025-09-14 06:52:46'),
(83,NULL,'admin_lms Berhasil hapus galeri','2025-09-14 13:53:00','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36','127.0.0.1',NULL,'2025-09-14 06:53:00','2025-09-14 06:53:00'),
(84,NULL,'admin_lms Berhasil upload galeri','2025-09-14 13:53:56','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36','127.0.0.1',NULL,'2025-09-14 06:53:56','2025-09-14 06:53:56'),
(85,NULL,'admin_lms Gagal ubah status galeri','2025-09-14 13:55:04','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36','127.0.0.1',NULL,'2025-09-14 06:55:04','2025-09-14 06:55:04'),
(86,NULL,'admin_lms Berhasil hapus galeri','2025-09-14 13:55:15','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36','127.0.0.1',NULL,'2025-09-14 06:55:15','2025-09-14 06:55:15'),
(87,NULL,'admin_lms Berhasil upload galeri','2025-09-14 13:55:29','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36','127.0.0.1',NULL,'2025-09-14 06:55:29','2025-09-14 06:55:29'),
(88,NULL,'admin_lms Gagal ubah status galeri','2025-09-14 13:55:34','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36','127.0.0.1',NULL,'2025-09-14 06:55:34','2025-09-14 06:55:34'),
(89,NULL,'admin_lms Gagal ubah status galeri','2025-09-14 13:55:43','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36','127.0.0.1',NULL,'2025-09-14 06:55:43','2025-09-14 06:55:43'),
(90,NULL,'admin_lms Berhasil ubah status galeri','2025-09-14 13:59:59','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36','127.0.0.1',NULL,'2025-09-14 06:59:59','2025-09-14 06:59:59');
/*!40000 ALTER TABLE `log_aktivitas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mata_pelajaran`
--

DROP TABLE IF EXISTS `mata_pelajaran`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `mata_pelajaran` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `kode` varchar(20) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `jenjang` enum('SD','SMP','SMA','SMK') DEFAULT NULL,
  `semester` int(11) DEFAULT NULL,
  `sks` int(11) NOT NULL DEFAULT 1,
  `urutan` int(11) NOT NULL DEFAULT 0,
  `aktif` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `mata_pelajaran_kode_unique` (`kode`),
  KEY `mata_pelajaran_jenjang_tingkat_is_active_index` (`jenjang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mata_pelajaran`
--

LOCK TABLES `mata_pelajaran` WRITE;
/*!40000 ALTER TABLE `mata_pelajaran` DISABLE KEYS */;
/*!40000 ALTER TABLE `mata_pelajaran` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `materi_kelas`
--

DROP TABLE IF EXISTS `materi_kelas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `materi_kelas` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `kelas_id` bigint(20) unsigned NOT NULL,
  `judul` varchar(255) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `tipe_materi` varchar(255) DEFAULT NULL,
  `path_file` varchar(255) NOT NULL,
  `diunggah_pada` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `materi_kelas_kelas_id_foreign` (`kelas_id`),
  CONSTRAINT `materi_kelas_kelas_id_foreign` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `materi_kelas`
--

LOCK TABLES `materi_kelas` WRITE;
/*!40000 ALTER TABLE `materi_kelas` DISABLE KEYS */;
/*!40000 ALTER TABLE `materi_kelas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menus`
--

DROP TABLE IF EXISTS `menus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `menus` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `order` int(11) NOT NULL DEFAULT 0,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menus`
--

LOCK TABLES `menus` WRITE;
/*!40000 ALTER TABLE `menus` DISABLE KEYS */;
INSERT INTO `menus` VALUES
(2,'Beranda','/beranda',NULL,NULL,0,1,'2025-09-13 09:31:09','2025-09-13 09:31:09'),
(3,'Artikel','#',NULL,NULL,1,1,'2025-09-13 09:31:41','2025-09-13 09:31:41'),
(4,'Pengumuman','/pengumuman',NULL,3,0,1,'2025-09-13 09:32:07','2025-09-13 09:32:07'),
(5,'Berita','/berita',NULL,3,1,1,'2025-09-13 09:32:25','2025-09-13 09:32:25'),
(6,'PPID','/ppid',NULL,NULL,3,1,'2025-09-13 09:34:22','2025-09-13 09:34:22'),
(7,'Lainnya','/lainnta',NULL,NULL,6,1,'2025-09-13 09:34:50','2025-09-13 09:36:21'),
(8,'Tentang','/tentang',NULL,NULL,4,1,'2025-09-13 09:35:36','2025-09-13 09:35:36'),
(9,'Galeri','/galeri',NULL,NULL,5,1,'2025-09-13 09:36:12','2025-09-13 09:36:12'),
(10,'Data Alumni','/alumni',NULL,7,1,1,'2025-09-13 13:31:52','2025-09-13 13:31:52');
/*!40000 ALTER TABLE `menus` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES
(1,'0001_01_01_000001_create_cache_table',1),
(2,'0001_01_01_000002_create_jobs_table',1),
(3,'2025_01_20_000000_cleanup_kelas_table',1),
(4,'2025_07_19_000444_create_roles_table',1),
(5,'2025_07_19_001118_create_personal_access_tokens_table',1),
(6,'2025_07_19_010439_create_sessions_table',1),
(7,'2025_07_26_092018_create_users_table',1),
(8,'2025_07_26_092934_create_wali_siswa_table',1),
(9,'2025_07_26_093332_create_kelas_table',1),
(10,'2025_07_26_093500_create_pengajar_table',1),
(11,'2025_07_26_093806_create_keanggotaan_kelas_table',1),
(12,'2025_07_26_093959_create_materi_kelas_table',1),
(13,'2025_07_26_094331_create_tugas_table',1),
(14,'2025_07_26_094406_create_pengumpulan_tugas_table',1),
(15,'2025_07_26_094558_create_nilai_table',1),
(16,'2025_07_26_094851_create_kehadiran_table',1),
(17,'2025_07_26_095051_create_pengumuman_sekolah_table',1),
(18,'2025_07_26_095129_create_percakapan_table',1),
(19,'2025_07_26_095157_create_peserta_percakapan_table',1),
(20,'2025_07_26_095314_create_pesan_table',1),
(21,'2025_07_26_095409_create_pengaturan_sistem_table',1),
(22,'2025_07_30_020044_create_permission_tables',1),
(23,'2025_08_04_000348_add_column_no_hp_to_user',1),
(24,'2025_08_04_115511_add_location_to_users_table',1),
(25,'2025_08_04_143626_create_provinsis_table',1),
(26,'2025_08_08_083101_create_artikel_table',1),
(27,'2025_08_10_141901_create_kategori_galeri_table',1),
(28,'2025_08_10_141908_create_galeri_table',1),
(29,'2025_08_10_145214_create_tahun_ajaran_table',1),
(30,'2025_08_10_145230_create_mata_pelajaran_table',1),
(31,'2025_08_10_145248_modify_kelas_table_add_relations',1),
(32,'2025_08_10_153732_create_jadwal_pelajaran_table',1),
(33,'2025_08_10_153800_create_nilai_siswa_table',1),
(34,'2025_08_15_000000_rename_nama_kelas_to_nama',1),
(35,'2025_08_17_221740_modify_mata_pelajaran_table',1),
(36,'2025_08_19_224348_add_column_to_users',1),
(37,'2025_08_20_000000_create_slideshow_table',1),
(38,'2025_08_20_061929_create_log_aktivitas_table',1),
(39,'2025_08_21_000000_create_kontak_table',1),
(40,'2025_08_21_000001_create_social_media_table',1),
(41,'2025_08_31_084754_create_informasi_sekolah_table',1),
(42,'2025_08_31_092123_create_halaman_table',1),
(43,'2025_08_31_140707_create_menus_table',1),
(44,'2025_09_01_000000_create_acara_akademik_table',1),
(45,'2025_09_01_000001_create_kehadiran_pegawai_table',1),
(46,'2025_09_01_000002_add_user_id_to_log_aktivitas_table',1),
(47,'2025_09_07_082839_add_slug_to_artikel_table',2),
(48,'2025_09_07_095908_add_favicon_to_informasi_sekolah_table',3),
(50,'2025_09_07_115902_kategori_artikel_controller',4),
(52,'2025_09_14_151751_create_kuis_table',5),
(53,'2025_09_14_151758_create_pertanyaan_kuis_table',6),
(54,'2025_09_14_151804_create_jawaban_kuis_table',7),
(55,'2025_09_14_151905_create_jawaban_siswa_kuis_table',8),
(56,'2025_09_14_151932_create_hasil_kuis_table',9);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_permissions`
--

DROP TABLE IF EXISTS `model_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_permissions`
--

LOCK TABLES `model_has_permissions` WRITE;
/*!40000 ALTER TABLE `model_has_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `model_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_roles`
--

DROP TABLE IF EXISTS `model_has_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_roles`
--

LOCK TABLES `model_has_roles` WRITE;
/*!40000 ALTER TABLE `model_has_roles` DISABLE KEYS */;
INSERT INTO `model_has_roles` VALUES
(1,'App\\Models\\User',1),
(2,'App\\Models\\User',2),
(3,'App\\Models\\User',3),
(4,'App\\Models\\User',4),
(2,'App\\Models\\User',6),
(2,'App\\Models\\User',7),
(2,'App\\Models\\User',8),
(3,'App\\Models\\User',20),
(3,'App\\Models\\User',21),
(3,'App\\Models\\User',26),
(3,'App\\Models\\User',27),
(3,'App\\Models\\User',28),
(3,'App\\Models\\User',31),
(3,'App\\Models\\User',32),
(3,'App\\Models\\User',35),
(3,'App\\Models\\User',36),
(3,'App\\Models\\User',37),
(3,'App\\Models\\User',38),
(3,'App\\Models\\User',39),
(3,'App\\Models\\User',40),
(3,'App\\Models\\User',41),
(3,'App\\Models\\User',42),
(3,'App\\Models\\User',43),
(3,'App\\Models\\User',44),
(3,'App\\Models\\User',45),
(3,'App\\Models\\User',46),
(3,'App\\Models\\User',47),
(3,'App\\Models\\User',48),
(3,'App\\Models\\User',49),
(3,'App\\Models\\User',50),
(3,'App\\Models\\User',51),
(3,'App\\Models\\User',52),
(3,'App\\Models\\User',53),
(3,'App\\Models\\User',54),
(3,'App\\Models\\User',55),
(3,'App\\Models\\User',56),
(3,'App\\Models\\User',57),
(3,'App\\Models\\User',58),
(3,'App\\Models\\User',59),
(3,'App\\Models\\User',60),
(3,'App\\Models\\User',61),
(3,'App\\Models\\User',62),
(3,'App\\Models\\User',63),
(4,'App\\Models\\User',65),
(4,'App\\Models\\User',66),
(4,'App\\Models\\User',67),
(4,'App\\Models\\User',68),
(4,'App\\Models\\User',69),
(4,'App\\Models\\User',70),
(4,'App\\Models\\User',71),
(4,'App\\Models\\User',72),
(4,'App\\Models\\User',73),
(4,'App\\Models\\User',74),
(4,'App\\Models\\User',75),
(4,'App\\Models\\User',76),
(4,'App\\Models\\User',77),
(4,'App\\Models\\User',78),
(4,'App\\Models\\User',79),
(4,'App\\Models\\User',80),
(4,'App\\Models\\User',81),
(4,'App\\Models\\User',82),
(4,'App\\Models\\User',83),
(4,'App\\Models\\User',84),
(4,'App\\Models\\User',85),
(4,'App\\Models\\User',86),
(4,'App\\Models\\User',87),
(4,'App\\Models\\User',88),
(4,'App\\Models\\User',89),
(4,'App\\Models\\User',90),
(4,'App\\Models\\User',91),
(4,'App\\Models\\User',92),
(4,'App\\Models\\User',93),
(4,'App\\Models\\User',94),
(4,'App\\Models\\User',95),
(4,'App\\Models\\User',96),
(4,'App\\Models\\User',97),
(4,'App\\Models\\User',98),
(4,'App\\Models\\User',99),
(4,'App\\Models\\User',100),
(4,'App\\Models\\User',101),
(4,'App\\Models\\User',102),
(4,'App\\Models\\User',103),
(4,'App\\Models\\User',104),
(3,'App\\Models\\User',111),
(2,'App\\Models\\User',113);
/*!40000 ALTER TABLE `model_has_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nilai`
--

DROP TABLE IF EXISTS `nilai`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `nilai` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `pengumpulan_id` bigint(20) unsigned NOT NULL,
  `penilai_id` bigint(20) unsigned DEFAULT NULL,
  `skor` decimal(5,2) NOT NULL,
  `umpan_balik` text DEFAULT NULL,
  `dinilai_pada` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `nilai_pengumpulan_id_foreign` (`pengumpulan_id`),
  KEY `nilai_penilai_id_foreign` (`penilai_id`),
  CONSTRAINT `nilai_pengumpulan_id_foreign` FOREIGN KEY (`pengumpulan_id`) REFERENCES `pengumpulan_tugas` (`id`) ON DELETE CASCADE,
  CONSTRAINT `nilai_penilai_id_foreign` FOREIGN KEY (`penilai_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nilai`
--

LOCK TABLES `nilai` WRITE;
/*!40000 ALTER TABLE `nilai` DISABLE KEYS */;
/*!40000 ALTER TABLE `nilai` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nilai_siswa`
--

DROP TABLE IF EXISTS `nilai_siswa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `nilai_siswa` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `siswa_id` bigint(20) unsigned NOT NULL,
  `mata_pelajaran_id` bigint(20) unsigned NOT NULL,
  `kelas_id` bigint(20) unsigned NOT NULL,
  `tahun_ajaran_id` bigint(20) unsigned NOT NULL,
  `semester` enum('ganjil','genap') NOT NULL,
  `jenis_nilai` enum('tugas','uts','uas','praktik','harian') NOT NULL,
  `nilai` decimal(5,2) NOT NULL,
  `bobot` decimal(3,2) NOT NULL DEFAULT 1.00,
  `keterangan` text DEFAULT NULL,
  `tanggal_penilaian` date NOT NULL,
  `guru_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nilai_unique` (`siswa_id`,`mata_pelajaran_id`,`kelas_id`,`tahun_ajaran_id`,`semester`,`jenis_nilai`),
  KEY `nilai_siswa_kelas_id_foreign` (`kelas_id`),
  KEY `nilai_siswa_tahun_ajaran_id_foreign` (`tahun_ajaran_id`),
  KEY `nilai_siswa_guru_id_foreign` (`guru_id`),
  KEY `nilai_siswa_siswa_id_tahun_ajaran_id_semester_index` (`siswa_id`,`tahun_ajaran_id`,`semester`),
  KEY `nilai_siswa_mata_pelajaran_id_kelas_id_index` (`mata_pelajaran_id`,`kelas_id`),
  CONSTRAINT `nilai_siswa_guru_id_foreign` FOREIGN KEY (`guru_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `nilai_siswa_kelas_id_foreign` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`) ON DELETE CASCADE,
  CONSTRAINT `nilai_siswa_mata_pelajaran_id_foreign` FOREIGN KEY (`mata_pelajaran_id`) REFERENCES `mata_pelajaran` (`id`) ON DELETE CASCADE,
  CONSTRAINT `nilai_siswa_siswa_id_foreign` FOREIGN KEY (`siswa_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `nilai_siswa_tahun_ajaran_id_foreign` FOREIGN KEY (`tahun_ajaran_id`) REFERENCES `tahun_ajaran` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nilai_siswa`
--

LOCK TABLES `nilai_siswa` WRITE;
/*!40000 ALTER TABLE `nilai_siswa` DISABLE KEYS */;
/*!40000 ALTER TABLE `nilai_siswa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pengajar`
--

DROP TABLE IF EXISTS `pengajar`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `pengajar` (
  `kelas_id` bigint(20) unsigned NOT NULL,
  `guru_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`kelas_id`,`guru_id`),
  KEY `pengajar_guru_id_foreign` (`guru_id`),
  CONSTRAINT `pengajar_guru_id_foreign` FOREIGN KEY (`guru_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `pengajar_kelas_id_foreign` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pengajar`
--

LOCK TABLES `pengajar` WRITE;
/*!40000 ALTER TABLE `pengajar` DISABLE KEYS */;
/*!40000 ALTER TABLE `pengajar` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pengaturan_sistem`
--

DROP TABLE IF EXISTS `pengaturan_sistem`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `pengaturan_sistem` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `kunci_pengaturan` varchar(100) NOT NULL,
  `nilai_pengaturan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pengaturan_sistem`
--

LOCK TABLES `pengaturan_sistem` WRITE;
/*!40000 ALTER TABLE `pengaturan_sistem` DISABLE KEYS */;
/*!40000 ALTER TABLE `pengaturan_sistem` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pengumpulan_tugas`
--

DROP TABLE IF EXISTS `pengumpulan_tugas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `pengumpulan_tugas` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tugas_id` bigint(20) unsigned NOT NULL,
  `siswa_id` bigint(20) unsigned NOT NULL,
  `path_file` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL,
  `waktu_pengumpulan` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pengumpulan_tugas_tugas_id_siswa_id_unique` (`tugas_id`,`siswa_id`),
  KEY `pengumpulan_tugas_siswa_id_foreign` (`siswa_id`),
  CONSTRAINT `pengumpulan_tugas_siswa_id_foreign` FOREIGN KEY (`siswa_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `pengumpulan_tugas_tugas_id_foreign` FOREIGN KEY (`tugas_id`) REFERENCES `tugas` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pengumpulan_tugas`
--

LOCK TABLES `pengumpulan_tugas` WRITE;
/*!40000 ALTER TABLE `pengumpulan_tugas` DISABLE KEYS */;
/*!40000 ALTER TABLE `pengumpulan_tugas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pengumuman_sekolah`
--

DROP TABLE IF EXISTS `pengumuman_sekolah`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `pengumuman_sekolah` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `pengirim_id` bigint(20) unsigned NOT NULL,
  `judul` varchar(255) NOT NULL,
  `isi` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pengumuman_sekolah_pengirim_id_foreign` (`pengirim_id`),
  CONSTRAINT `pengumuman_sekolah_pengirim_id_foreign` FOREIGN KEY (`pengirim_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pengumuman_sekolah`
--

LOCK TABLES `pengumuman_sekolah` WRITE;
/*!40000 ALTER TABLE `pengumuman_sekolah` DISABLE KEYS */;
/*!40000 ALTER TABLE `pengumuman_sekolah` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `percakapan`
--

DROP TABLE IF EXISTS `percakapan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `percakapan` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `judul_percakapan` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `percakapan`
--

LOCK TABLES `percakapan` WRITE;
/*!40000 ALTER TABLE `percakapan` DISABLE KEYS */;
/*!40000 ALTER TABLE `percakapan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `permissions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` text NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pertanyaan_kuis`
--

DROP TABLE IF EXISTS `pertanyaan_kuis`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `pertanyaan_kuis` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `kuis_id` bigint(20) unsigned NOT NULL,
  `pertanyaan` text NOT NULL,
  `tipe` enum('pilihan_ganda','essay') NOT NULL DEFAULT 'pilihan_ganda',
  `bobot_nilai` int(11) NOT NULL DEFAULT 1,
  `urutan` int(11) NOT NULL DEFAULT 0,
  `gambar` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pertanyaan_kuis_kuis_id_foreign` (`kuis_id`),
  CONSTRAINT `pertanyaan_kuis_kuis_id_foreign` FOREIGN KEY (`kuis_id`) REFERENCES `kuis` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pertanyaan_kuis`
--

LOCK TABLES `pertanyaan_kuis` WRITE;
/*!40000 ALTER TABLE `pertanyaan_kuis` DISABLE KEYS */;
/*!40000 ALTER TABLE `pertanyaan_kuis` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pesan`
--

DROP TABLE IF EXISTS `pesan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `pesan` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `percakapan_id` bigint(20) unsigned NOT NULL,
  `id_pengirim` bigint(20) unsigned NOT NULL,
  `isi_pesan` text DEFAULT NULL,
  `dikirim_pada` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pesan_percakapan_id_foreign` (`percakapan_id`),
  KEY `pesan_id_pengirim_foreign` (`id_pengirim`),
  CONSTRAINT `pesan_id_pengirim_foreign` FOREIGN KEY (`id_pengirim`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `pesan_percakapan_id_foreign` FOREIGN KEY (`percakapan_id`) REFERENCES `percakapan` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pesan`
--

LOCK TABLES `pesan` WRITE;
/*!40000 ALTER TABLE `pesan` DISABLE KEYS */;
/*!40000 ALTER TABLE `pesan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `peserta_percakapan`
--

DROP TABLE IF EXISTS `peserta_percakapan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `peserta_percakapan` (
  `percakapan_id` bigint(20) unsigned NOT NULL,
  `pengguna_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`percakapan_id`,`pengguna_id`),
  KEY `peserta_percakapan_pengguna_id_foreign` (`pengguna_id`),
  CONSTRAINT `peserta_percakapan_pengguna_id_foreign` FOREIGN KEY (`pengguna_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `peserta_percakapan_percakapan_id_foreign` FOREIGN KEY (`percakapan_id`) REFERENCES `percakapan` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `peserta_percakapan`
--

LOCK TABLES `peserta_percakapan` WRITE;
/*!40000 ALTER TABLE `peserta_percakapan` DISABLE KEYS */;
/*!40000 ALTER TABLE `peserta_percakapan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `provinsis`
--

DROP TABLE IF EXISTS `provinsis`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `provinsis` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `kode` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `lat` decimal(10,7) DEFAULT NULL,
  `lng` decimal(10,7) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `provinsis_kode_unique` (`kode`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `provinsis`
--

LOCK TABLES `provinsis` WRITE;
/*!40000 ALTER TABLE `provinsis` DISABLE KEYS */;
/*!40000 ALTER TABLE `provinsis` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role_has_permissions`
--

DROP TABLE IF EXISTS `role_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `role_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_has_permissions`
--

LOCK TABLES `role_has_permissions` WRITE;
/*!40000 ALTER TABLE `role_has_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `role_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES
(1,'Admin','web','2025-09-05 13:57:58','2025-09-05 13:57:58'),
(2,'Guru','web','2025-09-05 13:57:58','2025-09-05 13:57:58'),
(3,'Siswa','web','2025-09-05 13:57:58','2025-09-05 13:57:58'),
(4,'Wali Murid','web','2025-09-05 13:57:58','2025-09-05 13:57:58');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES
('v239Mu73cLHYQ55jyqFFouUAfqhv5WkptEN89nto',2,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36','YTo1OntzOjY6Il90b2tlbiI7czo0MDoiVjlPd3FHTDlqWlRQenNIcWNneUFQNXkxN1hnSmR5Qml5Q0gwbzhhYSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoyODoiaHR0cDovL2xtczIwLml0L2FkbWluL2tvbnRhayI7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjMxOiJodHRwOi8vbG1zMjAuaXQvYWRtaW4vZGFzaGJvYXJkIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6Mjt9',1757856069);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `slideshow`
--

DROP TABLE IF EXISTS `slideshow`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `slideshow` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `image` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `tombol_text` varchar(255) DEFAULT NULL,
  `urutan` int(11) NOT NULL DEFAULT 0,
  `aktif` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `slideshow`
--

LOCK TABLES `slideshow` WRITE;
/*!40000 ALTER TABLE `slideshow` DISABLE KEYS */;
INSERT INTO `slideshow` VALUES
(1,'landing/img/hero/1757791820.png','Haahahahahahhah','huhuuhuhuhu','https://google.com','Selengkapnya',1,1,'2025-09-13 19:30:20','2025-09-13 19:30:20');
/*!40000 ALTER TABLE `slideshow` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `social_media`
--

DROP TABLE IF EXISTS `social_media`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `social_media` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) NOT NULL,
  `icon` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `urutan` int(11) NOT NULL DEFAULT 0,
  `aktif` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `social_media`
--

LOCK TABLES `social_media` WRITE;
/*!40000 ALTER TABLE `social_media` DISABLE KEYS */;
INSERT INTO `social_media` VALUES
(1,'Instagram','social_media/1757773414_mahabb.png','https://instagram.com/smpn20',NULL,1,1,'2025-09-13 13:50:24','2025-09-13 14:23:34'),
(2,'TikTok','social_media/1757773471_scb_wisata.png','https://tiktok.com/smpn20.jakarta',NULL,2,1,'2025-09-13 14:24:31','2025-09-13 14:24:31');
/*!40000 ALTER TABLE `social_media` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tahun_ajaran`
--

DROP TABLE IF EXISTS `tahun_ajaran`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `tahun_ajaran` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(20) NOT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai` date NOT NULL,
  `status` enum('aktif','non-aktif') NOT NULL DEFAULT 'non-aktif',
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tahun_ajaran_status_tanggal_mulai_index` (`status`,`tanggal_mulai`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tahun_ajaran`
--

LOCK TABLES `tahun_ajaran` WRITE;
/*!40000 ALTER TABLE `tahun_ajaran` DISABLE KEYS */;
/*!40000 ALTER TABLE `tahun_ajaran` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tugas`
--

DROP TABLE IF EXISTS `tugas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `tugas` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `kelas_id` bigint(20) unsigned NOT NULL,
  `judul` varchar(255) NOT NULL,
  `instruksi` text DEFAULT NULL,
  `tenggat_waktu` timestamp NULL DEFAULT NULL,
  `tipe_tugas` enum('biasa','soal_online','ujian') NOT NULL DEFAULT 'biasa',
  `media_type` varchar(255) DEFAULT NULL,
  `media_url` varchar(255) DEFAULT NULL,
  `media_deskripsi` text DEFAULT NULL,
  `is_kuis` tinyint(1) NOT NULL DEFAULT 0,
  `kuis_id` bigint(20) unsigned DEFAULT NULL,
  `tampilkan_nilai` tinyint(1) NOT NULL DEFAULT 1,
  `waktu_mulai` timestamp NULL DEFAULT NULL,
  `waktu_selesai` timestamp NULL DEFAULT NULL,
  `durasi_menit` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tugas_kelas_id_foreign` (`kelas_id`),
  CONSTRAINT `tugas_kelas_id_foreign` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tugas`
--

LOCK TABLES `tugas` WRITE;
/*!40000 ALTER TABLE `tugas` DISABLE KEYS */;
/*!40000 ALTER TABLE `tugas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `jenis_kelamin` varchar(255) DEFAULT NULL,
  `tempat` varchar(255) DEFAULT NULL,
  `nisn` varchar(255) DEFAULT NULL,
  `asal_sekolah` varchar(255) DEFAULT NULL,
  `nama_orang_tua` varchar(255) DEFAULT NULL,
  `no_hp_orang_tua` varchar(255) DEFAULT NULL,
  `pekerjaan_orang_tua` varchar(255) DEFAULT NULL,
  `alamat_orang_tua` varchar(255) DEFAULT NULL,
  `no_hp` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `nama_lengkap` varchar(255) DEFAULT NULL,
  `foto_profile` varchar(255) DEFAULT NULL,
  `alamat` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `provinsi` varchar(255) DEFAULT NULL,
  `kota` varchar(255) DEFAULT NULL,
  `kecamatan` varchar(255) DEFAULT NULL,
  `kelurahan` varchar(255) DEFAULT NULL,
  `kodepos` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=114 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES
(1,'admin_lms','admin@lms.test',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$12$rf8KoXcAEzj3U7FBG0YSQe.4t1vnDTPWVtuSRtgxQG1x5zqPzn3OS','Admin Utama','profile-photo/yu1EdJHvQ7FBO1qdoAuQAhIZEug4nZK0jEnBBzIo.png',NULL,'2025-09-05 13:57:59','2025-09-13 14:03:24',NULL,NULL,NULL,NULL,NULL),
(2,'Inka Cornelia (Guru)','guru@lms.test',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'85156631893','$2y$12$byt.yYuPmyOcz5NxZl2.uOWF9e4Gn6bdkVfBQwe1Yyt1iifzyIWdu','Inka Corneliaaaa','profile-photo/oIw32fZXtmRonnVcRHfFHwvTuzwkkxwbOwPac0Fi.png','JL. Gintung','2025-09-05 13:57:59','2025-09-13 14:49:40',NULL,NULL,NULL,NULL,NULL),
(3,'siswa_tes','siswa@lms.test',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$12$ew44pO3MX0buSOrU2P/qO.IYnLIChvbJGqgtKk7pnSQaKvILbcHn2','Siti Siswa',NULL,NULL,'2025-09-05 13:57:59','2025-09-05 13:57:59',NULL,NULL,NULL,NULL,NULL),
(4,'wali_tes','wali@lms.test',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$12$6jQ8rNh3wshGMfa3D5TtM.Tk8rg5m1QdGVp/i7KMg/o67krZH4lC2','Rahmat Wali',NULL,NULL,'2025-09-05 13:57:59','2025-09-05 13:57:59',NULL,NULL,NULL,NULL,NULL),
(6,'baufderhar','bbogan@example.org',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$12$aOy2RbL5OPwwwfspfaajBuswnTjvQ4JRtKgM2llK022BysUb6J7h2','Dr. Lukas West',NULL,'91079 DuBuque Inlet Suite 718\nAdolphustown, IA 04873','2025-09-05 13:58:00','2025-09-05 13:58:00',NULL,NULL,NULL,NULL,NULL),
(7,'thuels','upton.dave@example.org',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$12$aOy2RbL5OPwwwfspfaajBuswnTjvQ4JRtKgM2llK022BysUb6J7h2','Gabriella Hermiston',NULL,'553 Beverly Courts\nSouth Filibertobury, NH 66222-9263','2025-09-05 13:58:00','2025-09-05 13:58:00',NULL,NULL,NULL,NULL,NULL),
(8,'laurence.quigley','hildegard.hyatt@example.org',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$12$aOy2RbL5OPwwwfspfaajBuswnTjvQ4JRtKgM2llK022BysUb6J7h2','Prof. Nicholaus Kiehn',NULL,'97844 Arnoldo Squares\nGutmannland, NY 30739','2025-09-05 13:58:00','2025-09-05 13:58:00',NULL,NULL,NULL,NULL,NULL),
(20,'hhilpert','treutel.aliya@example.com',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$12$aOy2RbL5OPwwwfspfaajBuswnTjvQ4JRtKgM2llK022BysUb6J7h2','Ara Emmerich',NULL,'976 Jillian Rapid\nSouth Mervinberg, SC 86016','2025-09-05 13:58:00','2025-09-05 13:58:00',NULL,NULL,NULL,NULL,NULL),
(21,'alejandra.steuber','carolyne48@example.net',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$12$aOy2RbL5OPwwwfspfaajBuswnTjvQ4JRtKgM2llK022BysUb6J7h2','Magnolia Kassulke',NULL,'596 Odie Court Suite 181\nBorisfurt, NC 37284-2017','2025-09-05 13:58:00','2025-09-05 13:58:00',NULL,NULL,NULL,NULL,NULL),
(26,'bins.nettie','shania.hodkiewicz@example.org',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$12$aOy2RbL5OPwwwfspfaajBuswnTjvQ4JRtKgM2llK022BysUb6J7h2','Tyson Parker',NULL,'333 Howell Way Suite 175\r\nSouth Georgiana, GA 64966-1776','2025-09-05 13:58:00','2025-09-14 06:10:45',NULL,NULL,NULL,NULL,'13530'),
(27,'wjenkins','yratke@example.com',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$12$aOy2RbL5OPwwwfspfaajBuswnTjvQ4JRtKgM2llK022BysUb6J7h2','Geo Veum DDS',NULL,'9633 Kristina Plains\nVandervortbury, CT 49338-6776','2025-09-05 13:58:00','2025-09-05 13:58:00',NULL,NULL,NULL,NULL,NULL),
(28,'lauriane.bosco','dorothea.jast@example.com',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$12$aOy2RbL5OPwwwfspfaajBuswnTjvQ4JRtKgM2llK022BysUb6J7h2','Kamren Stiedemann',NULL,'889 Wuckert Row Suite 534\nSouth Lexie, OH 88949-6772','2025-09-05 13:58:00','2025-09-05 13:58:00',NULL,NULL,NULL,NULL,NULL),
(31,'elta.gottlieb','jo06@example.com',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$12$aOy2RbL5OPwwwfspfaajBuswnTjvQ4JRtKgM2llK022BysUb6J7h2','Ramona Jast',NULL,'1402 Schulist Mount\nNew Brennan, MS 50355-8785','2025-09-05 13:58:00','2025-09-05 13:58:00',NULL,NULL,NULL,NULL,NULL),
(32,'bartell.lura','maegan.wilderman@example.org',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$12$aOy2RbL5OPwwwfspfaajBuswnTjvQ4JRtKgM2llK022BysUb6J7h2','Miss Sophie Hoppe DDS',NULL,'5237 McGlynn Roads Apt. 124\nNew Vladimirstad, CT 56553-5770','2025-09-05 13:58:00','2025-09-05 13:58:00',NULL,NULL,NULL,NULL,NULL),
(35,'lemke.abigayle','bergstrom.skylar@example.com',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$12$aOy2RbL5OPwwwfspfaajBuswnTjvQ4JRtKgM2llK022BysUb6J7h2','Mr. Nikko Bogan',NULL,'4288 Mills Valley Apt. 044\nNathenside, WA 86769-0289','2025-09-05 13:58:00','2025-09-05 13:58:00',NULL,NULL,NULL,NULL,NULL),
(36,'lemuel65','lisette71@example.org',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$12$aOy2RbL5OPwwwfspfaajBuswnTjvQ4JRtKgM2llK022BysUb6J7h2','Cleora Williamson I',NULL,'360 Marks Stream Apt. 711\nNorth Kale, ND 51588','2025-09-05 13:58:00','2025-09-05 13:58:00',NULL,NULL,NULL,NULL,NULL),
(37,'monique18','dbergnaum@example.com',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$12$aOy2RbL5OPwwwfspfaajBuswnTjvQ4JRtKgM2llK022BysUb6J7h2','Mr. Chaz Rosenbaum PhD',NULL,'42158 Swift Turnpike Apt. 162\nEast Francoview, IA 02797-1802','2025-09-05 13:58:00','2025-09-05 13:58:00',NULL,NULL,NULL,NULL,NULL),
(38,'bosco.estell','cnikolaus@example.net',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$12$aOy2RbL5OPwwwfspfaajBuswnTjvQ4JRtKgM2llK022BysUb6J7h2','Ubaldo Wilkinson',NULL,'720 Grant Loop\nEast Lilianmouth, IA 16092','2025-09-05 13:58:00','2025-09-05 13:58:00',NULL,NULL,NULL,NULL,NULL),
(39,'neal83','hermiston.pattie@example.org',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$12$aOy2RbL5OPwwwfspfaajBuswnTjvQ4JRtKgM2llK022BysUb6J7h2','Mrs. Alvera Dicki',NULL,'592 Theodora Tunnel\nSouth Kelvinville, NY 55395-0195','2025-09-05 13:58:00','2025-09-05 13:58:00',NULL,NULL,NULL,NULL,NULL),
(40,'tristin52','efrain16@example.net',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$12$aOy2RbL5OPwwwfspfaajBuswnTjvQ4JRtKgM2llK022BysUb6J7h2','Abraham Ebert',NULL,'71756 Berge Skyway\nNew Myron, CT 44223','2025-09-05 13:58:00','2025-09-05 13:58:00',NULL,NULL,NULL,NULL,NULL),
(41,'lindsey.weimann','rylan55@example.org',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$12$aOy2RbL5OPwwwfspfaajBuswnTjvQ4JRtKgM2llK022BysUb6J7h2','Dr. Jedidiah Leannon III',NULL,'18996 Jacobs View Apt. 794\nJazmynstad, AR 59796','2025-09-05 13:58:00','2025-09-05 13:58:00',NULL,NULL,NULL,NULL,NULL),
(42,'goyette.yessenia','clare.thiel@example.net',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$12$aOy2RbL5OPwwwfspfaajBuswnTjvQ4JRtKgM2llK022BysUb6J7h2','Henri Osinski',NULL,'482 Amira Cove Suite 577\nVirgieberg, MS 39647-2654','2025-09-05 13:58:00','2025-09-05 13:58:00',NULL,NULL,NULL,NULL,NULL),
(43,'jaydon72','ryley.osinski@example.net',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$12$aOy2RbL5OPwwwfspfaajBuswnTjvQ4JRtKgM2llK022BysUb6J7h2','Aurore Kuhlman',NULL,'9732 Helga Way Apt. 926\nMitchellfort, LA 33402-3534','2025-09-05 13:58:00','2025-09-05 13:58:00',NULL,NULL,NULL,NULL,NULL),
(44,'elva.lakin','geo00@example.com',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$12$aOy2RbL5OPwwwfspfaajBuswnTjvQ4JRtKgM2llK022BysUb6J7h2','Shirley Bergnaum',NULL,'13891 Arlie Shores Apt. 896\nAbelberg, NH 28535','2025-09-05 13:58:00','2025-09-05 13:58:00',NULL,NULL,NULL,NULL,NULL),
(45,'camylle.conroy','kelly.lang@example.net',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$12$aOy2RbL5OPwwwfspfaajBuswnTjvQ4JRtKgM2llK022BysUb6J7h2','Alexandrea Yost PhD',NULL,'7663 Cordie Junction\nNorth Sadye, DC 03226','2025-09-05 13:58:00','2025-09-05 13:58:00',NULL,NULL,NULL,NULL,NULL),
(46,'jheidenreich','ovolkman@example.org',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$12$aOy2RbL5OPwwwfspfaajBuswnTjvQ4JRtKgM2llK022BysUb6J7h2','Fanny Dibbert',NULL,'976 Kris Avenue\nBayerfort, ND 75580','2025-09-05 13:58:00','2025-09-05 13:58:00',NULL,NULL,NULL,NULL,NULL),
(47,'emelia03','stephany.steuber@example.net',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$12$aOy2RbL5OPwwwfspfaajBuswnTjvQ4JRtKgM2llK022BysUb6J7h2','Prof. Troy Daniel II',NULL,'88186 Oberbrunner Streets\nOsinskimouth, AL 07261-4773','2025-09-05 13:58:00','2025-09-05 13:58:00',NULL,NULL,NULL,NULL,NULL),
(48,'zackery.champlin','kbartoletti@example.net',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$12$aOy2RbL5OPwwwfspfaajBuswnTjvQ4JRtKgM2llK022BysUb6J7h2','Dr. Dane Sipes IV',NULL,'8099 Lang Spur\nNorth Arvelmouth, NJ 32908','2025-09-05 13:58:00','2025-09-05 13:58:00',NULL,NULL,NULL,NULL,NULL),
(49,'lmarks','liliana.morissette@example.com',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$12$aOy2RbL5OPwwwfspfaajBuswnTjvQ4JRtKgM2llK022BysUb6J7h2','Prof. Delfina O\'Keefe',NULL,'2848 Boyer Corners Apt. 518\nAndyside, MO 29866-4552','2025-09-05 13:58:00','2025-09-05 13:58:00',NULL,NULL,NULL,NULL,NULL),
(50,'otto.damore','kianna.metz@example.org',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$12$aOy2RbL5OPwwwfspfaajBuswnTjvQ4JRtKgM2llK022BysUb6J7h2','Dr. Rocio Gutmann IV',NULL,'669 Tevin Crest Apt. 119\nEast Colbyport, DC 29850','2025-09-05 13:58:00','2025-09-05 13:58:00',NULL,NULL,NULL,NULL,NULL),
(51,'jstroman','leffler.gaylord@example.net',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$12$aOy2RbL5OPwwwfspfaajBuswnTjvQ4JRtKgM2llK022BysUb6J7h2','Mr. Demario Leuschke PhD',NULL,'4821 Macejkovic Fords Suite 871\nWest Shanellehaven, NC 63230','2025-09-05 13:58:00','2025-09-05 13:58:00',NULL,NULL,NULL,NULL,NULL),
(52,'jones.spencer','stan.gerhold@example.net',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$12$aOy2RbL5OPwwwfspfaajBuswnTjvQ4JRtKgM2llK022BysUb6J7h2','Wayne Halvorson',NULL,'21619 Boyer Circle\nWest Jaymemouth, MI 36515-7826','2025-09-05 13:58:00','2025-09-05 13:58:00',NULL,NULL,NULL,NULL,NULL),
(53,'qvon','albertha.beatty@example.org',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$12$aOy2RbL5OPwwwfspfaajBuswnTjvQ4JRtKgM2llK022BysUb6J7h2','Brooklyn Padberg',NULL,'80380 Russel Shores Suite 499\nFaystad, WI 11490','2025-09-05 13:58:00','2025-09-05 13:58:00',NULL,NULL,NULL,NULL,NULL),
(54,'haag.katharina','cummerata.gene@example.net',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$12$aOy2RbL5OPwwwfspfaajBuswnTjvQ4JRtKgM2llK022BysUb6J7h2','Retta Padberg',NULL,'968 Sanford Station Suite 580\nSouth Jenniferberg, HI 87351','2025-09-05 13:58:00','2025-09-05 13:58:00',NULL,NULL,NULL,NULL,NULL),
(55,'dejah78','hgibson@example.com',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$12$aOy2RbL5OPwwwfspfaajBuswnTjvQ4JRtKgM2llK022BysUb6J7h2','Prof. Royal Moore',NULL,'8335 Langosh Summit\nLefflerport, MN 70507-9726','2025-09-05 13:58:00','2025-09-05 13:58:00',NULL,NULL,NULL,NULL,NULL),
(56,'amelie95','meda.jenkins@example.org',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$12$aOy2RbL5OPwwwfspfaajBuswnTjvQ4JRtKgM2llK022BysUb6J7h2','Eda Hermann',NULL,'9144 Marvin Ferry\nSouth Breannamouth, NH 41737','2025-09-05 13:58:00','2025-09-05 13:58:00',NULL,NULL,NULL,NULL,NULL),
(57,'kelton.stehr','vandervort.kiarra@example.com',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$12$aOy2RbL5OPwwwfspfaajBuswnTjvQ4JRtKgM2llK022BysUb6J7h2','Rasheed Schumm',NULL,'33798 Auer Key\nHilpertport, ID 29390-3508','2025-09-05 13:58:00','2025-09-05 13:58:00',NULL,NULL,NULL,NULL,NULL),
(58,'trosenbaum','xsenger@example.com',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$12$aOy2RbL5OPwwwfspfaajBuswnTjvQ4JRtKgM2llK022BysUb6J7h2','Alec Bradtke',NULL,'62072 Sawayn Fork Suite 678\nNorth Camilleburgh, HI 10739','2025-09-05 13:58:00','2025-09-05 13:58:00',NULL,NULL,NULL,NULL,NULL),
(59,'luettgen.brown','barrows.oran@example.com',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$12$aOy2RbL5OPwwwfspfaajBuswnTjvQ4JRtKgM2llK022BysUb6J7h2','Jaclyn Swift',NULL,'3655 Bernhard Hill\nWest Efrainmouth, ID 80363-0882','2025-09-05 13:58:00','2025-09-05 13:58:00',NULL,NULL,NULL,NULL,NULL),
(60,'qryan','nader.tate@example.net',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$12$aOy2RbL5OPwwwfspfaajBuswnTjvQ4JRtKgM2llK022BysUb6J7h2','Unique Hoeger',NULL,'43985 Royal Circle Suite 265\nNew Abigayleland, IA 51756','2025-09-05 13:58:00','2025-09-05 13:58:00',NULL,NULL,NULL,NULL,NULL),
(61,'rosanna35','quinten.hauck@example.org',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$12$aOy2RbL5OPwwwfspfaajBuswnTjvQ4JRtKgM2llK022BysUb6J7h2','Pearl Collins V',NULL,'925 Hessel Wall\nAndreanneview, SD 00701-2265','2025-09-05 13:58:00','2025-09-05 13:58:00',NULL,NULL,NULL,NULL,NULL),
(62,'mariana57','bianka.goodwin@example.org',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$12$aOy2RbL5OPwwwfspfaajBuswnTjvQ4JRtKgM2llK022BysUb6J7h2','Kale VonRueden',NULL,'1521 Elizabeth Summit\nNew Josefinashire, CT 62478-1622','2025-09-05 13:58:00','2025-09-05 13:58:00',NULL,NULL,NULL,NULL,NULL),
(63,'hahn.ursula','erin.graham@example.net',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$12$aOy2RbL5OPwwwfspfaajBuswnTjvQ4JRtKgM2llK022BysUb6J7h2','Dr. Jermey Leuschke V',NULL,'74480 Rhett Corner Apt. 101\nFeilmouth, NH 44630','2025-09-05 13:58:00','2025-09-05 13:58:00',NULL,NULL,NULL,NULL,NULL),
(65,'sierra84','zoie92@example.net',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$12$aOy2RbL5OPwwwfspfaajBuswnTjvQ4JRtKgM2llK022BysUb6J7h2','Bradly Steuber',NULL,'4067 Padberg Crossroad\nRuthtown, MD 28878-3125','2025-09-05 13:58:00','2025-09-05 13:58:00',NULL,NULL,NULL,NULL,NULL),
(66,'asha02','vbrekke@example.org',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$12$aOy2RbL5OPwwwfspfaajBuswnTjvQ4JRtKgM2llK022BysUb6J7h2','Mrs. Lisette Fisher III',NULL,'111 Shaniya Burg Apt. 773\nSouth Tom, MO 41211-0815','2025-09-05 13:58:00','2025-09-05 13:58:00',NULL,NULL,NULL,NULL,NULL),
(67,'osawayn','wava07@example.net',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$12$aOy2RbL5OPwwwfspfaajBuswnTjvQ4JRtKgM2llK022BysUb6J7h2','Angeline Schowalter',NULL,'92597 Mavis Ridge\nMaeganton, HI 42842-3517','2025-09-05 13:58:00','2025-09-05 13:58:00',NULL,NULL,NULL,NULL,NULL),
(68,'kirlin.willy','ella.waelchi@example.org',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$12$aOy2RbL5OPwwwfspfaajBuswnTjvQ4JRtKgM2llK022BysUb6J7h2','Prof. Ransom Sauer',NULL,'25173 Russel Pines Apt. 214\nHesselmouth, NY 84286-9576','2025-09-05 13:58:00','2025-09-05 13:58:00',NULL,NULL,NULL,NULL,NULL),
(69,'reichert.afton','ernestina.fisher@example.com',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$12$aOy2RbL5OPwwwfspfaajBuswnTjvQ4JRtKgM2llK022BysUb6J7h2','Susana Roob',NULL,'1427 Rosemarie Fall\nNorth Parkertown, NM 81883','2025-09-05 13:58:00','2025-09-05 13:58:00',NULL,NULL,NULL,NULL,NULL),
(70,'effertz.alicia','cathrine.lynch@example.com',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$12$aOy2RbL5OPwwwfspfaajBuswnTjvQ4JRtKgM2llK022BysUb6J7h2','Teresa Howe',NULL,'6288 Jalen Place Suite 914\nPort Odafort, AL 41621-7987','2025-09-05 13:58:00','2025-09-05 13:58:00',NULL,NULL,NULL,NULL,NULL),
(71,'dorris41','arlie.roberts@example.net',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$12$aOy2RbL5OPwwwfspfaajBuswnTjvQ4JRtKgM2llK022BysUb6J7h2','King Wiegand Sr.',NULL,'9913 Christ Tunnel Suite 967\nPort Margaretteborough, MS 16969','2025-09-05 13:58:00','2025-09-05 13:58:00',NULL,NULL,NULL,NULL,NULL),
(72,'torphy.kendra','patience12@example.com',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$12$aOy2RbL5OPwwwfspfaajBuswnTjvQ4JRtKgM2llK022BysUb6J7h2','Chelsie Marvin',NULL,'7591 Littel Spurs\nBruenshire, IA 27498-3442','2025-09-05 13:58:00','2025-09-05 13:58:00',NULL,NULL,NULL,NULL,NULL),
(73,'jayme.block','germaine.satterfield@example.com',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$12$aOy2RbL5OPwwwfspfaajBuswnTjvQ4JRtKgM2llK022BysUb6J7h2','Simeon Kub III',NULL,'2838 Kelli Drive\nEast Violetshire, KY 53143-8131','2025-09-05 13:58:00','2025-09-05 13:58:00',NULL,NULL,NULL,NULL,NULL),
(74,'zprice','bauch.johnathon@example.com',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$12$aOy2RbL5OPwwwfspfaajBuswnTjvQ4JRtKgM2llK022BysUb6J7h2','Gregorio Frami DDS',NULL,'700 Whitney Court\nNorth Joanne, AL 14609-0258','2025-09-05 13:58:00','2025-09-05 13:58:00',NULL,NULL,NULL,NULL,NULL),
(75,'brayan.shields','jamar57@example.org',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$12$aOy2RbL5OPwwwfspfaajBuswnTjvQ4JRtKgM2llK022BysUb6J7h2','Ms. Earlene Brekke V',NULL,'54385 Moshe Mountains Apt. 886\nPort Javierchester, RI 18890-5560','2025-09-05 13:58:00','2025-09-05 13:58:00',NULL,NULL,NULL,NULL,NULL),
(76,'niko.douglas','zaria22@example.com',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$12$aOy2RbL5OPwwwfspfaajBuswnTjvQ4JRtKgM2llK022BysUb6J7h2','Dr. Eldon Schuster Sr.',NULL,'9679 Collier Valley\nEwaldport, MO 26562','2025-09-05 13:58:00','2025-09-05 13:58:00',NULL,NULL,NULL,NULL,NULL),
(77,'lauren.macejkovic','wheller@example.org',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$12$aOy2RbL5OPwwwfspfaajBuswnTjvQ4JRtKgM2llK022BysUb6J7h2','Clint Mante',NULL,'3081 Lee Mews Suite 055\nHollyville, ID 01242','2025-09-05 13:58:00','2025-09-05 13:58:00',NULL,NULL,NULL,NULL,NULL),
(78,'rosenbaum.gretchen','carley.kemmer@example.com',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$12$aOy2RbL5OPwwwfspfaajBuswnTjvQ4JRtKgM2llK022BysUb6J7h2','Jasmin Ledner',NULL,'170 Eudora River\nPort Keeley, GA 34779-4362','2025-09-05 13:58:00','2025-09-05 13:58:00',NULL,NULL,NULL,NULL,NULL),
(79,'samanta11','lavinia.keebler@example.com',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$12$aOy2RbL5OPwwwfspfaajBuswnTjvQ4JRtKgM2llK022BysUb6J7h2','Talia Miller',NULL,'6214 Rowan Junction\nSpencermouth, WA 63720-7967','2025-09-05 13:58:00','2025-09-05 13:58:00',NULL,NULL,NULL,NULL,NULL),
(80,'dora.trantow','beulah84@example.net',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$12$aOy2RbL5OPwwwfspfaajBuswnTjvQ4JRtKgM2llK022BysUb6J7h2','Nils Huels',NULL,'61469 Koelpin Lodge\nCollinberg, SD 33927-9453','2025-09-05 13:58:00','2025-09-05 13:58:00',NULL,NULL,NULL,NULL,NULL),
(81,'gorczany.natalie','uhackett@example.net',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$12$aOy2RbL5OPwwwfspfaajBuswnTjvQ4JRtKgM2llK022BysUb6J7h2','Katarina Braun',NULL,'58301 Kulas Fall Apt. 322\nHerminiastad, CT 32629-2098','2025-09-05 13:58:00','2025-09-05 13:58:00',NULL,NULL,NULL,NULL,NULL),
(82,'white.reagan','rosemarie.luettgen@example.com',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$12$aOy2RbL5OPwwwfspfaajBuswnTjvQ4JRtKgM2llK022BysUb6J7h2','Prof. Cooper Beier',NULL,'1856 Pauline Valleys\nLefflerhaven, MO 01286-5160','2025-09-05 13:58:00','2025-09-05 13:58:00',NULL,NULL,NULL,NULL,NULL),
(83,'zstroman','gottlieb.terry@example.net',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$12$aOy2RbL5OPwwwfspfaajBuswnTjvQ4JRtKgM2llK022BysUb6J7h2','Luella Terry',NULL,'42313 Maribel Trace\nPort Lianaburgh, OR 36025','2025-09-05 13:58:00','2025-09-05 13:58:00',NULL,NULL,NULL,NULL,NULL),
(84,'grady.xander','jacinthe29@example.org',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$12$aOy2RbL5OPwwwfspfaajBuswnTjvQ4JRtKgM2llK022BysUb6J7h2','Alexandra Towne PhD',NULL,'382 Deckow Plain\nJammieton, AR 66193','2025-09-05 13:58:00','2025-09-05 13:58:00',NULL,NULL,NULL,NULL,NULL),
(85,'carter62','zritchie@example.org',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$12$aOy2RbL5OPwwwfspfaajBuswnTjvQ4JRtKgM2llK022BysUb6J7h2','Prof. Leilani Smitham',NULL,'64326 Graham Terrace\nJohnsonchester, NY 52274','2025-09-05 13:58:00','2025-09-05 13:58:00',NULL,NULL,NULL,NULL,NULL),
(86,'vbosco','annabelle66@example.com',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$12$aOy2RbL5OPwwwfspfaajBuswnTjvQ4JRtKgM2llK022BysUb6J7h2','Aiden Pfeffer',NULL,'797 Wilderman Walk\nPagachaven, LA 28729','2025-09-05 13:58:00','2025-09-05 13:58:00',NULL,NULL,NULL,NULL,NULL),
(87,'schiller.ressie','vrippin@example.net',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$12$aOy2RbL5OPwwwfspfaajBuswnTjvQ4JRtKgM2llK022BysUb6J7h2','Dereck McKenzie V',NULL,'761 Yasmine Overpass Apt. 867\nEast Filomena, MS 26629','2025-09-05 13:58:00','2025-09-05 13:58:00',NULL,NULL,NULL,NULL,NULL),
(88,'skuhn','toy.jaylen@example.org',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$12$aOy2RbL5OPwwwfspfaajBuswnTjvQ4JRtKgM2llK022BysUb6J7h2','Wava Walker',NULL,'13177 Nitzsche Plaza\nMatildetown, AL 89924','2025-09-05 13:58:00','2025-09-05 13:58:00',NULL,NULL,NULL,NULL,NULL),
(89,'easton95','balistreri.wilber@example.com',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$12$aOy2RbL5OPwwwfspfaajBuswnTjvQ4JRtKgM2llK022BysUb6J7h2','Allen Farrell Sr.',NULL,'9416 Rempel Club\nReynoldsberg, IN 53413','2025-09-05 13:58:00','2025-09-05 13:58:00',NULL,NULL,NULL,NULL,NULL),
(90,'torphy.conrad','dibbert.ari@example.org',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$12$aOy2RbL5OPwwwfspfaajBuswnTjvQ4JRtKgM2llK022BysUb6J7h2','Joanne Jaskolski V',NULL,'61825 Boehm Camp\nEast Maye, MN 50549-4696','2025-09-05 13:58:00','2025-09-05 13:58:00',NULL,NULL,NULL,NULL,NULL),
(91,'maddison89','santiago.pagac@example.org',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$12$aOy2RbL5OPwwwfspfaajBuswnTjvQ4JRtKgM2llK022BysUb6J7h2','Louie Stark',NULL,'67490 Davis Fords\nKuhnchester, ND 31349-6553','2025-09-05 13:58:00','2025-09-05 13:58:00',NULL,NULL,NULL,NULL,NULL),
(92,'hilda12','emmanuel.dare@example.net',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$12$aOy2RbL5OPwwwfspfaajBuswnTjvQ4JRtKgM2llK022BysUb6J7h2','Ms. Wanda Davis',NULL,'5911 Jamar Loaf Apt. 193\nSouth Roberto, WV 88422','2025-09-05 13:58:00','2025-09-05 13:58:00',NULL,NULL,NULL,NULL,NULL),
(93,'lexie.prohaska','kenyon.mohr@example.net',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$12$aOy2RbL5OPwwwfspfaajBuswnTjvQ4JRtKgM2llK022BysUb6J7h2','Mrs. Rosa McLaughlin',NULL,'4628 Tillman Dale Apt. 579\nLake Wilton, TN 11055','2025-09-05 13:58:00','2025-09-05 13:58:00',NULL,NULL,NULL,NULL,NULL),
(94,'lon.wisozk','jason.okon@example.net',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$12$aOy2RbL5OPwwwfspfaajBuswnTjvQ4JRtKgM2llK022BysUb6J7h2','Solon Friesen',NULL,'677 Goldner Unions\nSouth Jerrell, ND 60817','2025-09-05 13:58:00','2025-09-05 13:58:00',NULL,NULL,NULL,NULL,NULL),
(95,'giovani.witting','okris@example.org',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$12$aOy2RbL5OPwwwfspfaajBuswnTjvQ4JRtKgM2llK022BysUb6J7h2','Dr. Anastacio Kunde DDS',NULL,'99590 Schultz Roads Suite 647\nNew Jacintheport, DC 77234','2025-09-05 13:58:00','2025-09-05 13:58:00',NULL,NULL,NULL,NULL,NULL),
(96,'gbayer','beatty.karlie@example.net',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$12$aOy2RbL5OPwwwfspfaajBuswnTjvQ4JRtKgM2llK022BysUb6J7h2','Prof. Josh Bradtke DVM',NULL,'678 Korbin Plains Apt. 521\nNew Deshaun, WY 41389-6292','2025-09-05 13:58:00','2025-09-05 13:58:00',NULL,NULL,NULL,NULL,NULL),
(97,'kessler.shakira','ugrant@example.net',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$12$aOy2RbL5OPwwwfspfaajBuswnTjvQ4JRtKgM2llK022BysUb6J7h2','Brain Swaniawski',NULL,'59647 Rowan Port\nNewellshire, ND 89500','2025-09-05 13:58:00','2025-09-05 13:58:00',NULL,NULL,NULL,NULL,NULL),
(98,'cade.skiles','lorenz.feeney@example.com',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$12$aOy2RbL5OPwwwfspfaajBuswnTjvQ4JRtKgM2llK022BysUb6J7h2','Caden Will',NULL,'329 Dietrich Parkway\nPort Alecfurt, CA 41256','2025-09-05 13:58:00','2025-09-05 13:58:00',NULL,NULL,NULL,NULL,NULL),
(99,'marta.dickinson','alverta45@example.net',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$12$aOy2RbL5OPwwwfspfaajBuswnTjvQ4JRtKgM2llK022BysUb6J7h2','Denis McGlynn',NULL,'71261 Clarabelle Expressway Suite 982\nWest Ulises, FL 86819','2025-09-05 13:58:00','2025-09-05 13:58:00',NULL,NULL,NULL,NULL,NULL),
(100,'gregoria14','macejkovic.lynn@example.com',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$12$aOy2RbL5OPwwwfspfaajBuswnTjvQ4JRtKgM2llK022BysUb6J7h2','Dariana Hammes',NULL,'9491 Orlando Mountain\nEast Jodiefort, WI 09438-9404','2025-09-05 13:58:00','2025-09-05 13:58:00',NULL,NULL,NULL,NULL,NULL),
(101,'lharvey','russel67@example.org',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$12$aOy2RbL5OPwwwfspfaajBuswnTjvQ4JRtKgM2llK022BysUb6J7h2','Ms. Dena Kozey',NULL,'98862 Loyce Meadows Suite 329\nLake Simoneberg, OR 36683-4930','2025-09-05 13:58:00','2025-09-05 13:58:00',NULL,NULL,NULL,NULL,NULL),
(102,'amuller','brittany.mann@example.net',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$12$aOy2RbL5OPwwwfspfaajBuswnTjvQ4JRtKgM2llK022BysUb6J7h2','Natalia Trantow',NULL,'22117 Vaughn Forest\nPort Jaylon, MI 56911','2025-09-05 13:58:00','2025-09-05 13:58:00',NULL,NULL,NULL,NULL,NULL),
(103,'qjacobs','braxton51@example.org',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$12$aOy2RbL5OPwwwfspfaajBuswnTjvQ4JRtKgM2llK022BysUb6J7h2','Kaya Breitenberg',NULL,'6666 Bernhard Brooks Suite 325\nStoltenbergfurt, OR 97973','2025-09-05 13:58:00','2025-09-05 13:58:00',NULL,NULL,NULL,NULL,NULL),
(104,'adolfo.legros','ykuhlman@example.net',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$12$aOy2RbL5OPwwwfspfaajBuswnTjvQ4JRtKgM2llK022BysUb6J7h2','Kellen Lesch',NULL,'7889 Waylon Haven Apt. 137\nLake Evelynstad, KS 93687-0627','2025-09-05 13:58:00','2025-09-05 13:58:00',NULL,NULL,NULL,NULL,NULL),
(105,'Ahmad','ahmad@gmail.com',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'$2y$12$c9HKyKL6LgWzifB6iVzeLOWOfTztNgodbWFFVGWdboTAIm3rNmmF6',NULL,NULL,NULL,'2025-09-14 02:13:25','2025-09-14 02:13:25',NULL,NULL,NULL,NULL,NULL),
(106,'Impedit laborum Co','qodelo@mailinator.com',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Aut animi id dolore','$2y$12$l1z6g2hlW2o7taT80Vx2FOm5aZ6w0FU.OKukSwaHNuXPiKeb/m2Km',NULL,NULL,'Odio quia fugit mai','2025-09-14 05:29:44','2025-09-14 05:29:44',NULL,NULL,NULL,NULL,'Ad deserunt irure sa'),
(107,'Agung','xuxeduxygo@mailinator.com',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Dolore necessitatibu','$2y$12$HNUogqSGzj.hTg7fu/5Fau5md2aD4/r9Pt/aqwX173KzxA.TI0HDC',NULL,'profile/1757827947.png','Ut eiusmod dignissim','2025-09-14 05:32:27','2025-09-14 05:32:27',NULL,NULL,NULL,NULL,'13530'),
(108,'Adipisci placeat et','famefukel@mailinator.com',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Qui sint odit nisi u','$2y$12$Fsz7uXkVfspI/66obqEyhOmwT1qNEsuokL2hzq7SUhXaFr1363Vse',NULL,'profile/1757828091.png','Quo recusandae Even','2025-09-14 05:34:51','2025-09-14 05:34:51',NULL,NULL,NULL,NULL,'Ipsa aut autem vita'),
(109,'Maxime voluptatibus','bekalirovo@mailinator.com',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Assumenda voluptatem','$2y$12$j6W9/yG4j8qSnLshV2dM2e6fBPSViQC2Evn9BToSpUfDQ8j2aF0p2',NULL,'profile/1757828194.png','Facere laboriosam q','2025-09-14 05:36:34','2025-09-14 05:36:34',NULL,NULL,NULL,NULL,'Tempor eligendi modi'),
(110,'Veniam sit deserun','zakogys@mailinator.com',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Porro qui consequunt','$2y$12$S3Qg3CuufrQVkVr8OQNqTuo8L9xPkocKk1PDgVAVSCGSoH14Cyw76',NULL,'profile/1757828219.png','Velit optio dolori','2025-09-14 05:36:59','2025-09-14 05:36:59',NULL,NULL,NULL,NULL,'Deleniti sint volupt'),
(111,'Rivalda Nih BOS','rumopuqa@mailinator.com','2002-06-15','laki-laki',NULL,NULL,NULL,'Quaerat unde et obca','Sequi necessitatibus',NULL,NULL,'08239398235','$2y$12$eFXeS3QUjnGmA8VAbs/iPuLvWILOIVxpw2aD3rM1TdoBIGPNsObem','Corporis quisquam qu','profile/1757828442.png','Laudantium voluptat','2025-09-14 05:40:42','2025-09-14 06:13:17',NULL,NULL,NULL,NULL,'Nesciunt pariatur'),
(113,'Ahmadd','zowegyjuma@mailinator.com',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'Ex mollit excepturi','$2y$12$wh7PX/56nUfb4.f8fXIWHuk3rF3HcRpKJC1iACQEIvqPcoGYfYH0O',NULL,'profile/1757828559.png','Explicabo Numquam i','2025-09-14 05:42:39','2025-09-14 05:42:39',NULL,NULL,NULL,NULL,'Veritatis irure esse');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wali_siswa`
--

DROP TABLE IF EXISTS `wali_siswa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `wali_siswa` (
  `wali_id` bigint(20) unsigned NOT NULL,
  `siswa_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`wali_id`,`siswa_id`),
  KEY `wali_siswa_siswa_id_foreign` (`siswa_id`),
  CONSTRAINT `wali_siswa_siswa_id_foreign` FOREIGN KEY (`siswa_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `wali_siswa_wali_id_foreign` FOREIGN KEY (`wali_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wali_siswa`
--

LOCK TABLES `wali_siswa` WRITE;
/*!40000 ALTER TABLE `wali_siswa` DISABLE KEYS */;
/*!40000 ALTER TABLE `wali_siswa` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*M!100616 SET NOTE_VERBOSITY=@OLD_NOTE_VERBOSITY */;

-- Dump completed on 2025-09-14 20:42:42
