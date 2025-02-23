<!doctype html>
<html lang="en">
  <!--begin::Head-->
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>AdminLTE 4 | Register Page v2</title>
    <!--begin::Primary Meta Tags-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="title" content="AdminLTE 4 | Register Page v2" />
    <meta name="author" content="ColorlibHQ" />
    <meta
      name="description"
      content="AdminLTE is a Free Bootstrap 5 Admin Dashboard, 30 example pages using Vanilla JS."
    />
    <meta
      name="keywords"
      content="bootstrap 5, bootstrap, bootstrap 5 admin dashboard, bootstrap 5 dashboard, bootstrap 5 charts, bootstrap 5 calendar, bootstrap 5 datepicker, bootstrap 5 tables, bootstrap 5 datatable, vanilla js datatable, colorlibhq, colorlibhq dashboard, colorlibhq admin dashboard"
    />
    @include('partials.style')
  </head>
  <!--end::Head-->
  <!--begin::Body-->
  <body class="register-page bg-body-secondary">
    <div class="register-box">
      <!-- /.register-logo -->
      <div class="card card-outline card-primary">
        <div class="card-header">
          <a
            href="../index2.html"
            class="link-dark text-center link-offset-2 link-opacity-100 link-opacity-50-hover"
          >
            <h1 class="mb-0"><b>Admin</b>LTE</h1>
          </a>
        </div>
        <div class="card-body register-card-body">
          <p class="register-box-msg">Register a new membership</p>
          <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="input-group mb-1">
              <div class="form-floating">
                <input id="name" type="text" class="form-control" placeholder="" name="name" :value="old('name')" required autofocus autocomplete="name" />
                <label for="name">Full Name</label>
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
              </div>
              <div class="input-group-text"><span class="bi bi-person"></span></div>
            </div>
            <div class="input-group mb-1">
              <div class="form-floating">
                <input id="email" type="email" class="form-control" placeholder="" name="email" :value="old('email')" required autocomplete="username"/>
                <label for="email" >Email</label>
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
              </div>
              <div class="input-group-text"><span class="bi bi-envelope"></span></div>
            </div>
            <div class="input-group mb-1">
              <div class="form-floating">
                <input id="password" type="password" class="form-control" placeholder="" name="password"
                required autocomplete="new-password" />
                <label for="registerPassword">Password</label>
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
              </div>
              <div class="input-group-text"><span class="bi bi-lock-fill"></span></div>
            </div>
            <div class="input-group mb-1">
                <div class="form-floating">
                  <input id="password_confirmation" type="password" class="form-control" placeholder="" name="password_confirmation" required autocomplete="new-password" />
                  <label for="registerPassword">Password Confirmation</label>
                  <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>
                <div class="input-group-text"><span class="bi bi-lock-fill"></span></div>
              </div>
            <!--begin::Row-->
            <div class="row">
              <div class="col-8 d-inline-flex align-items-center">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" required />
                  <label class="form-check-label" for="flexCheckDefault">
                    I agree to the <a href="#">terms</a>
                  </label>
                </div>
              </div>
              <!-- /.col -->
              <div class="col-4">
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">{{ __('Register') }}</button>
                </div>
                
              </div>
              <!-- /.col -->
            </div>
            <!--end::Row-->
          </form>
          <div class="social-auth-links text-center mb-3 d-grid gap-2">
            <p>- OR -</p>
            <a href="#" class="btn btn-primary">
              <i class="bi bi-facebook me-2"></i> Sign in using Facebook
            </a>
            <a href="#" class="btn btn-danger">
              <i class="bi bi-google me-2"></i> Sign in using Google+
            </a>
          </div>
          <!-- /.social-auth-links -->
          <p class="mb-0">
            {{-- <a href="login.html" class="link-primary text-center"> I already have a membership </a> --}}
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>
          </p>
        </div>
        <!-- /.register-card-body -->
      </div>
    </div>
    <!-- /.register-box -->
    <!--begin::Third Party Plugin(OverlayScrollbars)-->
    @include('partials.script')
    <!--end::Script-->
  </body>
  <!--end::Body-->
</html>
