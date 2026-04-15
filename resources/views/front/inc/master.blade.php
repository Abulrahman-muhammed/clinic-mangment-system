<!doctype html>
<html lang="en">
@include('front.inc.head')

<body>
    <!-- navbar -->
    @include('front.inc.navbar')

    @yield('content')
    <!-- footer -->
    @include('front.inc.footer')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
z    <script>
AOS.init({
    duration: 800, // سرعة الأنيميشن بالملي ثانية
    once: true,    // الأنيميشن يحدث مرة واحدة فقط عند التمرير لأسفل
  });
    </script>



{{-- Pass user ID to JS --}}
<script>
    window._authUserId = {{ auth()->id() }};


</script>
     
{{-- Vite assets (لو مش موجود خليه) --}}
@vite(['resources/js/app.js'])
 
    @stack('scripts')



</body>

</html>
