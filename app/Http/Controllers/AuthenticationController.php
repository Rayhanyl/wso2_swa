<?php

namespace App\Http\Controllers;
use App\Rules\ReCaptcha;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

class AuthenticationController extends Controller
{

    public function __construct(){
        $this->url_register = getUrlRegister();
        $this->url_login = getUrlLogin();
        $this->url_email = getUrlEmail();
    }

    public function loginPage(){
        return view('authentication.login_page');
    }

    public function registerPage(){
        return view('authentication.register_page');
    }

    public function forgotPasswordPage(){
        return view('authentication.forget_page');
    }

    public function authentication(Request $request){

        $username = base64_encode($request->username);
        $userinfo =  getUrlEmails($this->url_email .'/pi-info/'. $username);
        $data = collect($userinfo->basic);

        $exploded = explode(',', $data['http://wso2.org/claims/role']);
        if (in_array('Internal/admin',$exploded)) {
            $role = 'admin';
        }else{
            $role = 'customer';
        }
        
        if ($userinfo != null) {
            $user = (array) $userinfo->basic;
        }else{

            Alert::warning('Warning', 'Username doesnt exist');
            return redirect()->back()->with('warning', 'Username doesnt exist');
        }
         
        $validator = Validator::make($request->all(), [

            'username'              => 'required',
            'password'              => 'required',
            'g-recaptcha-response' => ['required', new ReCaptcha],

        ],[
            'username' => 'Username form cannot be empty',
            'password' => 'The password form cannot be empty',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }else{

                $payloads = [
                    'grant_type' => 'password',
                    'username' => $request->username,
                    'password' => $request->password,
                    'scope' => 'apim:admin apim:api_key apim:app_import_export apim:app_manage apim:store_settings apim:sub_alert_manage apim:sub_manage apim:subscribe openid apim:subscribe'
                ];

                $response = Http::withOptions(['verify' => false])
                ->withHeaders([
                    'Authorization' => 'Basic ckJpNTJRa1QyT0dTUjk5a0R6TTVPMGtRT253YToxdXY5UmI4UjBRZWZLaEVkSExDaDBNbUZUamNh',
                ])
                ->withBody(json_encode($payloads),'application/json')
                ->post($this->url_login. '/oauth2/token');

                $data = json_decode($response->getBody()->getContents());
                if ($response->status() == 200)
                {
                    $request->session()->put('token', $data->access_token);
                    $request->session()->put('idtoken', $data->id_token);
                    $request->session()->put('role', $role);
                    $request->session()->put('firstname', $user['http://wso2.org/claims/givenname']);
                    $request->session()->put('lastname', $user['http://wso2.org/claims/lastname']);
                    $request->session()->put('email', $user['http://wso2.org/claims/emailaddress']);
                    $request->session()->put('username', $user['http://wso2.org/claims/username']);

                    Alert::toast('Successful login', 'success');
                    return redirect(route('application.page'))->with('success', 'Successful User Login!');
                }

                Alert::warning('Warning', 'Your password is wrong!');
                return redirect()->back()->with('warning', 'Wrong Password');
        }
    } 

    public function register(Request $request){
        $validator = Validator::make($request->all(), [

            'firstname'             => 'required',
            'lastname'              => 'required',
            'userlogin'             => 'required|min:6',
            'email'                 => 'required|email:rfc,dns',
            'telephone'             => 'required',
            'address'               => 'required',
            'organization'          => 'required',
            'password'              => 'required|confirmed|min:6',
            'password_confirmation' => 'required|min:6',

        ],[
            'firstname'             => 'Tidak boleh kosong',
            'lastname'              => 'Tidak boleh kosong',
            'userlogin'             => 'Username minimal 6 karakter',
            'email'                 => 'Masukan email yang valid',
            'telephone'             => 'Tidak boleh kosong',
            'address'               => 'Tidak boleh kosong',
            'organization'          => 'Tidak boleh kosong',
            'password'              => 'Password tidak sama',
            'password_confirmation' => 'Password tidak sama',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }else{
            
            try {
                
                $payloads = [
                    'user' =>
                        [
                            'username' => $request->userlogin,
                            'realm' => 'PRIMARY',
                            'password' => $request->password,
                            'claims' =>
                            [
                                [
                                    "uri" => "http://wso2.org/claims/givenname",
                                    "value" => $request->firstname
                                ],
                                [
                                    "uri" => "http://wso2.org/claims/emailaddress",
                                    "value" => $request->email
                                ],
                                [
                                    "uri" => "http://wso2.org/claims/lastname",
                                    "value" => $request->lastname
                                ],
                                [
                                    "uri" => "http://wso2.org/claims/organization",
                                    "value" => $request->organization
                                ],
                                [
                                    "uri" => "http://wso2.org/claims/telephone",
                                    "value" => $request->telephone
                                ],
                                [
                                    "uri" => "http://wso2.org/claims/addresses",
                                    "value" => $request->address
                                ],
                            ],
                        ],
                    'properties' =>
                        [
                            [
                                "key" => "callback",
                                "value" => "https://apim.belajarwso2.com/authenticationendpoint/login.do"
                            ]
                        ]
                ];

                $response = Http::withBasicAuth('admin', 'admin')
                ->withOptions(['verify' => false])
                ->withBody(json_encode($payloads),'application/json')
                ->post($this->url_register. '/identity/user/v1.0/me');

                $data = json_decode($response->getBody()->getContents());

                if ($response->status() == '409') {
                    
                    Alert::warning('Warning', $data->description);
                    return back()->with('warning', $data->description);
                } else {
                    Alert::toast('Account created successfully', 'success');
                    // Alert::success('Membuat akun', 'Account created successfully');
                    return redirect(route('login.page'))->with('success', 'Successful User Registration!');
                }

            } catch (\Exception $e) {
                dd($e);
                alert('Register user','Failed to perform user registration', 'error');
                return redirect()->back()->withInput($request->input());
            }

        }


    }

    public function newpassword(Request $request){
        $payloads = [
            'code' => $request->confirmation,
            'step' => '',
            'properties' => [],
        ];

        $response = Http::withOptions(['verify' => false])
        ->withBasicAuth('admin', 'admin')
        ->withHeaders([
            'Authorization' => 'Basic YWRtaW46YWRtaW4=',
            'Accept' => '*/*',
        ])
        ->withBody(json_encode($payloads),'application/json')
        ->post('https://apim.belajarwso2.com/t/carbon.super/api/identity/recovery/v0.9/validate-code');
        $data = json_decode($response->getBody()->getContents());
        $status = $response->status();
        $confirmation = $request->confirmation;
        if ($response->status() == '400') {
            $invalid = $data->description;
            return view('authentication.new_password',compact('status','data','confirmation','invalid'));
        } else {
            return view('authentication.new_password',compact('status','data','confirmation'));
        }
    }

    public function resetpassword(Request $request){
        $validator = Validator::make($request->all(), [

            'password'    => 'required|confirmed|min:6',
            'password_confirmation' => 'required|min:6',

        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }else{ 

            $payloads = [
                'key' => $request->confirmation,
                'password' => $request->password,
                'properties' => [],
            ];
    
            $response = Http::withOptions(['verify' => false])
            ->withBasicAuth('admin', 'admin')
            ->withHeaders([
                'Authorization' => 'Basic YWRtaW46YWRtaW4=',
                'Accept' => '*/*',
            ])
            ->withBody(json_encode($payloads),'application/json')
            ->post('https://apim.belajarwso2.com/t/carbon.super/api/identity/recovery/v0.9/set-password');
            $data = json_decode($response->getBody()->getContents());
        
            if ($response->status() == '200') {

                Alert::success('Success', 'Bershasil mereset password');
                return redirect(route ('login.page'))->with('success', 'Bershasil mereset password');
            }
            
            Alert::warning('Warning', $data->description);
            return back()->with('warning', $data->description);
        }
    }

    public function logout(Request $request){
        $request->session()->forget('token');
        return redirect(route('home.page'));
    }

}
