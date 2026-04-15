<!doctype html>
<html lang="en">

@include('admin.partials.head')


<body class="vertical  light">
    <div class="wrapper">
        @include('admin.partials.navbar')

        @if(auth()->user()->hasRole('doctor'))
        @include('admin.partials.doctor_sidebar')
        @else
        @include('admin.partials.sidebar')
        @endif

        <main role="main" class="main-content">
            @yield('content')
        </main> <!-- main -->

    </div> <!-- .wrapper -->
    @include('admin.partials.scripts')



{{-- Pass user ID to JS --}}
<script>
    window._authUserId = {{ auth()->id() }};
</script>
     
{{-- Vite assets (لو مش موجود خليه) --}}
@vite(['resources/js/app.js'])
 
{{-- Animations + soft colors --}}
<style>
    @keyframes slideInRight {
        from { transform: translateX(100%); opacity: 0; }
        to   { transform: translateX(0);   opacity: 1; }
    }
    @keyframes fadeOut {
        to { opacity: 0; transform: translateX(20px); }
    }
    .bg-soft-primary { background-color: rgba(27,104,255,.06); }
    .bg-soft-success { background-color: rgba(40,167,69,.1);  }
    .bg-soft-info    { background-color: rgba(23,162,184,.1); }
    .bg-soft-warning { background-color: rgba(255,193,7,.1);  }
    .bg-soft-danger  { background-color: rgba(220,53,69,.1);  }
</style>
</body>