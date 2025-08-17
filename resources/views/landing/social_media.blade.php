<!-- Social Media Section -->
<section class="social-media-section py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <h2 class="section-title mb-4">Ikuti Kami</h2>
                <p class="section-subtitle mb-5">Tetap terhubung dengan kami melalui media sosial</p>
                
                @if(isset($socialMedia) && count($socialMedia) > 0)
                    <div class="social-media-links">
                        @foreach($socialMedia as $item)
                            @if($item['aktif'] ?? true)
                                <a href="{{ $item['link'] }}" 
                                   target="_blank" 
                                   class="social-media-link" 
                                   title="{{ $item['nama'] }}{{ $item['deskripsi'] ? ' - ' . $item['deskripsi'] : '' }}">
                                    <div class="social-icon">
                                        <i class="{{ $item['icon'] }}"></i>
                                    </div>
                                    <span class="social-name">{{ $item['nama'] }}</span>
                                </a>
                            @endif
                        @endforeach
                    </div>
                @else
                    <div class="social-media-links">
                        <a href="https://facebook.com/sekolah" target="_blank" class="social-media-link" title="Facebook Sekolah">
                            <div class="social-icon">
                                <i class="fab fa-facebook-f"></i>
                            </div>
                            <span class="social-name">Facebook</span>
                        </a>
                        <a href="https://instagram.com/sekolah" target="_blank" class="social-media-link" title="Instagram Sekolah">
                            <div class="social-icon">
                                <i class="fab fa-instagram"></i>
                            </div>
                            <span class="social-name">Instagram</span>
                        </a>
                        <a href="https://youtube.com/sekolah" target="_blank" class="social-media-link" title="YouTube Sekolah">
                            <div class="social-icon">
                                <i class="fab fa-youtube"></i>
                            </div>
                            <span class="social-name">YouTube</span>
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

<style>
.social-media-section {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.section-title {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 1rem;
}

.section-subtitle {
    font-size: 1.1rem;
    opacity: 0.9;
    margin-bottom: 3rem;
}

.social-media-links {
    display: flex;
    justify-content: center;
    align-items: center;
    flex-wrap: wrap;
    gap: 2rem;
}

.social-media-link {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-decoration: none;
    color: white;
    transition: all 0.3s ease;
    padding: 1rem;
    border-radius: 15px;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    min-width: 120px;
}

.social-media-link:hover {
    color: white;
    transform: translateY(-5px);
    background: rgba(255, 255, 255, 0.2);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
}

.social-icon {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.2);
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 0.5rem;
    transition: all 0.3s ease;
}

.social-icon i {
    font-size: 1.5rem;
}

.social-media-link:hover .social-icon {
    background: rgba(255, 255, 255, 0.3);
    transform: scale(1.1);
}

.social-name {
    font-size: 0.9rem;
    font-weight: 600;
    text-align: center;
}

/* Responsive Design */
@media (max-width: 768px) {
    .section-title {
        font-size: 2rem;
    }
    
    .social-media-links {
        gap: 1rem;
    }
    
    .social-media-link {
        min-width: 100px;
        padding: 0.8rem;
    }
    
    .social-icon {
        width: 50px;
        height: 50px;
    }
    
    .social-icon i {
        font-size: 1.2rem;
    }
}

@media (max-width: 576px) {
    .social-media-links {
        justify-content: center;
    }
    
    .social-media-link {
        flex: 0 0 calc(50% - 0.5rem);
        max-width: calc(50% - 0.5rem);
    }
}
</style>