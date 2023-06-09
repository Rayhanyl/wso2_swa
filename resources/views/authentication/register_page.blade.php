@extends('app')
@section('content')
<div class="bg-form">
  <div class="container">
      <div class="row">
          <div class="page-login col-12 col-lg-7 my-auto" data-aos="fade-right" data-aos-duration="1000">
              <img class="w-100" src="{{ asset ('assets/images/authentication/register.png') }}" alt="Login Picture">
          </div>
          <div class="page-login col-12 col-lg-5" data-aos="fade-down" data-aos-duration="1000">
              <div class="row">
                   <div class="col-12 fw-bold text-center fs-3 mb-3 mt-2">
                      Create your account
                   </div>
                   <div class="col-12 my-2">
                      <form class="row gx-3 gy-2" method="post" action="{{ route ('register') }}">
                          @csrf
                          <div class="col-md-6 @error('firstname') is-invalid @enderror">
                            <label for="firstname" class="form-label">First Name</label>
                            <input type="text" class="form-control text-capitalize" id="firstname" name="firstname" placeholder="Masukan nama depan anda">
                            @error('firstname')
                              <span class="text-danger">{{ $message }}</span>
                            @enderror
                          </div>
                          <div class="col-md-6 @error('lastname') is-invalid @enderror">
                            <label for="lastname" class="form-label">Last Name</label>
                            <input type="text" class="form-control text-capitalize" id="lastname" name="lastname" placeholder="Masukan nama belakang anda">
                            @error('lastname')
                              <span class="text-danger">{{ $message }}</span>
                            @enderror
                          </div>
                          <div class="col-12 @error('userlogin') is-invalid @enderror">
                            <label for="userlogin" class="form-label">Username</label>
                            <input type="text" class="form-control" id="userlogin" name="userlogin" placeholder="Masukan username anda">
                            @error('userlogin')
                              <span class="text-danger">{{ $message }}</span>
                            @enderror
                          </div>
                          <div class="col-12 @error('organization') is-invalid @enderror">
                            <label for="organization" class="form-label">Organization</label>
                            <input type="text" class="form-control text-capitalize" id="organization" name="organization" placeholder="Masukan nama organisasi anda">
                            @error('organization')
                              <span class="text-danger">{{ $message }}</span>
                            @enderror
                          </div>
                          <div class="col-12 @error('email') is-invalid @enderror">
                            <label for="email" class="form-label">Email</label>
                            <input type="text" class="form-control" id="email" name="email" placeholder="Masukan email anda">
                            @error('email')
                              <span class="text-danger">{{ $message }}</span>
                            @enderror
                          </div>
                          <div class="col-12 @error('telephone') is-invalid @enderror">
                            <label for="telephone" class="form-label">Telephone</label>
                            <input type="text" class="form-control" id="telephone" name="telephone" placeholder="Masukan nomer telephone anda">
                            @error('telephone')
                              <span class="text-danger">{{ $message }}</span>
                            @enderror
                          </div>
                          <div class="col-12 @error('address') is-invalid @enderror">
                            <label for="address" class="form-label">Address</label>
                            <textarea class="form-control" name="address" id="address" cols="10" rows="5"></textarea>
                            @error('address')
                              <span class="text-danger">{{ $message }}</span>
                            @enderror
                          </div>
                          <label for="password" class="form-label">Password</label>
                          <div class="col-12 input-group @error('password') is-invalid @enderror">
                            <input type="password" class="form-control" name="password" id="password" placeholder="Masukan password anda" style="border-right:0px solid">
                            <span class="input-group-text bg-white">
                              <i type="button" id="toggle-password" onclick="togglePassword()" class='bx bx-low-vision'></i>
                            </span>
                            @error('password')
                              <span class="text-danger">{{ $message }}</span>
                            @enderror
                          </div>
                          <label for="password_confirmation" class="form-label">Confirm Password</label>
                          <div class="col-12 input-group  @error('password_confirmation') is-invalid @enderror">
                            <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Confirmasi password anda" style="border-right:0px solid">
                            <span class="input-group-text bg-white">
                              <i type="button" id="toggle-password-confirm" onclick="toggleConfirm()" class='bx bx-low-vision'></i>
                            </span>
                            @error('password_confirmation')
                              <span class="text-danger">{{ $message }}</span>
                            @enderror
                          </div>
                          <div class="col-12 text-center">
                            <button type="submit" class="btn btn-warning rounded-4 text-white fw-bold px-5 py-2">Create your account</button>
                          </div>
                        </form>
                   </div>
                   <div class="col-12 my-3">
                      <p class="font-register-termservice">
                          By creating an account you agree to our 
                          <a class="text-warning" href="#">
                              Terms of Service 
                          </a>                        
                          and 
                          <a class="text-warning" href="#">
                              Privacy Policy
                          </a>
                      </p>
                   </div>
              </div>
          </div>
      </div>
  </div>
</div>

<script>
  function togglePassword() {
      var passwordField = document.getElementById("password");
      var toggleBtn = document.getElementById("toggle-password");
      if (passwordField.type === "password") {
          passwordField.type = "text";
      } else {
          passwordField.type = "password";
      }
  }

  function toggleConfirm() {
      var passwordField = document.getElementById("password_confirmation");
      var toggleBtn = document.getElementById("toggle-password-confirm");
      if (passwordField.type === "password") {
          passwordField.type = "text";
      } else {
          passwordField.type = "password";
      }
  }
</script>

@endsection



