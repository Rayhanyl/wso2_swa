<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redis;

class DocumentationController extends Controller
{

    public function __construct()
    {   
        $this->url_api = getUrlApi();
    }

    public function documentationPage (){

        return view('documentation.index');
    }

    public function listApi (Request $request){

        $listapi = getApiDocumentation($this->url_api . '/apis?query='.$request->name_api);        
        $listapipublish = collect($listapi->list)->where('lifeCycleStatus', 'PUBLISHED')->all();

        return view('documentation.list-api', compact('listapipublish'));
    }

    public function resultDocumentation(Request $request){
        
        $detailapi = getApiDocumentation($this->url_api . '/apis/'.$request->id_api); 
        $listdocument = getApiDocumentation($this->url_api . '/apis/'.$request->id_api.'/documents');
        
        $listinline = collect($listdocument->list)->where('sourceType', 'INLINE')->first();
        $listmarkdown = collect($listdocument->list)->where('sourceType', 'MARKDOWN')->first();


        if ($listinline != null) {
            $response1 = Http::withOptions(['verify' => false])
            ->get('https://103.164.54.199:9443/api/am/devportal/v2.1/apis/'.$request->id_api.'/documents/'.$listinline->documentId.'/content');
            $inline = $response1->getBody()->getContents();
        }else{
            $inline = [];
        }

        if ($listmarkdown != null) {
            $response2 = Http::withOptions(['verify' => false])
            ->get('https://103.164.54.199:9443/api/am/devportal/v2.1/apis/'.$request->id_api.'/documents/'.$listmarkdown->documentId.'/content');
            $markdown = $response2->getBody()->getContents();
        }else{
            $markdown = [];
        }

        return view('documentation.result-document', compact('detailapi','markdown','inline'));
    }

    public function loadimgapi(Request $request){

        $response = Http::withOptions(['verify' => false])
        ->withHeaders([
            'Accept' => '*/*',
        ])
        ->get($this->url_api .'/apis/'.$request->id.'/thumbnail');

        $data = $response->getBody()->getContents();
        $base64 = base64_encode($data);
        $mime = "image/jpeg";
        $img = ('data:' . $mime . ';base64,' . $base64);
                
        return "<img class='img-thumbnail rounded' width='150' height='150' src=$img alt='ok' >";
    }
}
