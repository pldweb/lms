<section class="contact-section section-padding" id="section_6">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-12 text-center mb-4">
                <h2>Kontak Kami</h2>
            </div>

            @foreach($kontak as $item)
            <div class="col-lg-4 col-md-6 col-12 mb-4 mb-lg-0">
                <div class="contact-info-wrap">
                    <div class="contact-info">
                        <div class="contact-info-item">
                            <div class="contact-info-icon">
                                <i class="{{ $item['icon'] }}"></i>
                            </div>
                            
                            <div class="contact-info-text">
                                <h5>{{ $item['nama'] }}</h5>
                                @if(!empty($item['jabatan']))
                                <p><strong>{{ $item['jabatan'] }}</strong></p>
                                @endif
                                
                                @if(!empty($item['alamat']))
                                <p><i class="fas fa-map-marker-alt me-2"></i> {{ $item['alamat'] }}</p>
                                @endif
                                
                                @if(!empty($item['email']))
                                <p><i class="fas fa-envelope me-2"></i> <a href="mailto:{{ $item['email'] }}">{{ $item['email'] }}</a></p>
                                @endif
                                
                                @if(!empty($item['telepon']))
                                <p><i class="fas fa-phone me-2"></i> <a href="tel:{{ $item['telepon'] }}">{{ $item['telepon'] }}</a></p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>