@extends('front.inc.master')
@section('title', 'Home')

{{-- ✅ Preload slider images — prevents delay on refresh --}}
@push('head')
  <link rel="preload" as="image" href="{{ asset('front-assets/assets/images/img1.jpg') }}">
  <link rel="preload" as="image" href="{{ asset('front-assets/assets/images/img2.jpg') }}">
  <link rel="preload" as="image" fetchpriority="high" href="https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?auto=format&fit=crop&w=1920&q=80">
@endpush

@section('content')

    <!-- ============================================================
         HERO SLIDER
         ============================================================ -->
    <section class="hero-section">
      <div id="clinicCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel">

        <div class="carousel-indicators">
          <button type="button" data-bs-target="#clinicCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
          <button type="button" data-bs-target="#clinicCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
          <button type="button" data-bs-target="#clinicCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>

        <div class="carousel-inner">

          {{-- Slide 1 --}}
          <div class="carousel-item active">
            <div class="hero-slide-content slide-1">
              <div class="overlay"></div>
              <div class="hero-text">
                <h1>Your Health, Our Priority</h1>
                <p>Browse our extensive catalog of healthcare services with detailed information and competitive prices.</p>
                <a href="{{ route('front.services.index') }}" class="book-btn">Browse Services</a>
              </div>
            </div>
          </div>

          {{-- Slide 2 --}}
          <div class="carousel-item">
            <div class="hero-slide-content slide-2">
              <div class="overlay"></div>
              <div class="hero-text">
                <h1>AI-Powered Assistance</h1>
                <p>Experience the future of healthcare with our smart AI chatbot. Instant answers to your medical inquiries 24/7.</p>
                <a href="#" class="book-btn">Try the Chatbot</a>
              </div>
            </div>
          </div>

          {{-- Slide 3 --}}
          <div class="carousel-item">
            <div class="hero-slide-content slide-3">
              <div class="overlay"></div>
              <div class="hero-text">
                <h1>Expert Consultations</h1>
                <p>Connect with professional doctors online. Secure, private, and convenient video consultations from your home.</p>
                <a href="{{ route('front.doctors') }}" class="book-btn">Find a Doctor</a>
              </div>
            </div>
          </div>

        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#clinicCarousel" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#clinicCarousel" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </button>

      </div>
    </section>

    <!-- ============================================================
         FEATURES
         ============================================================ -->
    <section class="pref-section-area" id="features">
      <div class="features-wrapper">
        <div class="pref-main-header" data-aos="fade-down">
          <h2 class="pref-title">Our Premium Features</h2>
          <p class="pref-subtitle">Modern healthcare tools — simple, fast, and always reliable.</p>
          <div class="pref-line-divider"></div>
        </div>

        <div class="pref-cards-flexbox">

          <div class="pref-single-card" data-aos="fade-up" data-aos-delay="0">
            <div class="pref-icon-container">
              <i class="fa-solid fa-stethoscope"></i>
            </div>
            <h3 class="pref-card-name">Services</h3>
            <p class="pref-card-info">Access a wide range of premium health services, consultations, diagnostics, and more with transparent pricing.</p>
            <a href="{{ route('front.services.index') }}" class="pref-action-btn">Explore Services</a>
          </div>

          <div class="pref-single-card" data-aos="fade-up" data-aos-delay="150">
            <div class="pref-icon-container">
              <i class="fa-solid fa-user-doctor"></i>
            </div>
            <h3 class="pref-card-name">Doctor Consultation</h3>
            <p class="pref-card-info">Talk or video chat with certified doctors anytime — secure, fast, and professional care at your fingertips.</p>
            <a href="{{ route('front.doctors') }}" class="pref-action-btn">Find Doctors</a>
          </div>

          <div class="pref-single-card" data-aos="fade-up" data-aos-delay="300">
            <div class="pref-icon-container">
              <i class="fa-solid fa-robot"></i>
            </div>
            <h3 class="pref-card-name">AI Assistant</h3>
            <p class="pref-card-info">Ask about symptoms, medications, or health tips — get quick, intelligent answers available 24/7.</p>
            <a href="#" class="pref-action-btn">Talk to AI</a>
          </div>

        </div>
      </div>
    </section>

    <!-- ============================================================
         SPECIALTIES
         ============================================================ -->
    <section class="maj-section-area" id="majors">
      <div class="maj-wrapper">
        <div class="maj-main-header" data-aos="fade-down">
          <h2 class="maj-title">Specialties</h2>
          <div class="maj-line-divider"></div>
          <p class="maj-subtitle">Explore our wide range of medical specialties, each staffed with experienced and certified professionals ready to serve you.</p>
        </div>

        <div class="maj-cards-container">
          @forelse ($majors as $major)
            <div class="maj-single-card" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
              <div class="maj-img-box">
                @if($major->image)
                  <img
                    src="{{ asset('images/majors/' . $major->image) }}"
                    alt="{{ $major->title }}"
                    loading="lazy"
                    onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                  />
                  <div class="maj-placeholder" style="display:none;">
                    <span class="maj-placeholder-letter">{{ strtoupper(substr($major->title, 0, 1)) }}</span>
                    <span class="maj-placeholder-name">{{ $major->title }}</span>
                  </div>
                @else
                  <div class="maj-placeholder">
                    <span class="maj-placeholder-letter">{{ strtoupper(substr($major->title, 0, 1)) }}</span>
                    <span class="maj-placeholder-name">{{ $major->title }}</span>
                  </div>
                @endif
                <div class="maj-overlay"></div>
              </div>
              <div class="maj-content">
                <h3 class="maj-card-name">{{ $major->title }}</h3>
                <p class="maj-card-desc">{{ \Illuminate\Support\Str::limit($major->description, 50) }}</p>
                <div class="maj-doctors-count">
                  <i class="fa-solid fa-user-doctor"></i>
                  <span>{{ $major->doctors->count() }} Doctor{{ $major->doctors->count() != 1 ? 's' : '' }}</span>
                </div>
                <a href="{{ route('front.major.show', $major->id) }}" class="maj-action-btn">View Doctors</a>
              </div>
            </div>
          @empty
            <div class="col-12 text-center py-5">
              <p class="text-muted">No specialties available right now.</p>
            </div>
          @endforelse

          <div class="spec-see-more-container">
            <a href="{{ route('front.majors') }}" class="spec-more-btn">
              View All Specialties <i class="fas fa-arrow-right"></i>
            </a>
          </div>
        </div>
      </div>
    </section>

    <!-- ============================================================
         SERVICES
         ============================================================ -->
    <section class="serv-section-area" id="services">
      <div class="serv-wrapper">
        <div class="serv-main-header" data-aos="fade-down">
          <h2 class="serv-title">Services</h2>
          <div class="serv-line-divider"></div>
          <p class="serv-subtitle">Discover our comprehensive suite of healthcare solutions designed to streamline operations, improve patient experience, and boost efficiency for modern healthcare practices.</p>
        </div>

        <div class="serv-cards-container">
          @forelse ($services as $service)
            <div class="serv-single-card" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
              <div class="serv-img-box">
                @if($service->image)
                  <img
                    src="{{ asset('storage/services/' . $service->image) }}"
                    alt="{{ $service->name }}"
                    loading="lazy"
                    onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                  />
                  <div class="serv-placeholder" style="display:none;">
                    <div class="serv-placeholder-icon"><i class="fa-solid fa-stethoscope"></i></div>
                    <span class="serv-placeholder-letter">{{ strtoupper(substr($service->name, 0, 1)) }}</span>
                    <span class="serv-placeholder-name">{{ $service->name }}</span>
                  </div>
                @else
                  <div class="serv-placeholder">
                    <div class="serv-placeholder-icon"><i class="fa-solid fa-stethoscope"></i></div>
                    <span class="serv-placeholder-letter">{{ strtoupper(substr($service->name, 0, 1)) }}</span>
                    <span class="serv-placeholder-name">{{ $service->name }}</span>
                  </div>
                @endif
              </div>
              <div class="serv-content">
                <div class="d-flex justify-content-between align-items-center mb-2">
                  <h5 class="card-title mb-0 fw-bold">{{ $service->name }}</h5>
                  <span class="badge bg-soft-primary fw-bold">{{ number_format($service->price, 2) }} EGP</span>
                </div>
                <p class="text-muted small mb-4">{{ \Illuminate\Support\Str::limit($service->description, 120) }}</p>
                <div class="serv-footer-btns">
                  <a href="#" class="btn btn-primary w-100 rounded-pill">Available Now</a>
                </div>
              </div>
            </div>
          @empty
            <div class="col-12 text-center py-5">
              <p class="text-muted">No services available right now.</p>
            </div>
          @endforelse
        </div>

        <div class="serv-see-more-container" data-aos="fade-up">
          <a href="{{ route('front.services.index') }}" class="serv-more-btn">
            See More Services <i class="fa-solid fa-arrow-right-long"></i>
          </a>
        </div>
      </div>
    </section>

    <!-- ============================================================
         DOCTORS
         ============================================================ -->
    <section class="doc-section-area" id="doctors">
      <div class="doc-wrapper">
        <div class="doc-main-header" data-aos="fade-down">
          <h2 class="doc-title">Doctors</h2>
          <div class="doc-line-divider"></div>
          <p class="doc-subtitle">Connect with our team of highly qualified medical professionals for personalized consultations and expert care.</p>
        </div>

        <div class="doc-cards-container">
          @forelse ($doctors as $doctor)
            <div class="doc-single-card" data-aos="zoom-in" data-aos-delay="{{ $loop->index * 100 }}">

              <div class="doc-avatar-box">
                @if($doctor->image)
                  <img
                    src="{{ asset('images/doctors/' . $doctor->image) }}"
                    alt="Dr. {{ $doctor->user->name }}"
                    loading="lazy"
                    onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                  />
                  <div class="doc-avatar-placeholder" style="display:none;">
                    {{ strtoupper(substr($doctor->user->name, 0, 2)) }}
                  </div>
                @else
                  <div class="doc-avatar-placeholder">
                    {{ strtoupper(substr($doctor->user->name, 0, 2)) }}
                  </div>
                @endif
              </div>

              <div class="doc-info">
                <h3 class="doc-name">Dr. {{ $doctor->user->name }}</h3>
                <div class="doc-contact-info">
                  <span><i class="fa-solid fa-envelope"></i> {{ $doctor->user->email }}</span>
                  <span><i class="fa-solid fa-phone"></i> {{ $doctor->user->phone }}</span>
                </div>
                <span class="doc-specialty">{{ $doctor->major->title }}</span>
                <h4 class="doc-price">Appointment: {{ number_format($doctor->consultation_fee, 2) }} EGP</h4>
                <div class="doc-rating">
                  @for ($i = 1; $i <= 5; $i++)
                    <i class="fa {{ $i <= 4 ? 'fa-solid' : 'fa-regular' }} fa-star"></i>
                  @endfor
                </div>
                <div class="doc-action-footer">
                  <a href="{{ route('front.booking.create', $doctor->id) }}" class="doc-book-btn">
                    <i class="fa-regular fa-calendar-check"></i> Book Now
                  </a>
                  <a href="{{ route('front.doctor.show', $doctor->id) }}" class="doc-chat-btn">
                    <i class="fa-regular fa-user"></i> Profile
                  </a>
                </div>
              </div>

            </div>
          @empty
            <div class="col-12 text-center py-5">
              <p class="text-muted">No doctors available at the moment.</p>
            </div>
          @endforelse
        </div>

        <div class="doc-see-more-container" data-aos="fade-up">
          <a href="{{ route('front.doctors') }}" class="doc-more-btn">
            View All Doctors <i class="fa-solid fa-arrow-right-long"></i>
          </a>
        </div>
      </div>
    </section>

    <!-- ============================================================
         FLOATING BUTTONS — WhatsApp + AI Chatbot
         ============================================================ -->
    <div class="floating-socials">

      {{-- WhatsApp --}}
      <a
        href="https://wa.me/201XXXXXXXXX"
        class="float-btn float-btn--whatsapp"
        target="_blank"
        rel="noopener noreferrer"
        data-tip="WhatsApp"
        aria-label="Contact us on WhatsApp"
      >
        <span class="pulse-ring"></span>
        <i class="fa-brands fa-whatsapp"></i>
      </a>

      {{-- AI Chatbot --}}
      <a
        href="#"
        class="float-btn float-btn--chatbot"
        data-tip="AI Assistant"
        aria-label="Chat with our AI Assistant"
      >
        <span class="pulse-ring"></span>
        <i class="fa-solid fa-robot"></i>
      </a>

    </div>

@endsection