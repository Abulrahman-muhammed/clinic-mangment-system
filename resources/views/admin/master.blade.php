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
