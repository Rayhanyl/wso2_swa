@extends('app')
@section('content')

<div class="bg-form">
    <div class="container">
        <div class="row">
            <div class="page-login col-12 col-lg-7">
                <img class="w-100" src="{{ asset ('assets/images/authentication/login.png') }}" alt="Login Picture">
            </div>
            <div class="page-login col-12 col-lg-5">
                <div class="row">
                     <div class="col-12 fw-bold text-center fs-3 my-3">
                        Welcome To ASABRI API !
                     </div>
                     <div class="col-12 my-2">
                        <form class="row" action="{{ route ('authentication') }}"
                        method="POST">
                            
                            @csrf
                            <div class="mb-3 @error('username') is-invalid @enderror">
                              <label for="username" class="form-label">Username</label>
                              <input type="text" class="form-control" id="username" name="username" aria-describedby="username" required>
                              @error('username')
                              <span class="text-danger">{{ $message }}</span>
                              @enderror
                            </div>
                            
                            <div class="mb-3 @error('password') is-invalid @enderror">
                              <label for="password" class="form-label">Password</label>
                              <input type="password" class="form-control" id="password" name="password" required>
                              <div id="password" class="form-text">We'll never share your password with anyone else.</div>
                              @error('password')
                              <span class="text-danger">{{ $message }}</span>
                              @enderror
                            </div>
                            
                            <div class="mb-3 d-flex justify-content-center">
                                <div class="g-recaptcha" data-sitekey="{{ env('GOOGLE_RECAPTCHA_KEY') }}"></div>
                            </div>
                            <div class="text-center my-2">
                                @if ($errors->has('g-recaptcha-response'))
                                    <span class="text-danger">{{ $errors->first('g-recaptcha-response') }}</span>
                                @endif
                            </div>
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-warning nav-btn-login text-light rounded-4 " type="button">Masuk</button>
                            </div>
                        </form>
                     </div>
                     <div class="col-12 my-3">
                        <div class="row">
                            <div class="col-7">
                                <p>Don’t have an Account?
                                    <a href="{{ route ('register.page') }}" class="text-warning">
                                        Register Now!
                                    </a>
                                </p>
                            </div>
                            <div class="col-5 text-end">
                            <p>
                                <a href="{{ route ('forgot.password.page') }}" class="text-warning text-end">
                                    Forgot Password?    
                                </a> 
                            </p>
                            </div>
                        </div>
                     </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection



