@extends('front.inc.master')
@section('title', 'About Us')
@section('content')

    <!-- About Hero -->
    <section class="abt-hero-section">
        <div class="abt-hero-overlay"></div>
        <div class="abt-hero-content" data-aos="fade-up">
            <span class="abt-hero-badge">Who We Are</span>
            <h1 class="abt-hero-title">About <span>Our Clinic</span></h1>
            <p class="abt-hero-sub">
                Delivering compassionate, expert, and modern healthcare since 2010.
                We put patients first — always.
            </p>
            <div class="abt-hero-breadcrumb">
                <a href="{{ route('front.home') }}">Home</a>
                <i class="fa-solid fa-chevron-right"></i>
                <span>About Us</span>
            </div>
        </div>
    </section>

    <!-- Who We Are -->
    <section class="abt-intro-section">
        <div class="abt-container">
            <div class="abt-intro-grid">
                <div class="abt-intro-image-wrap" data-aos="fade-right">
                    <div class="abt-img-main">
                        <img src="{{ asset('images/about/clinic.jpg') }}" alt="Our Clinic"
                            onerror="this.src='https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?w=600&q=80'"/>
                    </div>
                    <div class="abt-img-badge">
                        <span class="abt-badge-number">15+</span>
                        <span class="abt-badge-label">Years of Excellence</span>
                    </div>
                    <div class="abt-img-dot-pattern"></div>
                </div>

                <div class="abt-intro-text" data-aos="fade-left">
                    <p class="abt-section-tag">Our Story</p>
                    <h2 class="abt-section-title">We Care for Your Health Like Family</h2>
                    <div class="abt-line-divider"></div>
                    <p class="abt-section-body">
                        Founded in 2010, our clinic was built on a single mission — to make quality healthcare
                        accessible, compassionate, and efficient. We started as a small outpatient center and
                        have grown into a full-service medical facility trusted by thousands of patients.
                    </p>
                    <p class="abt-section-body">
                        Today, we combine the warmth of a family clinic with the technology of a modern medical
                        center. From AI-powered health assistance to board-certified specialist consultations,
                        we are here for you every step of the way.
                    </p>

                    <div class="abt-intro-stats">
                        <div class="abt-stat-item">
                            <span class="abt-stat-num">12K+</span>
                            <span class="abt-stat-lbl">Happy Patients</span>
                        </div>
                        <div class="abt-stat-divider"></div>
                        <div class="abt-stat-item">
                            <span class="abt-stat-num">50+</span>
                            <span class="abt-stat-lbl">Specialists</span>
                        </div>
                        <div class="abt-stat-divider"></div>
                        <div class="abt-stat-item">
                            <span class="abt-stat-num">20+</span>
                            <span class="abt-stat-lbl">Specialties</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Mission, Vision, Values -->
    <section class="abt-mvv-section">
        <div class="abt-container">
            <div class="abt-mvv-header" data-aos="fade-down">
                <h2 class="abt-mvv-title">Our Core Pillars</h2>
                <div class="abt-line-divider"></div>
                <p class="abt-mvv-sub">The principles that guide every decision we make and every patient we serve.</p>
            </div>

            <div class="abt-mvv-cards">
                <div class="abt-mvv-card" data-aos="fade-up" data-aos-delay="0">
                    <div class="abt-mvv-icon-wrap" style="background: linear-gradient(135deg, #00a8e8, #0077b6);">
                        <i class="fa-solid fa-bullseye"></i>
                    </div>
                    <h3>Our Mission</h3>
                    <p>
                        To provide accessible, high-quality medical care that improves the health and
                        wellbeing of every individual and community we serve — with empathy and precision.
                    </p>
                </div>

                <div class="abt-mvv-card" data-aos="fade-up" data-aos-delay="150">
                    <div class="abt-mvv-icon-wrap" style="background: linear-gradient(135deg, #20c997, #0f9e77);">
                        <i class="fa-solid fa-eye"></i>
                    </div>
                    <h3>Our Vision</h3>
                    <p>
                        To be the most trusted healthcare destination — where cutting-edge medicine meets
                        genuine human connection, setting the standard for modern clinical care.
                    </p>
                </div>

                <div class="abt-mvv-card" data-aos="fade-up" data-aos-delay="300">
                    <div class="abt-mvv-icon-wrap" style="background: linear-gradient(135deg, #fd7e14, #e05c00);">
                        <i class="fa-solid fa-heart-pulse"></i>
                    </div>
                    <h3>Our Values</h3>
                    <p>
                        Compassion, Integrity, Innovation, and Excellence. These aren't just words —
                        they are the standards we hold ourselves to every single day.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Choose Us -->
    <section class="abt-why-section">
        <div class="abt-container">
            <div class="abt-why-inner">
                <div class="abt-why-text" data-aos="fade-right">
                    <p class="abt-section-tag">Why Us</p>
                    <h2 class="abt-section-title">What Makes Us Different</h2>
                    <div class="abt-line-divider"></div>

                    <div class="abt-why-list">
                        <div class="abt-why-item">
                            <div class="abt-why-icon">
                                <i class="fa-solid fa-user-doctor"></i>
                            </div>
                            <div>
                                <h4>Board-Certified Specialists</h4>
                                <p>Every doctor in our network is rigorously vetted, certified, and committed to ongoing education.</p>
                            </div>
                        </div>
                        <div class="abt-why-item">
                            <div class="abt-why-icon">
                                <i class="fa-solid fa-robot"></i>
                            </div>
                            <div>
                                <h4>AI-Powered Health Tools</h4>
                                <p>Our intelligent chatbot answers your health questions 24/7 with medically accurate responses.</p>
                            </div>
                        </div>
                        <div class="abt-why-item">
                            <div class="abt-why-icon">
                                <i class="fa-solid fa-lock"></i>
                            </div>
                            <div>
                                <h4>Private & Secure</h4>
                                <p>Your medical data is fully encrypted and protected. Confidentiality is our top priority.</p>
                            </div>
                        </div>
                        <div class="abt-why-item">
                            <div class="abt-why-icon">
                                <i class="fa-solid fa-clock"></i>
                            </div>
                            <div>
                                <h4>24/7 Availability</h4>
                                <p>Round-the-clock support ensures you're never alone when you need medical guidance.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="abt-why-image" data-aos="fade-left">
                    <img src="{{ asset('images/about/team.jpg') }}" alt="Our Team"
                        onerror="this.src='https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?w=600&q=80'"/>
                    <div class="abt-why-card-overlay">
                        <i class="fa-solid fa-award"></i>
                        <span>ISO Certified Clinic</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Team / Doctors CTA -->
    <section class="abt-team-cta-section" data-aos="fade-up">
        <div class="abt-container">
            <div class="abt-team-cta-inner">
                <div class="abt-team-cta-text">
                    <h2>Meet Our Expert Doctors</h2>
                    <p>Our team of specialists is ready to provide the best care tailored just for you.</p>
                </div>
                <div class="abt-team-cta-btns">
                    <a href="{{ route('front.doctors') }}" class="abt-cta-btn-primary">
                        <i class="fa-solid fa-user-doctor"></i> View All Doctors
                    </a>
                    <a href="{{ route('front.services.index') }}" class="abt-cta-btn-outline">
                        <i class="fa-solid fa-stethoscope"></i> Our Services
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="abt-testimonials-section">
        <div class="abt-container">
            <div class="abt-mvv-header" data-aos="fade-down">
                <h2 class="abt-mvv-title">What Patients Say</h2>
                <div class="abt-line-divider"></div>
                <p class="abt-mvv-sub">Real words from real patients who trusted us with their health.</p>
            </div>

            <div class="abt-testi-grid">
                <div class="abt-testi-card" data-aos="fade-up" data-aos-delay="0">
                    <div class="abt-testi-stars">
                        <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                    </div>
                    <p>"The doctors here are incredibly professional and caring. I've never felt more heard and understood during a medical visit. Truly exceptional."</p>
                    <div class="abt-testi-author">
                        <div class="abt-testi-avatar">A</div>
                        <div>
                            <strong>Ahmed Hassan</strong>
                            <span>Patient since 2019</span>
                        </div>
                    </div>
                </div>

                <div class="abt-testi-card" data-aos="fade-up" data-aos-delay="150">
                    <div class="abt-testi-stars">
                        <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                    </div>
                    <p>"The AI chatbot saved me so much time. Got answers at 2am when I was worried about my symptoms. The follow-up with a real doctor was seamless."</p>
                    <div class="abt-testi-author">
                        <div class="abt-testi-avatar" style="background: #20c997;">S</div>
                        <div>
                            <strong>Sara Mahmoud</strong>
                            <span>Patient since 2021</span>
                        </div>
                    </div>
                </div>

                <div class="abt-testi-card" data-aos="fade-up" data-aos-delay="300">
                    <div class="abt-testi-stars">
                        <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                        <i class="fa-regular fa-star"></i>
                    </div>
                    <p>"Booked an appointment in minutes, saw a specialist the same day. The facility is modern and the staff is warm and welcoming. Highly recommended!"</p>
                    <div class="abt-testi-author">
                        <div class="abt-testi-avatar" style="background: #fd7e14;">M</div>
                        <div>
                            <strong>Mohamed Ali</strong>
                            <span>Patient since 2022</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('style')
<style>
/* ===================== BASE ===================== */
.abt-container { max-width: 1200px; margin: 0 auto; padding: 0 20px; }
.abt-line-divider { width: 60px; height: 3px; background: #00a8e8; margin: 12px 0 20px; }
.abt-section-tag { font-size: 0.85rem; font-weight: 700; color: #00a8e8; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 8px; display: block; }
.abt-section-title { font-size: 2rem; font-weight: 800; color: #1a1a2e; line-height: 1.2; margin-bottom: 6px; }
.abt-section-body { color: #555; line-height: 1.8; margin-bottom: 14px; }

/* ===================== HERO ===================== */
.abt-hero-section {
    position: relative;
    height: 420px;
    background: url('https://images.unsplash.com/photo-1586773860418-d37222d8fce3?w=1400&q=80') center/cover no-repeat;
    display: flex; align-items: center; justify-content: center;
}
.abt-hero-overlay {
    position: absolute; inset: 0;
    background: linear-gradient(135deg, rgba(0,80,120,0.82), rgba(0,168,232,0.65));
}
.abt-hero-content {
    position: relative; text-align: center; color: #fff; padding: 0 20px;
}
.abt-hero-badge {
    display: inline-block; background: rgba(255,255,255,0.2); border: 1px solid rgba(255,255,255,0.4);
    padding: 5px 18px; border-radius: 50px; font-size: 0.8rem; letter-spacing: 2px;
    text-transform: uppercase; margin-bottom: 16px; backdrop-filter: blur(4px);
}
.abt-hero-title { font-size: 3rem; font-weight: 900; margin-bottom: 14px; }
.abt-hero-title span { color: #7de8ff; }
.abt-hero-sub { font-size: 1.1rem; max-width: 560px; margin: 0 auto 24px; opacity: 0.9; }
.abt-hero-breadcrumb { display: flex; align-items: center; justify-content: center; gap: 10px; font-size: 0.9rem; opacity: 0.85; }
.abt-hero-breadcrumb a { color: #fff; text-decoration: none; }
.abt-hero-breadcrumb a:hover { color: #7de8ff; }
.abt-hero-breadcrumb i { font-size: 0.7rem; }

/* ===================== INTRO ===================== */
.abt-intro-section { padding: 90px 0; background: #fff; }
.abt-intro-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 70px; align-items: center; }
.abt-intro-image-wrap { position: relative; }
.abt-img-main { border-radius: 16px; overflow: hidden; box-shadow: 0 20px 60px rgba(0,168,232,0.18); }
.abt-img-main img { width: 100%; height: 420px; object-fit: cover; display: block; }
.abt-img-badge {
    position: absolute; bottom: -20px; right: -20px;
    background: linear-gradient(135deg, #00a8e8, #0077b6);
    color: #fff; border-radius: 14px; padding: 18px 24px; text-align: center;
    box-shadow: 0 10px 30px rgba(0,120,182,0.35);
}
.abt-badge-number { display: block; font-size: 2rem; font-weight: 900; line-height: 1; }
.abt-badge-label { font-size: 0.78rem; opacity: 0.9; }
.abt-img-dot-pattern {
    position: absolute; top: -20px; left: -20px; width: 120px; height: 120px;
    background-image: radial-gradient(#00a8e8 1.5px, transparent 1.5px);
    background-size: 14px 14px; opacity: 0.35; z-index: -1;
}

.abt-intro-stats { display: flex; align-items: center; gap: 24px; margin-top: 30px; }
.abt-stat-item { text-align: center; }
.abt-stat-num { display: block; font-size: 1.9rem; font-weight: 900; color: #00a8e8; line-height: 1; }
.abt-stat-lbl { font-size: 0.8rem; color: #666; margin-top: 4px; display: block; }
.abt-stat-divider { width: 1px; height: 50px; background: #e0e0e0; }

/* ===================== MVV ===================== */
.abt-mvv-section { padding: 80px 0; background: #f8f9fa; }
.abt-mvv-header { text-align: center; margin-bottom: 50px; }
.abt-mvv-title { font-size: 2rem; font-weight: 800; color: #1a1a2e; }
.abt-mvv-header .abt-line-divider { margin: 12px auto 16px; }
.abt-mvv-sub { color: #666; max-width: 560px; margin: 0 auto; }
.abt-mvv-cards { display: grid; grid-template-columns: repeat(3, 1fr); gap: 28px; }
.abt-mvv-card {
    background: #fff; border-radius: 16px; padding: 36px 28px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.07); text-align: center;
    transition: transform 0.3s, box-shadow 0.3s;
}
.abt-mvv-card:hover { transform: translateY(-8px); box-shadow: 0 12px 35px rgba(0,0,0,0.12); }
.abt-mvv-icon-wrap {
    width: 70px; height: 70px; border-radius: 20px;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 22px; color: #fff; font-size: 1.6rem;
}
.abt-mvv-card h3 { font-size: 1.2rem; font-weight: 700; color: #1a1a2e; margin-bottom: 12px; }
.abt-mvv-card p { color: #666; line-height: 1.75; font-size: 0.92rem; }

/* ===================== WHY US ===================== */
.abt-why-section { padding: 90px 0; background: #fff; }
.abt-why-inner { display: grid; grid-template-columns: 1fr 1fr; gap: 70px; align-items: center; }
.abt-why-list { display: flex; flex-direction: column; gap: 22px; margin-top: 10px; }
.abt-why-item { display: flex; gap: 18px; align-items: flex-start; }
.abt-why-icon {
    min-width: 46px; height: 46px; border-radius: 12px;
    background: linear-gradient(135deg, #e8f6fd, #c8ecfa);
    color: #00a8e8; display: flex; align-items: center; justify-content: center;
    font-size: 1.1rem;
}
.abt-why-item h4 { font-size: 1rem; font-weight: 700; color: #1a1a2e; margin-bottom: 4px; }
.abt-why-item p { color: #666; font-size: 0.88rem; line-height: 1.65; margin: 0; }
.abt-why-image { position: relative; }
.abt-why-image img { width: 100%; height: 460px; object-fit: cover; border-radius: 16px; box-shadow: 0 20px 60px rgba(0,0,0,0.12); display: block; }
.abt-why-card-overlay {
    position: absolute; bottom: 24px; left: 24px;
    background: linear-gradient(135deg, #00a8e8, #0077b6);
    color: #fff; padding: 14px 22px; border-radius: 12px;
    display: flex; align-items: center; gap: 10px;
    font-weight: 700; box-shadow: 0 8px 25px rgba(0,120,182,0.4);
}
.abt-why-card-overlay i { font-size: 1.4rem; }

/* ===================== CTA ===================== */
.abt-team-cta-section { padding: 60px 0; }
.abt-team-cta-inner {
    background: linear-gradient(135deg, #00a8e8 0%, #0077b6 100%);
    border-radius: 20px; padding: 50px 60px;
    display: flex; align-items: center; justify-content: space-between; gap: 30px;
    box-shadow: 0 15px 50px rgba(0,120,182,0.3);
}
.abt-team-cta-text h2 { color: #fff; font-size: 1.8rem; font-weight: 800; margin-bottom: 8px; }
.abt-team-cta-text p { color: rgba(255,255,255,0.85); font-size: 1rem; margin: 0; }
.abt-team-cta-btns { display: flex; gap: 14px; flex-wrap: wrap; }
.abt-cta-btn-primary {
    display: inline-flex; align-items: center; gap: 8px;
    background: #fff; color: #0077b6; padding: 12px 28px;
    border-radius: 50px; font-weight: 700; text-decoration: none;
    transition: all 0.3s; white-space: nowrap;
}
.abt-cta-btn-primary:hover { background: #f0f0f0; color: #005a8e; transform: translateY(-2px); }
.abt-cta-btn-outline {
    display: inline-flex; align-items: center; gap: 8px;
    background: transparent; color: #fff; padding: 12px 28px;
    border-radius: 50px; font-weight: 700; text-decoration: none;
    border: 2px solid rgba(255,255,255,0.6); transition: all 0.3s; white-space: nowrap;
}
.abt-cta-btn-outline:hover { background: rgba(255,255,255,0.15); border-color: #fff; }

/* ===================== TESTIMONIALS ===================== */
.abt-testimonials-section { padding: 80px 0; background: #f8f9fa; }
.abt-testi-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 26px; }
.abt-testi-card {
    background: #fff; border-radius: 16px; padding: 32px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.06);
    transition: transform 0.3s, box-shadow 0.3s;
    border-top: 3px solid #00a8e8;
}
.abt-testi-card:hover { transform: translateY(-6px); box-shadow: 0 12px 35px rgba(0,0,0,0.1); }
.abt-testi-stars { color: #f5a623; margin-bottom: 16px; }
.abt-testi-card > p { color: #555; line-height: 1.75; font-size: 0.92rem; margin-bottom: 22px; font-style: italic; }
.abt-testi-author { display: flex; align-items: center; gap: 14px; }
.abt-testi-avatar {
    width: 44px; height: 44px; border-radius: 50%;
    background: #00a8e8; color: #fff;
    display: flex; align-items: center; justify-content: center;
    font-weight: 800; font-size: 1.1rem; flex-shrink: 0;
}
.abt-testi-author strong { display: block; color: #1a1a2e; font-size: 0.95rem; }
.abt-testi-author span { font-size: 0.78rem; color: #999; }

/* ===================== RESPONSIVE ===================== */
@media (max-width: 992px) {
    .abt-intro-grid,
    .abt-why-inner { grid-template-columns: 1fr; gap: 40px; }
    .abt-mvv-cards,
    .abt-testi-grid { grid-template-columns: 1fr; }
    .abt-hero-title { font-size: 2.2rem; }
    .abt-team-cta-inner { flex-direction: column; text-align: center; padding: 40px 30px; }
    .abt-team-cta-btns { justify-content: center; }
    .abt-img-badge { bottom: -10px; right: 10px; }
}
@media (max-width: 576px) {
    .abt-hero-section { height: 340px; }
    .abt-hero-title { font-size: 1.8rem; }
    .abt-intro-stats { gap: 14px; }
    .abt-mvv-cards { grid-template-columns: 1fr; }
    .abt-testi-grid { grid-template-columns: 1fr; }
}
</style>
@endpush