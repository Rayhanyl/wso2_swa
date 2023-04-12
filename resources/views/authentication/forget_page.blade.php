@extends('app')
@section('content')

<div class="bg-form">
    <div class="container">
        <div class="row">
            <div class="page-login col-12 col-lg-6" data-aos="fade-right" data-aos-duration="1000">
                <img class="w-100" src="{{ asset ('assets/images/authentication/forget.png') }}" alt="Login Picture">
            </div>
            <div class="page-login card-form col-12 col-lg-5 my-auto" data-aos="fade-left" data-aos-duration="1000">
                <div class="row justify-content-center">
                     <div class="col-12 my-2">
                        <p class="fw-bold text-center fs-3">
                            Forget Password
                        </p>
                        <p class="text-center">
                            Please enter your username and we’ll send you instructions on how to reset your password
                        </p>
                     </div>
                     <div class="col-10 my-2">
                        <form class="row text-center" method="post" action="{{ route ('sendmail') }}">
                            @csrf
                            <div class="mb-4">
                              <input type="text" class="form-control" id="username" name="username" placeholder="Masukan username" aria-describedby="username" required>
                            </div>
                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-warning rounded-4 text-white fw-bold px-5 py-2">&nbsp; &nbsp;  &nbsp; &nbsp; Submit &nbsp; &nbsp; &nbsp; &nbsp;</button>
                            </div>
                        </form>
                     </div>
                     <div class="col-12 text-center my-3">
                        <p>Don’t have an Account?
                            <a href="{{ route ('register.page') }}" class="text-warning">
                                Register Now
                            </a>
                        </p>
                     </div>
                </div>
            </div>
            <div class="col-1">

            </div>
        </div>
    </div>
</div>

@endsection



