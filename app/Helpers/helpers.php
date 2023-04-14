<?php

use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;

function getToken()
{
    return session()->get('token');
}

function getUrlApi(){
    $url_api = env('API');
    return $url_api;
}

function getUrl($url_api)
{
    $response = Http::withOptions(['verify' => false])
        ->withHeaders([
            'Authorization' => 'Bearer '.session()->get('token'),
            'Accept' => 'application/json',
        ])
        ->get($url_api);
    if($response->status() == 200){
        return json_decode($response->getBody()->getContents());
    }
    return [];
}

function getApiDocumentation($url_api)
{
    $response = Http::withOptions(['verify' => false])
    ->withHeaders([
        'Accept' => 'application/json',
    ])
    ->get($url_api);
    
    if($response->status() == 200){
        return json_decode($response->getBody()->getContents());
    }
    return [];
}

function getUrlLogin()
{
    $url = env('API_LOGIN');
    return $url;
}

function getUrlRegister()
{
    $url = env('API_REGISTER');
    return $url;
}

function getUrlEmail()
{
    $url = env('GET_USER');
    return $url;
}

function getUrlEmails($url)
{
        $response = Http::withBasicAuth('admin', 'admin')
        ->withOptions(['verify' => false])
        ->withHeaders([
            'Authorization' => 'Basic YWRtaW46YWRtaW4=',
            'Accept' => 'application/json',
        ])
        ->get($url);
    if($response->status() == 200){
        return json_decode($response->getBody()->getContents());
    }
    return [];
}