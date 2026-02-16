<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>ClickClinic</title>

    <!-- Fonts & Icons -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom Styles -->
    <!-- Add your css link here, e.g. asset('css/styles.css') -->
    <link rel="stylesheet" href="{{ asset('FrontAssets/css/styles.css') }}" />
    @yield('styles')
</head>
<body class="d-flex flex-column min-vh-100">

    <!-- Header -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container-fluid">
            <!-- Brand -->
            <a class="navbar-brand" href="#">ClickClinic</a>

            <!-- Mobile Toggler aligned right -->
            <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false"
                    aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Center Menu -->
            <div class="collapse navbar-collapse center-menu" id="navbarContent">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link" href="#">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#features">Features</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Services</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Departments</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Doctors</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Contact</a></li>
                </ul>

                <!-- Mobile actions -->
                <div class="d-lg-none mt-2 pt-2" style="border-top: 1px solid var(--light-border);">

                    <a class="nav-link px-0" href="#">
                        <i class="fa-solid fa-user me-2 text-primary"></i>Profile
                    </a>
                </div>
            </div>

            <!-- Right Menu - Fixed Dropdowns -->
            <div class="right-menu">
                <ul class="navbar-nav flex-row">
                    <!-- Profile Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link nav-icon" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-user"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                            @guest
                                <a class="dropdown-item" href="#">
                                    <i class="fa-solid fa-sign-in-alt"></i> Login
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fa-solid fa-user-plus"></i> Register
                                </a>
                            @else
                                <div class="px-3 py-2 text-center mb-2">
                                    <div class="profile-icon mx-auto mb-2" style="width:50px;height:50px;border-radius:50%;overflow:hidden;background:#f0f0f0;">
                                        <!-- User Image -->
                                        <img src="#" alt="Profile" class="img-fluid" />
                                    </div>
                                    <h6 class="mb-0">{{ Auth::user()->name }}</h6>
                                    <small class="d-block text-muted">{{ Auth::user()->email }}</small>
                                    <small class="d-block text-secondary">
                                        <!-- User Role Logic Here -->
                                        User Role
                                    </small>
                                </div>
                                <hr class="dropdown-divider">

                                <!-- Admin Role Check -->
                                @if(false) 
                                    <a class="dropdown-item" href="#">
                                        <i class="fa-solid fa-tachometer-alt text-primary"></i> Dashboard
                                    </a>
                                <!-- Patient Role Check -->
                                @elseif(false)
                                    <a class="dropdown-item" href="#">
                                        <i class="fa-solid fa-calendar-check text-primary"></i> Appointments
                                    </a>
                                <!-- Doctor Role Check -->
                                @elseif(false)
                                    <a class="dropdown-item" href="#">
                                        <i class="fa-solid fa-calendar-check text-primary"></i> MyAppointments
                                    </a>
                                @endif

                                <hr class="dropdown-divider">

                                <!-- Logout Form -->
                                <form action="#" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="fa-solid fa-sign-out-alt"></i> Logout
                                    </button>
                                </form>
                            @endguest
                        </div>
                    </li>

                </ul>
            </div>
        </div>
    </nav>

    <!-- MAIN -->
    <main>
        @yield('content')
    </main>

    <!-- Enhanced Footer -->
    <footer class="mt-auto position-relative">
        <div class="footer-floating"></div>
        <div class="footer-floating"></div>
        <div class="container">
            <div class="footer-content">
                <div class="footer-brand">
                    <div class="footer-logo">ClickClinic</div>
                    <p class="footer-description">
                        Your trusted medical companion for medicines, doctor consultations,
                        and AI-powered medical assistance.
                    </p>
                </div>

                <div class="footer-column">
                    <h4>Quick Links</h4>
                    <ul class="footer-links">
                        <li><a href="#"> <i class="fas fa-chevron-right"></i> Home</a></li>
                        <li><a href="#features"> <i class="fas fa-chevron-right"></i> Features</a></li>
                        <li><a href="#"> <i class="fas fa-chevron-right"></i> Medicines</a></li>
                        <li><a href="#"> <i class="fas fa-chevron-right"></i> Doctors</a></li>
                        <li><a href="#"> <i class="fas fa-chevron-right"></i> About Us</a></li>
                    </ul>
                </div>

                <div class="footer-column">
                    <h4>Contact Info</h4>
                    <div class="footer-contact">
                        <p><i class="fas fa-envelope"></i> aklahmed535@gmail.com</p>
                        <p><i class="fas fa-phone"></i> +20 1220483577</p>
                        <p><i class="fas fa-map-marker-alt"></i> Mansoura, Egypt</p>
                    </div>
                    <div class="footer-social">
                        <a href="#" target="_blank"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" target="_blank"><i class="fab fa-twitter"></i></a>
                        <a href="#" target="_blank"><i class="fa-brands fa-github"></i></a>
                        <a href="#" target="_blank"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
            </div>

            <div class="footer-bottom">
                <p>&copy; {{ date('Y') }} ClickClinic. All Rights Reserved. | Your Health, Our Priority</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Initialize Bootstrap dropdowns
        document.addEventListener('DOMContentLoaded', function() {
            var dropdownElementList = [].slice.call(document.querySelectorAll('.dropdown-toggle'))
            var dropdownList = dropdownElementList.map(function (dropdownToggleEl) {
                return new bootstrap.Dropdown(dropdownToggleEl)
            });

            // Close dropdowns when clicking outside
            document.addEventListener('click', function (event) {
                var isDropdown = event.target.matches('.dropdown-toggle') ||
                                 event.target.closest('.dropdown-toggle') ||
                                 event.target.matches('.dropdown-menu') ||
                                 event.target.closest('.dropdown-menu');

                if (!isDropdown) {
                    dropdownList.forEach(function(dropdown) {
                        dropdown.hide();
                    });
                }
            });
        });

        // Set up CSRF Token for AJAX requests
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        async function refreshCart() {
            try {
                // ADD YOUR URL HERE
                const countRes = await fetch("#");
                const countData = await countRes.json();
                document.getElementById('cart-count').innerText = countData.count;

                // ADD YOUR URL HERE
                const dropdownRes = await fetch("#");
                const dropdownHtml = await dropdownRes.text();
                document.getElementById('cart-dropdown-items').innerHTML = dropdownHtml;
            } catch (error) {
                console.error('Error refreshing cart:', error);
            }
        }

        async function addToCart(medicineId, quantity = 1) {
            try {
                // ADD YOUR URL HERE
                const res = await fetch("#", {
                    method: 'POST',
                    headers: { 
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken 
                    },
                    body: JSON.stringify({ MedicineId: medicineId, Quantity: quantity })
                });

                const data = await res.json();
                if (data.success) {
                    await refreshCart();
                } else {
                    alert("Failed to add to cart");
                }
            } catch (error) {
                console.error('Error adding to cart:', error);
                alert("An error occurred while adding to cart");
            }
        }

        // Attach events
        document.addEventListener("DOMContentLoaded", () => {
            document.querySelectorAll('.add-to-cart-btn').forEach(btn => {
                btn.addEventListener('click', () => {
                    const medicineId = btn.dataset.medicineId;
                    addToCart(medicineId);
                });
            });

            refreshCart();
        });
    </script>
    @stack('scripts')
</body>
</html>
