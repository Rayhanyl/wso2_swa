@extends('app')
@section('content')

<div class="container">
    <div class="warp-content my-5">
        <div class="row">
            <div class="col-12 col-lg-7">
                <img class="w-100" src="{{ asset ('assets/images/login/login_picture.png') }}" alt="Login Picture">
            </div>
            <div class="col-12 col-lg-5">
                <div class="mb-5">
                    <h2 class="fw-bold text-center">Welcome To Asabri API !</h2>
                </div>
                <div class="col-12">
                    <form class="row" method="post" action="">
                        <div class="mb-3">
                          <label for="exampleInputEmail1" class="form-label">Username</label>
                          <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                        </div>
                        <div class="mb-3">
                          <label for="exampleInputPassword1" class="form-label">Password</label>
                          <input type="password" class="form-control" id="exampleInputPassword1">
                          <div id="emailHelp" class="form-text">We'll never share your password with anyone else.</div>
                        </div>
                        <div class="mb-3 d-flex justify-content-center">
                            <div class="g-recaptcha" data-sitekey="{{ env('GOOGLE_RECAPTCHA_KEY') }}"></div>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-warning nav-btn-login text-light rounded-4 " type="button">Masuk</button>
                        </div>
                    </form>
                </div>
                <div class="col-12 row mt-4">
                    <div class="col-7">
                        <p>Don’t have an Account?
                            <a href="#" class="text-warning">
                                Register Now!
                            </a>
                        </p>
                    </div>
                    <div class="col-5 text-end">
                    <p>
                        <a href="#" class="text-warning text-end">
                            Forgot Password?    
                        </a> 
                    </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection



