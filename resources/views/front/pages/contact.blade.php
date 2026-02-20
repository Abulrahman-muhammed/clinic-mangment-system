@extends('front.inc.master')
@section('title', 'Contact Us')
@section('content')

    <!-- Contact Hero -->
    <section class="cnt-hero-section">
        <div class="cnt-hero-overlay"></div>
        <div class="cnt-hero-content" data-aos="fade-up">
            <span class="cnt-hero-badge">Get In Touch</span>
            <h1 class="cnt-hero-title">Contact <span>Us</span></h1>
            <p class="cnt-hero-sub">
                Have a question or need help? We're here for you — reach out anytime.
            </p>
            <div class="cnt-hero-breadcrumb">
                <a href="{{ route('front.home') }}">Home</a>
                <i class="fa-solid fa-chevron-right"></i>
                <span>Contact Us</span>
            </div>
        </div>
    </section>

    <!-- Contact Form Section -->
    <section class="cnt-main-section">
        <div class="cnt-container">
            <div class="cnt-form-wrapper" data-aos="fade-up">

                <!-- LEFT PANEL -->
                <div class="cnt-form-left">
                    <span class="cnt-form-tag">Send a Message</span>
                    <h2 class="cnt-form-title">We'd Love to Hear From You</h2>
                    <div class="cnt-line-divider"></div>
                    <p class="cnt-form-desc">
                        Fill out the form and one of our team members will get back to you
                        within 24 hours. Your health is our priority.
                    </p>

                    <div class="cnt-contact-info-list">
                        <div class="cnt-contact-info-item">
                            <div class="cnt-contact-info-icon">
                                <i class="fa-solid fa-phone"></i>
                            </div>
                            <div>
                                <span class="cnt-info-label">Phone</span>
                                <span class="cnt-info-value">+20 1279978123</span>
                            </div>
                        </div>
                        <div class="cnt-contact-info-item">
                            <div class="cnt-contact-info-icon">
                                <i class="fa-solid fa-envelope"></i>
                            </div>
                            <div>
                                <span class="cnt-info-label">Email</span>
                                <span class="cnt-info-value">info@ourclinic.com</span>
                            </div>
                        </div>
                        <div class="cnt-contact-info-item">
                            <div class="cnt-contact-info-icon">
                                <i class="fa-solid fa-location-dot"></i>
                            </div>
                            <div>
                                <span class="cnt-info-label">Address</span>
                                <span class="cnt-info-value">123 Health Street, Mansoura</span>
                            </div>
                        </div>
                        <div class="cnt-contact-info-item">
                            <div class="cnt-contact-info-icon">
                                <i class="fa-solid fa-clock"></i>
                            </div>
                            <div>
                                <span class="cnt-info-label">Working Hours</span>
                                <span class="cnt-info-value">Sat – Thu: 9AM – 9PM</span>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- RIGHT PANEL -->
                <div class="cnt-form-right">

                    @if(session('success'))
                        <div class="cnt-alert-success">
                            <i class="fa-solid fa-circle-check"></i>
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('front.contact.store') }}" method="POST" class="cnt-form" id="contactForm">
                        @csrf

                        <div class="cnt-form-row">
                            <div class="cnt-form-group">
                                <label class="required-label" for="name">
                                    <i class="fa-solid fa-user"></i> Name
                                </label>
                                <input
                                    type="text"
                                    id="name"
                                    name="name"
                                    placeholder="John Doe"
                                    value="{{ old('name') }}"
                                    class="{{ $errors->has('name') ? 'cnt-input-error' : '' }}"
                                />
                                @error('name')
                                    <span class="cnt-error-msg"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</span>
                                @enderror
                            </div>
                            <div class="cnt-form-group">
                                <label class="required-label" for="phone">
                                    <i class="fa-solid fa-phone"></i> Phone
                                </label>
                                <input
                                    type="tel"
                                    id="phone"
                                    name="phone"
                                    placeholder="+20 100 000 0000"
                                    value="{{ old('phone') }}"
                                    class="{{ $errors->has('phone') ? 'cnt-input-error' : '' }}"
                                />
                                @error('phone')
                                    <span class="cnt-error-msg"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="cnt-form-row">
                            <div class="cnt-form-group">
                                <label class="required-label" for="email">
                                    <i class="fa-solid fa-envelope"></i> Email
                                </label>
                                <input
                                    type="email"
                                    id="email"
                                    name="email"
                                    placeholder="john@example.com"
                                    value="{{ old('email') }}"
                                    class="{{ $errors->has('email') ? 'cnt-input-error' : '' }}"
                                />
                                @error('email')
                                    <span class="cnt-error-msg"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</span>
                                @enderror
                            </div>
                            <div class="cnt-form-group">
                                <label class="required-label" for="subject">
                                    <i class="fa-solid fa-tag"></i> Subject
                                </label>
                                <input
                                    type="text"
                                    id="subject"
                                    name="subject"
                                    placeholder="How can we help?"
                                    value="{{ old('subject') }}"
                                    class="{{ $errors->has('subject') ? 'cnt-input-error' : '' }}"
                                />
                                @error('subject')
                                    <span class="cnt-error-msg"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="cnt-form-group cnt-full-width">
                            <label class="required-label" for="message">
                                <i class="fa-solid fa-message"></i> Message
                            </label>
                            <textarea
                                id="message"
                                name="message"
                                rows="5"
                                placeholder="Write your message here..."
                                class="{{ $errors->has('message') ? 'cnt-input-error' : '' }}"
                            >{{ old('message') }}</textarea>
                            @error('message')
                                <span class="cnt-error-msg"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit" class="cnt-submit-btn" id="submitBtn">
                            <span class="cnt-btn-text">
                                <i class="fa-solid fa-paper-plane"></i> Send Message
                            </span>
                            <span class="cnt-btn-loading" style="display:none;">
                                <i class="fa-solid fa-spinner fa-spin"></i> Sending...
                            </span>
                        </button>

                    </form>
                </div>

            </div>
        </div>
    </section>

@endsection

@push('style')
<style>
/* ===================== BASE ===================== */
.cnt-container { max-width: 1200px; margin: 0 auto; padding: 0 20px; }
.cnt-line-divider { width: 60px; height: 3px; background: rgba(255,255,255,0.45); margin: 12px 0 22px; }

/* ===================== HERO ===================== */
.cnt-hero-section {
    position: relative; height: 380px;
    background: url('https://images.unsplash.com/photo-1631217868264-e5b90bb7e133?w=1400&q=80') center/cover no-repeat;
    display: flex; align-items: center; justify-content: center;
}
.cnt-hero-overlay {
    position: absolute; inset: 0;
    background: linear-gradient(135deg, rgba(0,80,120,0.85), rgba(0,168,232,0.68));
}
.cnt-hero-content { position: relative; text-align: center; color: #fff; padding: 0 20px; }
.cnt-hero-badge {
    display: inline-block; background: rgba(255,255,255,0.18);
    border: 1px solid rgba(255,255,255,0.4);
    padding: 5px 18px; border-radius: 50px; font-size: 0.8rem;
    letter-spacing: 2px; text-transform: uppercase;
    margin-bottom: 16px; backdrop-filter: blur(4px);
}
.cnt-hero-title { font-size: 3rem; font-weight: 900; margin-bottom: 12px; }
.cnt-hero-title span { color: #7de8ff; }
.cnt-hero-sub { font-size: 1.05rem; max-width: 500px; margin: 0 auto 22px; opacity: 0.9; }
.cnt-hero-breadcrumb { display: flex; align-items: center; justify-content: center; gap: 10px; font-size: 0.88rem; opacity: 0.85; }
.cnt-hero-breadcrumb a { color: #fff; text-decoration: none; }
.cnt-hero-breadcrumb a:hover { color: #7de8ff; }
.cnt-hero-breadcrumb i { font-size: 0.65rem; }

/* ===================== MAIN ===================== */
.cnt-main-section { padding: 70px 0 90px; background: #f8f9fa; }

/* ===================== FORM WRAPPER ===================== */
.cnt-form-wrapper {
    background: #fff; border-radius: 20px;
    box-shadow: 0 8px 40px rgba(0,0,0,0.1);
    display: grid; grid-template-columns: 340px 1fr;
    overflow: hidden;
}

/* LEFT PANEL */
.cnt-form-left {
    background: linear-gradient(160deg, #005f99 0%, #00a8e8 100%);
    padding: 50px 34px; color: #fff;
    display: flex; flex-direction: column; gap: 0;
}
.cnt-form-tag {
    font-size: 0.75rem; letter-spacing: 2px; text-transform: uppercase;
    opacity: 0.72; margin-bottom: 10px; display: block;
}
.cnt-form-title { font-size: 1.6rem; font-weight: 800; line-height: 1.25; margin-bottom: 6px; }
.cnt-form-desc { font-size: 0.87rem; opacity: 0.8; line-height: 1.75; margin-bottom: 28px; }

/* Contact Info List */
.cnt-contact-info-list { display: flex; flex-direction: column; gap: 16px; margin-bottom: 30px; }
.cnt-contact-info-item { display: flex; align-items: center; gap: 14px; }
.cnt-contact-info-icon {
    min-width: 38px; height: 38px; border-radius: 10px;
    background: rgba(255,255,255,0.16); border: 1px solid rgba(255,255,255,0.22);
    display: flex; align-items: center; justify-content: center; font-size: 0.9rem;
}
.cnt-info-label { display: block; font-size: 0.68rem; opacity: 0.65; text-transform: uppercase; letter-spacing: 1px; }
.cnt-info-value { display: block; font-size: 0.86rem; font-weight: 600; margin-top: 1px; }

/* Social */
.cnt-social-links { display: flex; align-items: center; gap: 10px; margin-top: auto; padding-top: 10px; }
.cnt-social-links span { font-size: 0.8rem; opacity: 0.72; }
.cnt-social-btn {
    width: 34px; height: 34px; border-radius: 50%;
    background: rgba(255,255,255,0.14); border: 1px solid rgba(255,255,255,0.28);
    color: #fff; display: flex; align-items: center; justify-content: center;
    font-size: 0.8rem; text-decoration: none; transition: background 0.25s;
}
.cnt-social-btn:hover { background: rgba(255,255,255,0.3); color: #fff; }

/* RIGHT PANEL */
.cnt-form-right { padding: 50px 48px; }

/* Alert */
.cnt-alert-success {
    display: flex; align-items: center; gap: 10px;
    background: #d1fae5; color: #065f46; border: 1px solid #6ee7b7;
    border-radius: 10px; padding: 14px 18px; margin-bottom: 24px;
    font-size: 0.92rem; font-weight: 600;
}
.cnt-alert-success i { font-size: 1.2rem; }

/* Form */
.cnt-form { display: flex; flex-direction: column; gap: 20px; }
.cnt-form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
.cnt-form-group { display: flex; flex-direction: column; gap: 7px; }
.cnt-full-width { width: 100%; }

.cnt-form-group label {
    font-size: 0.85rem; font-weight: 600; color: #333;
    display: flex; align-items: center; gap: 6px;
}
.cnt-form-group label i { color: #00a8e8; font-size: 0.78rem; }
label.required-label::after { content: ' *'; color: #ef4444; }

.cnt-form-group input,
.cnt-form-group textarea {
    border: 1.5px solid #e2e8f0; border-radius: 10px;
    padding: 12px 16px; font-size: 0.9rem; color: #333;
    background: #f8fafc; outline: none; width: 100%;
    transition: border-color 0.25s, box-shadow 0.25s, background 0.25s;
    font-family: inherit;
}
.cnt-form-group textarea { resize: vertical; min-height: 140px; }
.cnt-form-group input:focus,
.cnt-form-group textarea:focus {
    border-color: #00a8e8; background: #fff;
    box-shadow: 0 0 0 4px rgba(0,168,232,0.1);
}
.cnt-form-group input::placeholder,
.cnt-form-group textarea::placeholder { color: #b0b8c1; }
.cnt-input-error { border-color: #ef4444 !important; background: #fff5f5 !important; }
.cnt-error-msg { color: #ef4444; font-size: 0.78rem; display: flex; align-items: center; gap: 4px; }

/* Submit */
.cnt-submit-btn {
    background: linear-gradient(135deg, #00a8e8, #0077b6);
    color: #fff; border: none; border-radius: 50px;
    padding: 14px 40px; font-size: 1rem; font-weight: 700;
    cursor: pointer; align-self: flex-start;
    transition: transform 0.25s, box-shadow 0.25s;
    box-shadow: 0 6px 20px rgba(0,120,182,0.35);
    display: inline-flex; align-items: center; gap: 8px;
}
.cnt-submit-btn:hover { transform: translateY(-2px); box-shadow: 0 10px 28px rgba(0,120,182,0.45); }
.cnt-submit-btn:disabled { opacity: 0.75; cursor: not-allowed; transform: none; }

/* ===================== RESPONSIVE ===================== */
@media (max-width: 1024px) {
    .cnt-form-wrapper { grid-template-columns: 1fr; }
    .cnt-form-left { padding: 40px 34px; }
}
@media (max-width: 640px) {
    .cnt-form-row { grid-template-columns: 1fr; }
    .cnt-hero-title { font-size: 2.2rem; }
    .cnt-form-right { padding: 30px 22px; }
    .cnt-submit-btn { width: 100%; justify-content: center; }
}
</style>
@endpush

@push('scripts')
<script>
document.getElementById('contactForm').addEventListener('submit', function() {
    const btn = document.getElementById('submitBtn');
    btn.querySelector('.cnt-btn-text').style.display = 'none';
    btn.querySelector('.cnt-btn-loading').style.display = 'inline-flex';
    btn.disabled = true;
});
</script>
@endpush