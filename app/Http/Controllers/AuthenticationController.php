<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;

class AuthenticationController extends Controller
{
    public function loginPage(){
        return view('authentication.login_page');
    }

}
