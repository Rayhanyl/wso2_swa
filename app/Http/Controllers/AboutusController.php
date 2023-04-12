<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AboutusController extends Controller
{
    public function aboutusPage(){
        return view('aboutus.index');
    }
}
