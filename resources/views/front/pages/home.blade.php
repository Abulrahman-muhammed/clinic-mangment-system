@extends('front.inc.master')
@section('title', 'Home')
@section('content')


    <!-- hero -->
    <section class="hero-section">
      <div
        id="clinicCarousel"
        class="carousel slide carousel-fade"
        data-bs-ride="carousel"
      >
        <div class="carousel-indicators">
          <button
            type="button"
            data-bs-target="#clinicCarousel"
            data-bs-slide-to="0"
            class="active"
          ></button>
          <button
            type="button"
            data-bs-target="#clinicCarousel"
            data-bs-slide-to="1"
          ></button>
          <button
            type="button"
            data-bs-target="#clinicCarousel"
            data-bs-slide-to="2"
          ></button>
        </div>

        <div class="carousel-inner">
          <div class="carousel-item active">
            <div class="hero-slide-content slide-1">
              <div class="overlay"></div>
              <div class="hero-text">
                <h1>Your Services Way</h1>
                <p>
                  Browse our extensive catalog of medicines and healthcare
                  products with detailed information and competitive prices.
                </p>
                <a href="{{ route('front.services.index') }}" class="book-btn">Book Now</a>
              </div>
            </div>
          </div>

          <div class="carousel-item">
            <div class="hero-slide-content slide-2">
              <div class="overlay"></div>
              <div class="hero-text">
                <h1>AI-Powered Assistance</h1>
                <p>
                  Experience the future of healthcare with our smart AI Chatbot.
                  Instant answers to your medical inquiries 24/7.
                </p>
                <a href="#" class="book-btn">Try Chatbot</a>
              </div>
            </div>
          </div>

          <div class="carousel-item">
            <div class="hero-slide-content slide-3">
              <div class="overlay"></div>
              <div class="hero-text">
                <h1>Expert Consultations</h1>
                <p>
                  Connect with professional doctors online. Secure, private, and
                  convenient video consultations from your home.
                </p>
                <a href="{{ route('front.doctors') }}" class="book-btn">Find a Doctor</a>
              </div>
            </div>
          </div>
        </div>

        <button
          class="carousel-control-prev"
          type="button"
          data-bs-target="#clinicCarousel"
          data-bs-slide="prev"
        >
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        </button>
        <button
          class="carousel-control-next"
          type="button"
          data-bs-target="#clinicCarousel"
          data-bs-slide="next"
        >
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
        </button>
      </div>
    </section>

    <!-- features -->
    <section class="pref-section-area" id="features">
      <div class="features-wrapper">
        <div class="pref-main-header" data-aos="fade-down">
          <h2 class="pref-title">Our Premium Features</h2>
          <p class="pref-subtitle">
            Modern healthcare tools — simple, fast, and always reliable.
          </p>
          <div class="pref-line-divider"></div>
        </div>

        <div class="pref-cards-flexbox">
          <div class="pref-single-card" data-aos="fade-up" data-aos-delay="0">
            <div class="pref-icon-container">
              <i class="fa-solid fa-stethoscope"></i>
            </div>
            <h3 class="pref-card-name">Services</h3>
            <p class="pref-card-info">
              Access a wide range of premium health services, consultations,
              diagnostics, and more with transparent pricing.
            </p>
            <a href="{{ route('front.services.index') }}" class="pref-action-btn">Explore Services</a>
          </div>

          <div class="pref-single-card" data-aos="fade-up" data-aos-delay="150">
            <div class="pref-icon-container">
              <i class="fa-solid fa-user-doctor"></i>
            </div>
            <h3 class="pref-card-name">Doctor Consultation</h3>
            <p class="pref-card-info">
              Talk or video chat with certified doctors anytime — secure, fast,
              and professional care.
            </p>
            <a href="{{ route('front.doctors') }}" class="pref-action-btn">Find Doctors</a>
          </div>

          <div class="pref-single-card" data-aos="fade-up" data-aos-delay="300">
            <div class="pref-icon-container">
              <i class="fa-solid fa-robot"></i>
            </div>
            <h3 class="pref-card-name">AI Assistant</h3>
            <p class="pref-card-info">
              Ask about symptoms, medications, or health tips — get quick,
              intelligent answers 24/7.
            </p>
            <a href="#" class="pref-action-btn">Talk to AI</a>
          </div>
        </div>
      </div>
    </section>

    <!-- majors / specialties -->
    <section class="maj-section-area" id="majors">
      <div class="maj-wrapper">
        <div class="maj-main-header" data-aos="fade-down">
          <h2 class="maj-title">SPECIALTIES</h2>
          <div class="maj-line-divider"></div>
          <p class="maj-subtitle">
            Explore our wide range of medical specialties, each staffed with
            experienced and certified professionals ready to serve you.
          </p>
        </div>

        <div class="maj-cards-container">
          @forelse ($majors as $major)
            <div class="maj-single-card" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">

              <div class="maj-img-box">
                <img
                  src="{{ $major->image
                          ? asset('images/majors/' . $major->image)
                          : asset('images/majors/default.png') }}"
                  alt="{{ $major->title }}"
                />
                <div class="maj-overlay"></div>
              </div>

              <div class="maj-content">
                <h3 class="maj-card-name">{{ $major->title }}</h3>
                <p class="maj-card-desc">
                  {{ \Illuminate\Support\Str::limit($major->description, 50) }}
                </p>
                <div class="maj-doctors-count">
                  <i class="fa-solid fa-user-doctor"></i>
                  <span>{{ $major->doctors->count() }} Doctor{{ $major->doctors->count() != 1 ? 's' : '' }}</span>
                </div>
                <a href="{{ route('front.major.show', $major->id) }}" class="maj-action-btn">View Doctors</a>
                
              </div>

            </div>
            
          @empty
            <div class="text-center py-5">
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

    <!-- services -->
    <section class="serv-section-area" id="services">
      <div class="serv-wrapper">
        <div class="serv-main-header" data-aos="fade-down">
          <h2 class="serv-title">SERVICES</h2>
          <div class="serv-line-divider"></div>
          <p class="serv-subtitle">
            Discover our comprehensive suite of clinic management solutions
            designed to streamline operations, improve patient experience, and
            boost efficiency for modern healthcare practices.
          </p>
        </div>

        <div class="serv-cards-container">
          @forelse ($services as $service)
            <div class="serv-single-card" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
              <div class="serv-img-box">
                <img
                  src="{{ $service->image
                          ? asset('storage/services/' . $service->image)
                          : asset('images/default-service.png') }}"
                  alt="{{ $service->name }}"
                />
              </div>

              <div class="serv-content">
                <div class="d-flex justify-content-between align-items-center mb-2">
                  <h5 class="card-title mb-0 fw-bold">
                    {{ $service->name }}
                  </h5>
                  <span class="badge bg-soft-primary text-primary fw-bold">
                    {{ number_format($service->price, 2) }} EGP
                  </span>
                </div>

                <p class="text-muted small mb-4">
                  {{ \Illuminate\Support\Str::limit($service->description, 120) }}
                </p>

                <div class="serv-footer-btns">
                  <a href="#" class="btn btn-primary w-100 rounded-pill">
                    Available Now
                  </a>
                </div>
              </div>
            </div>
          @empty
            <div class="text-center py-5">
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

    <!-- doctors -->
    <section class="doc-section-area" id="doctors">
      <div class="doc-wrapper">
        <div class="doc-main-header" data-aos="fade-down">
          <h2 class="doc-title">DOCTORS</h2>
          <div class="doc-line-divider"></div>
          <p class="doc-subtitle">
            Connect with our team of highly qualified medical professionals for
            personalized consultations and expert care.
          </p>
        </div>

        <div class="doc-cards-container">
          @forelse ($doctors as $doctor)
            <div class="doc-single-card" data-aos="zoom-in" data-aos-delay="{{ $loop->index * 100 }}">

              <div class="doc-avatar-box">
                <img
                  src="{{ $doctor->image
                          ? asset('images/doctors/' . $doctor->image)
                          : asset('images/default-doctor.png') }}"
                  alt="Dr. {{ $doctor->user->name }}"
                />
              </div>

              <div class="doc-info">
                <h3 class="doc-name">
                  Dr. {{ $doctor->user->name }}
                </h3>

                <div class="doc-contact-info">
                  <span>
                    <i class="fa-solid fa-envelope"></i>
                    {{ $doctor->user->email }}
                  </span>
                  <span>
                    <i class="fa-solid fa-phone"></i>
                    {{ $doctor->user->phone }}
                  </span>
                </div>

                <span class="doc-specialty">
                  {{ $doctor->major->title }}
                </span>

                <h4 class="doc-price">
                  Appointment: {{ number_format($doctor->consultation_fee, 2) }} EGP
                </h4>

                <div class="doc-rating">
                  @for ($i = 1; $i <= 5; $i++)
                    <i class="fa {{ $i <= 4 ? 'fa-solid' : 'fa-regular' }} fa-star"></i>
                  @endfor
                </div>

                <div class="doc-action-footer">
                  <a href="#" class="doc-book-btn">
                    <i class="fa-regular fa-calendar-check"></i> Book
                  </a>
                  <a href="{{ route('front.doctor.show', $doctor->id) }}" class="doc-chat-btn">
                    <i class="fa-regular fa-user"></i> Profile
                  </a>
                </div>
              </div>

            </div>
          @empty
            <div class="text-center py-5">
              <p class="text-muted">No doctors available at the moment.</p>
            </div>
          @endforelse
        </div>

        <div class="doc-see-more-container" data-aos="fade-up">
          <a href="{{ route('front.doctors') }}" class="doc-more-btn">
            View All Specialists <i class="fa-solid fa-arrow-right-long"></i>
          </a>
        </div>
      </div>
    </section>

@endsection

@push('style')
  <style>
    .maj-section-area { padding: 60px 0; background: #f8f9fa; }
.maj-wrapper { max-width: 1200px; margin: 0 auto; padding: 0 20px; }
.maj-main-header { text-align: center; margin-bottom: 40px; }
.maj-title { font-size: 2rem; font-weight: 700; color: #333; }
.maj-line-divider { width: 60px; height: 3px; background: #00a8e8; margin: 10px auto; }
.maj-subtitle { color: #666; margin-top: 10px; }
.maj-cards-container { display: flex; flex-wrap: wrap; gap: 25px; justify-content: center; }
.maj-single-card { width: 260px; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.1); background: #fff; transition: transform 0.3s; }
.maj-single-card:hover { transform: translateY(-8px); }
.maj-img-box { position: relative; height: 180px; overflow: hidden; }
.maj-img-box img { width: 100%; height: 100%; object-fit: cover; }
.maj-overlay { position: absolute; inset: 0; background: rgba(0,168,232,0.2); }
.maj-content { padding: 20px; }
.maj-card-name { font-size: 1.1rem; font-weight: 700; color: #333; margin-bottom: 8px; }
.maj-card-desc { font-size: 0.85rem; color: #666; margin-bottom: 12px; }
.maj-doctors-count { display: flex; align-items: center; gap: 8px; color: #00a8e8; font-weight: 600; margin-bottom: 15px; }
.maj-action-btn { display: inline-block; padding: 8px 20px; background: #00a8e8; color: #fff; border-radius: 25px; text-decoration: none; font-size: 0.85rem; transition: background 0.3s; }
.maj-action-btn:hover { background: #0077b6; color: #fff; }
</style>
@endpush