    <footer class="footer-section">
      <div class="footer-container">
        <div class="footer-content">
          <div class="footer-col about">
            <h2 class="footer-logo">{{ config('app.name') }}</h2>
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
                <a href="/frontend/pages/home.html"
                  ><i class="fa-solid fa-chevron-right"></i> Home</a
                >
              </li>
              <li>
                <a href="/frontend/pages/home.html#features"
                  ><i class="fa-solid fa-chevron-right"></i> Features</a
                >
              </li>
              <li>
                <a href="/frontend/pages/all-services.html"
                  ><i class="fa-solid fa-chevron-right"></i> Services</a
                >
              </li>
              <li>
                <a href="/frontend/pages/all-doctors.html"
                  ><i class="fa-solid fa-chevron-right"></i> Doctors</a
                >
              </li>
              <li>
                <a href="#"
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
              <span>01276905241</span>
            </div>
            <div class="contact-item">
              <i class="fa-solid fa-envelope"></i>
              <span>Doctor122@gmail.com</span>
            </div>
            <div class="contact-item">
              <i class="fa-solid fa-location-dot"></i>
              <span>Tanta, Egypt</span>
            </div>

            <div class="social-icons">
              <a href="#"><i class="fa-brands fa-linkedin-in"></i></a>
              <a href="#"><i class="fa-brands fa-twitter"></i></a>
              <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
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

