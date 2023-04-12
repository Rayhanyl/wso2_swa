<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class ConfigurationController extends Controller
{   

    private $json_file = 'faqs.json';

    public function configuration_page(){
       return view('configuration.index');
    }

    public function faqs_page(){

        $faqs = json_decode(Storage::get($this->json_file))->list;
        return view('configuration.faq.index', compact('faqs'));
    }

    public function faqs_create(){
        return view('configuration.faq.create');
    }

    public function faqs_store(Request $request)
    {
        $faqs = json_decode(Storage::get($this->json_file), true);
        $faq = [
            'id' => count($faqs) + 1,
            'order' => $request->order,
            'order_flush' => $request->order_flush,
            'question' => $request->question,
            'answere' => null,
            'created_at' => date('d-m-Y')
        ];
        $faqs[] = $faq;
        Storage::put($this->json_file, json_encode($faqs));
        
        return redirect()->route('faqs.page');
    }
}
