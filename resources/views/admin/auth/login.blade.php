<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="favicon.ico">
    <title>{{ config('app.name') }} - Admin Login</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Overpass:ital,wght@0,400;0,600;0,800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('admin-assets') }}/css/feather.css">
    <link rel="stylesheet" href="{{ asset('admin-assets') }}/css/app-light.css" id="lightTheme">
    
    <style>
      .alert-error-custom {
          border: none;
          background-color: #f8d7da;
          color: #721c24;
          border-radius: 8px;
          text-align: left;
          font-size: 0.85rem;
          padding: 15px; /* زيادة الحشو قليلاً عشان الزرار */
          position: relative;
      }
      .alert-error-custom ul {
          margin-bottom: 0;
          padding-left: 18px;
      }
      /* تنسيق زر الإغلاق ليكون شكله لطيف */
      .close-custom {
          position: absolute;
          top: 8px;
          right: 12px;
          background: none;
          border: none;
          color: #721c24;
          font-size: 20px;
          line-height: 1;
          opacity: 0.5;
          cursor: pointer;
      }
      .close-custom:hover {
          opacity: 1;
      }
    </style>
  </head>
  <body class="light">
    <div class="wrapper vh-100">
      <div class="row align-items-center h-100 m-0">
        <form class="col-lg-3 col-md-4 col-10 mx-auto text-center" action="{{ route('admin.login') }}" method="POST">
          @csrf

          <a class="navbar-brand mx-auto mt-2 flex-fill text-center" href="#">
            <svg version="1.1" id="logo" class="navbar-brand-img brand-md" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 120 120">
              <g>
                <polygon class="st0" points="78,105 15,105 24,87 87,87" />
                <polygon class="st0" points="96,69 33,69 42,51 105,51" />
                <polygon class="st0" points="78,33 15,33 24,15 87,15" />
              </g>
            </svg>
          </a>
          
          <h1 class="h6 mb-3"> Admin Login </h1>

          @if ($errors->any()) 
            <div class="alert alert-error-custom alert-dismissible fade show mb-3 shadow-sm" role="alert">
              <div class="d-flex align-items-center mb-1">
                <i class="fe fe-alert-circle fe-16 mr-2"></i>
                <strong>Hold on!</strong>
              </div>
              <ul>
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
              <button type="button" class="close-custom" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>        
          @endif

          <div class="form-group">
            <label for="inputEmail" class="sr-only">Email address</label>
            <input type="email" id="inputEmail" name="email" class="form-control form-control-lg" placeholder="Email address" required autofocus value="{{ old('email') }}">
          </div>

          <div class="form-group">
            <label for="inputPassword" class="sr-only">Password</label>
            <input type="password" id="inputPassword" name="password" class="form-control form-control-lg" placeholder="Password" required>
          </div>

          <div class="checkbox mb-3 text-center">
            <label>
              <input type="checkbox" value="remember-me" name="remember" {{ old('remember') ? 'checked' : '' }}> 
              <span class="small text-muted ">Stay logged in</span>
            </label>
          </div>

          <button class="btn btn-lg btn-primary btn-block shadow" type="submit">Let me in</button>
          
          <p class="mt-5 mb-3 text-muted">© {{ date('Y') }} {{ config('app.name') }}</p>
        </form>
      </div>
    </div>

    <script src="{{ asset('admin-assets') }}/js/jquery.min.js"></script>
    <script src="{{ asset('admin-assets') }}/js/bootstrap.min.js"></script>
    <script src="{{ asset('admin-assets') }}/js/apps.js"></script>
  </body>
</html>