@php
    $informasiSekolah = \App\Models\InformasiSekolah::first();
@endphp
<footer class="footer-wrapper footer-layout2" style="background-color: #0D3D91;">
    <div class="widget-area pt-7 pb-7">
        <div class="container">
            <div class="row justify-content-between">
                <div class="col-md-4">
                    <div class="widget footer-widget">
                        <div class="mb-2">
                            <img src="{{ asset('img/Logo-SMPN20-white.png') }}" alt="Logo Sekolah" class="footer-logo me-3 mb-15" style="width: 200px; height: auto;">
                        </div>
                        <p class="footer-text text-white">{{ $informasiSekolah->tagline ?? '' }}</p>
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
                        <h3 class="widget_title text-white">Kontak Kami</h3>
                        <ul class="contact-list list-unstyled">
                            <li class="d-flex text-white mb-3">
                                <i class="fas fa-map-marker-alt me-3 mt-1"></i>
                                <span>{{ $informasiSekolah->alamat ?? '' }}</span>
                            </li>
                            <li class="d-flex text-white mb-3">
                                <i class="fas fa-phone-alt me-3 mt-1"></i>
                                <span>Telp/Fax : {{ $informasiSekolah->nomor_telepon ?? '' }}</span>
                            </li>
                            <li class="d-flex text-white mb-3">
                                <i class="fas fa-mobile-alt me-3 mt-1"></i>
                                <span>HP : {{ $informasiSekolah->nomor_handphone ?? '' }}</span>
                            </li>
                            <li class="d-flex text-white">
                                <i class="fas fa-envelope me-3 mt-1"></i>
                                <span>Email : {{ $informasiSekolah->email ?? '' }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="widget footer-widget">
                        <h3 class="widget_title text-white">Informasi Lainnya</h3>
                        <ul class="footer-links list-unstyled">
                            <li class="mb-2"><a href="{{url('halaman/sejarah')}}" class="text-white">Sejarah</a></li>
                            <li class="mb-2"><a href="{{url('halaman/visi-misi')}}" class="text-white">Visi dan Misi</a></li>
                            <li class="mb-2"><a href="{{url('halaman/struktur-akademik')}}" class="text-white">Struktur Akademik</a></li>
                            <li class="mb-2"><a href="{{url('halaman/struktur-teknik')}}" class="text-white">Struktur Teknik</a></li>
                            <li class="mb-2"><a href="{{url('halaman/struktur-komite')}}" class="text-white">Struktur Komite</a></li>
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
                    <p class="copyright-text text-white mb-0">© {{ date('Y') }} | {{ $informasiSekolah->nama_sekolah ?? '' }}</p>
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- Scroll To Top -->
<a href="#" class="scrollToTop scroll-btn"><i class="far fa-arrow-up"></i></a>