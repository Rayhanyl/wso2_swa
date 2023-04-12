<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class QuestionController extends Controller
{

    public function questionPage(){

        $faqs = json_decode(Storage::get('faqs.json'))->list;
        return view('question.index', compact('faqs'));

        // $jsonData = file_get_contents(public_path('json/about.json'));
        // $data = json_decode($jsonData);
        // return view('question.index', compact('data'));
    }
}
