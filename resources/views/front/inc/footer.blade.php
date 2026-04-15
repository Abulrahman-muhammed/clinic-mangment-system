    @php
        $generalSettings = app(App\Settings\GeneralSettings::class);
    @endphp
    <footer class="footer-section">
      <div class="footer-container">
        <div class="footer-content">
          <div class="footer-col about">
            <h2 class="footer-logo">{{ $generalSettings->site_name }}</h2>
            <p class="description">
              Your trusted medical companion for medicines, doctor
              consultations, and AI-powered medical assistance.
            </p>
          </div>

          <div class="footer-col links">
            <h3>Quick Links</h3>
            <div class="underline"><span></span></div>
            <ul>
              <li>
                <a href="{{ url('/') }}"
                  ><i class="fa-solid fa-chevron-right"></i> Home</a
                >
              </li>
              <li>
                <a href="{{ url('/') }}#features"
                  ><i class="fa-solid fa-chevron-right"></i> Features</a
                >
              </li>
              <li>
                <a href="{{ route('front.services.index') }}"
                  ><i class="fa-solid fa-chevron-right"></i> Services</a
                >
              </li>
              <li>
                <a href="{{ route('front.doctors') }}"
                  ><i class="fa-solid fa-chevron-right"></i> Doctors</a
                >
              </li>
              <li>
                <a href="{{ route('front.about') }}"
                  ><i class="fa-solid fa-chevron-right"></i> About Us</a
                >
              </li>
            </ul>
          </div>

          <div class="footer-col contact">
            <h3>Contact info</h3>
            <div class="underline"><span></span></div>
            <div class="contact-item">
              <i class="fa-solid fa-phone"></i>
              <span>{{ $generalSettings->site_phone }}</span>
            </div>
            <div class="contact-item">
              <i class="fa-solid fa-envelope"></i>
              <span>{{ $generalSettings->site_email }}</span>
            </div>
            <div class="contact-item">
              <i class="fa-solid fa-location-dot"></i>
              <span>{{ $generalSettings->site_address }}</span>
            </div>

            <div class="social-icons">
              <a href="{{ $generalSettings->linkedin_url }}" target="_blank"><i class="fa-brands fa-linkedin-in"></i></a>
              <a href="{{ $generalSettings->twitter_url }}" target="_blank"><i class="fa-brands fa-twitter"></i></a>
              <a href="{{ $generalSettings->facebook_url }}" target="_blank"><i class="fa-brands fa-facebook-f"></i></a>
              <a href="{{ $generalSettings->instagram_url }}" target="_blank"><i class="fa-brands fa-instagram"></i></a>
            </div>
          </div>
        </div>

        <div class="footer-bottom">
          <p>
            Copyright &copy; {{ date('Y')  }} - {{ config('app.name') }}. All Rights Reserved. | Your Health, Our Priority
          </p>
        </div>
      </div>
      
    </footer>

