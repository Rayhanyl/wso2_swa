<?php

namespace App\Http\Controllers;
use RealRashid\SweetAlert\Facades\Alert;
use App\Mail\Email;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class SendMailController extends Controller
{
    public function __construct()
    {
        $this->url = getUrlEmail();
    }

    public function sendmail(Request $request)
    {
        $username = base64_encode($request->username);
        $userinfo =  getUrlEmails($this->url .'/pi-info/'. $username);
        if ($userinfo == null) {

            Alert::warning('Warning', 'Username tidak ditemukan !');
            return back()->with('warning', 'User tidak ada');
        }
        
        $user = (array) $userinfo->basic;
        
        $payloads = [
            'user' => [
                'username' => $request->username,
                'realm' => 'PRIMARY',
                'tenant-domain' => 'carbon.super',
            ],
            'properties' => [],
        ];

        $response = Http::withOptions(['verify' => false])
        ->withBasicAuth('admin', 'admin')
        ->withHeaders([
            'Authorization' => 'Basic YWRtaW46YWRtaW4=',
            'Accept' => '*/*',
        ])
        ->withBody(json_encode($payloads),'application/json')
        ->post('https://apim.belajarwso2.com/t/carbon.super/api/identity/recovery/v0.9/recover-password?type=EMAIL&notify=false');
        $data = $response->getBody()->getContents();
        
        $mailData = [
            "name" => $user['http://wso2.org/claims/username'],
            "date" => Carbon::now(),
            "code" => $data,
            "url" => 'http://127.0.0.1:8000/',
        ];

        Mail::to($user['http://wso2.org/claims/emailaddress'])->send(new Email($mailData));
        Alert::success('Success', 'Silahkan cek email anda');
        return redirect(route ('login.page'))->with('success', 'Berhasil mengirim email');
    }
}
