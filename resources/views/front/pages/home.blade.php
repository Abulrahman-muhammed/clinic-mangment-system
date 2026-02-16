@extends('front.inc.master')
@section('title', 'Home Page')
@section('content')

<!-- Hero Slider -->
<div class="hero-slider">
    <!-- Slide 1: Medicines -->
    <div class="slide slide-1 active">
        <div class="slide-content">
            <h1>Your Medicines Way</h1>
            <p>
                Browse our extensive catalog of medicines and healthcare
                products with detailed information and competitive prices.
            </p>
            <a href="/medicines" class="btn-hero">Buy Now</a>
        </div>
    </div>

    <!-- Slide 2: Doctor Consultation -->
    <div class="slide slide-2">
        <div class="slide-content">
            <h1>Consult with Expert Doctors</h1>
            <p>
                Get professional medical advice from certified doctors and specialists
                through secure online consultations.
            </p>
            <a href="/doctors" class="btn-hero">Book Appointment</a>
        </div>
    </div>

    <!-- Slide 3: AI Assistant -->
    <div class="slide slide-3">
        <div class="slide-content">
            <h1>AI-Powered Medical Assistant</h1>
            <p>
                Chat with our intelligent AI assistant to get instant answers
                to your health-related questions anytime.
            </p>
            <a href="/ai" class="btn-hero">Talk To AI</a>
        </div>
    </div>

    <div class="slider-controls">
        <div class="slider-dot active" data-slide="0"></div>
        <div class="slider-dot" data-slide="1"></div>
        <div class="slider-dot" data-slide="2"></div>
    </div>
</div>

<!-- Features Section -->
<section class="features py-5" id="features">
    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-lg-8">
                <h2 class="text-center">Our Premium Features</h2>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <div class="feature-card h-100 d-flex flex-column align-items-center text-center">
                    <i class="fa-solid fa-pills mb-3"></i>
                    <h5 class="mb-3">Services</h5>
                    <p class="flex-grow-1">
                        Discover our range of in-clinic medical services designed to monitor your health
                        and support early diagnosis and prevention.
                    </p>
                    <a href="/services" class="btn-premium mt-auto">Explore Services</a>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="feature-card h-100 d-flex flex-column align-items-center text-center">
                    <i class="fa-solid fa-user-md mb-3"></i>
                    <h5 class="mb-3">Doctor Consultation</h5>
                    <p class="flex-grow-1">
                        Get professional medical advice from certified doctors and specialists
                        through secure online consultations.
                    </p>
                    <a href="/doctors" class="btn-premium mt-auto">Find Doctors</a>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="feature-card h-100 d-flex flex-column align-items-center text-center">
                    <i class="fa-solid fa-robot mb-3"></i>
                    <h5 class="mb-3">AI Assistant</h5>
                    <p class="flex-grow-1">
                        Chat with our intelligent AI assistant to get instant answers to your
                        health-related questions.
                    </p>
                    <button class="btn-premium mt-auto">Talk to AI</button>
                </div>
            </div>
        </div>
    </div>
</section>



<div class="container mt-5 mb-5">
    <!-- Page Header -->
    <div class="page-header text-center mb-5">
        <h2>CLINIC MEDICAL SERVICES</h2>
        <p>
            Discover our range of in-clinic medical services designed to monitor your health
            and support early diagnosis and prevention.
        </p>
    </div>

<div class="container mt-5 mb-5">

    <div class="row g-4">
        @foreach ($services as $s)
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
                <div class="doctor-card h-100">
                    <div class="doctor-image-container">
                        <img src="{{ asset('images/services/' . $s->image) }}"
                             alt="{{ $s->name }}" class="doctor-image" loading="lazy">
                    </div>

                    <div class="doctor-card-body">
                        <h5 class="doctor-name">
                            <a href="#">
                                {{ $s->name }}
                            </a>
                        </h5>

                        <span class="consultation-price">Appointment: ${{ $s->price }}</span>

                        <p class="doctor-bio small">
                            {{ $s->description }}
                        </p>


                        <div class="action-buttons">
                            <a href="#" class="btn-book">
                                <i class="fa-solid fa-calendar-check me-1"></i> Book Service
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <a href="#" class="see-more-btn">See More Services</a>
</div>




<div class="container mt-5 mb-5">
    <input type="hidden" id="currentUserId" value="" />

    <div class="page-header text-center mb-5">
        <h2>DOCTORS</h2>
        <p>
            Connect with our team of highly qualified medical professionals for personalized consultations
            and expert care.
        </p>
    </div>

    <div class="row g-4">
        @foreach ($doctors as $d)
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
                <div class="doctor-card h-100">
                    <div class="doctor-image-container">
                        <img src="{{ asset('assets/images/user/avatar-1.jpg') }}"
                             alt="{{ $d->fullName }}" class="doctor-image" loading="lazy">
                    </div>

                    <div class="doctor-card-body">
                        <h5 class="doctor-name">
                            <a href="#">
                                {{ $d->fullName }}
                            </a>
                        </h5>

                        <div class="doctor-contact small">
                            <div><i class="fas fa-envelope me-2"></i> {{ $d->email }}</div>
                            <div><i class="fas fa-phone me-2"></i> 01002211345</div>
                        </div>

                        <span class="doctor-specialty">{{ $d->specialty }}</span>

                        <span class="consultation-price">Appointment: $10</span>

                        <p class="doctor-bio small">
                            {{ $d->bio }}
                        </p>

                        <div class="rating">
                            @for ($i = 1; $i <= 5; $i++)
                                @if ($i <= 4)
                                    <i class="fa-solid fa-star text-warning"></i>
                                @else
                                    <i class="fa-solid fa-star text-warning" style="opacity:0.3;"></i>
                                @endif
                            @endfor
                        </div>

                        <div class="action-buttons">
                            <a href="#" class="btn-book">
                                <i class="fa-solid fa-calendar-check me-1"></i> Book
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <a href="#" class="see-more-btn">See More Doctors</a>
</div>

<meta name="csrf-token" content="{{ csrf_token() }}">



@endsection


