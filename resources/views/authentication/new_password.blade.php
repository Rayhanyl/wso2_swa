@extends('app')
@section('content')

@if ($status == '400')
<div class="bg-invalid-code row text-center g-0">
    <div class="col-12">
        <p class="font-invalid-code">{{ $invalid }}</p>
    </div>
    <div class="col-12 img-invalid-code">
        <img class="" src="{{ asset ('assets/images/authentication/invalid-code.png') }}" alt="Invalid Code">
    </div>
</div>
@else
<div class="bg-form">
    <div class="container">
        <div class="row">
            <div class="page-login col-12 col-lg-7">
                <img class="w-100" src="{{ asset ('assets/images/authentication/reset.png') }}" alt="Login Picture">
            </div>
            <div class="page-login col-12 col-lg-5">
                <div class="row">
                    <div class="col-12 my-2">
                        <p class="fw-bold text-center fs-3">
                            Reset Password
                        </p>
                        <p class="text-center">
                            Create a new password below to change your password
                        </p>
                     </div>
                     <div class="col-12 my-2">
                        <form class="row" action="{{ route ('resetpassword') }}" method="POST">
                            @csrf
                            <input type="hidden" name="confirmation" value="{{ $confirmation }}">
                            <label for="password" class="form-label">Password</label>
                            <div class="col-12 mb-4 mt-2 input-group @error('password') is-invalid @enderror">
                                <input type="password" class="form-control" name="password" id="password" placeholder="Masukan password anda" style="border-right:0px solid">
                                <span class="input-group-text bg-white">
                                    <i type="button" id="toggle-password" onclick="togglePassword()" class='bx bx-low-vision'></i>
                                </span>
                                @error('password')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <label for="password_confirmation" class="form-label">Konfrimasi Password</label>
                            <div class="col-12 mb-4 mt-2 input-group @error('password_confirmation') is-invalid @enderror">
                                <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Masukan kembali password anda" style="border-right:0px solid">
                                <span class="input-group-text bg-white">
                                    <i type="button" id="toggle-password-confirm" onclick="toggleConfirm()" class='bx bx-low-vision'></i>
                                </span>
                                @error('password_confirmation')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-warning nav-btn-login text-light rounded-4 " type="button">Reset password</button>
                            </div>
                        </form>
                     </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

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