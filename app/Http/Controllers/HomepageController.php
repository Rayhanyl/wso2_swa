<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HomepageController extends Controller
{

    public function __construct()
    {
        $this->url = getUrlApi();
    }

    public function homePage(){

        $tags = 'frontend';
        $listapi = getApiDocumentation($this->url .'/apis?query=tag:'.$tags.'&limit=6');

        return view('home.home_page', compact('listapi'));
    }

    
    public function loadimgapi(Request $request)
    {
        $response = Http::withOptions(['verify' => false])
        ->withHeaders([
            'Accept' => '*/*',
        ])
        ->get($this->url .'/apis/'.$request->id.'/thumbnail');

        $data = $response->getBody()->getContents();
        $base64 = base64_encode($data);
        $mime = "image/jpeg";
        $img = ('data:' . $mime . ';base64,' . $base64);
                
        return "<img class='rounded-circle' width='50' height='50' src=$img alt='ok' >";
    }
}
