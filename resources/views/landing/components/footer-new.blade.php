<!--============================== Footer Area ==============================-->
@php
    $informasiSekolah = \App\Models\InformasiSekolah::first();
@endphp
<footer class="footer-wrapper footer-layout2" style="background-color: #0D3D91;">
    <div class="widget-area pt-7 pb-7">
        <div class="container">
            <div class="row justify-content-between">
                <div class="col-md-4">
                    <div class="widget footer-widget">
                        <div class="d-flex align-items-center mb-4">
                            <img src="{{ asset('img/' . ($informasiSekolah->logo ?? 'Logo-SMPN20.png')) }}" alt="Logo Sekolah" class="footer-logo me-3" style="width: 60px; height: auto;">
                            <h3 class="widget_title text-white mb-0">{{ $informasiSekolah->nama_sekolah ?? 'SMP NEGERI 20 JAKARTA' }}</h3>
                        </div>
                        <p class="footer-text text-white">{{ $informasiSekolah->tagline ?? 'Mewujudkan mutu lulusan yang berkarakter, Berprestasi, dan Berkompetitif' }}</p>
                        <div class="social-links mt-4">
                            <a href="#" class="social-link"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                            <a href="#" class="social-link"><i class="fab fa-youtube"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="widget footer-widget">
                        <h3 class="widget_title text-white">KONTAK KAMI</h3>
                        <ul class="contact-list list-unstyled">
                            <li class="d-flex text-white mb-3">
                                <i class="fas fa-map-marker-alt me-3 mt-1"></i>
                                <span>{{ $informasiSekolah->alamat ?? 'Jl. Taman Sari Raya No.25, RT.2/RW.3, Kota Bambu Sel., Kecamatan Palmerah, Kota Jakarta Barat, DKI Jakarta 11420' }}</span>
                            </li>
                            <li class="d-flex text-white mb-3">
                                <i class="fas fa-phone-alt me-3 mt-1"></i>
                                <span>Telp/Fax : {{ $informasiSekolah->nomor_telepon ?? '(021) 5600422' }}</span>
                            </li>
                            <li class="d-flex text-white mb-3">
                                <i class="fas fa-mobile-alt me-3 mt-1"></i>
                                <span>HP : {{ $informasiSekolah->nomor_handphone ?? '081234567890' }}</span>
                            </li>
                            <li class="d-flex text-white">
                                <i class="fas fa-envelope me-3 mt-1"></i>
                                <span>Email : {{ $informasiSekolah->email ?? 'smpn20jakarta@gmail.com' }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="widget footer-widget">
                        <h3 class="widget_title text-white">PROFIL</h3>
                        <ul class="footer-links list-unstyled">
                            <li class="mb-2"><a href="#" class="text-white">Sejarah</a></li>
                            <li class="mb-2"><a href="#" class="text-white">Visi dan Misi</a></li>
                            <li class="mb-2"><a href="#" class="text-white">Struktur Akademik</a></li>
                            <li class="mb-2"><a href="#" class="text-white">Struktur Teknik</a></li>
                            <li><a href="#" class="text-white">Struktur Komite</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="copyright-wrap border-top border-white border-opacity-25 py-3">
        <div class="container">
            <div class="row justify-content-center align-items-center">
                <div class="text-center col-lg-auto">
                    <p class="copyright-text text-white mb-0">© {{ date('Y') }} | {{ $informasiSekolah->nama_sekolah ?? 'SMP Negeri 20 Jakarta' }}</p>
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- Scroll To Top -->
<a href="#" class="scrollToTop scroll-btn"><i class="far fa-arrow-up"></i></a>