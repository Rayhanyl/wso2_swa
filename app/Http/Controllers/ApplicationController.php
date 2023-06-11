<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;


class ApplicationController extends Controller
{

    public function __construct(){
        $this->url = getUrlApi();
    }

    public function application_page(){

        if (session('token') == null) {
            session()->forget('token');
            return redirect(route('login.page'));
        }

        $application = getUrl($this->url .'/applications');
        
        if($application  == null){
            session()->forget('token');
            return redirect(route('login.page'));
        }
        
        $approved = collect($application->list)->where('status','APPROVED')->all();
        $approved_count = count($approved);
        $rejected = collect($application->list)->where('status','REJECTED')->all();
        $rejected_count = count($rejected);
        $created = collect($application->list)->where('status','CREATED')->all();
        $created_count = count($created);


        return view('application.index', compact('application','approved_count','rejected_count','created_count'));
    }

    public function create_application_page(){

        if (session('token') == null) {
            session()->forget('token');
            return redirect(route('login.page'));
        }

        $sharedquota = getUrl($this->url.'/throttling-policies/application');

        if ($sharedquota == null) {
            session()->forget('token');
            return redirect(route('login.page'));
        }

        return view('application.create_app', compact('sharedquota'));
    }

    public function store_application(Request $request){   
        $validator = Validator::make($request->all(), [
            'appname'           => 'required',
            'shared'            => 'required',
            'description'       => 'max:512',
        ],[
            'appname'           => 'Nama aplikasi tidak boleh kosong',
            'shared'            => 'Shared kuota aplikasi tidak boleh kosong',
            'description'       => 'Maximal 512 karakter',
        ]);

        if ($validator->fails()) {
            Alert::toast('All fields must be filled in', 'warning');
            // Alert::warning('Warning', 'Kolom harus terisi semua');
            return redirect()->back()->withErrors($validator)->withInput()->with('warning', 'Field not complete!');
        }else{
            
            try {

                $payloads = [
                    'name' => $request->appname,
                    'throttlingPolicy' => $request->shared,
                    'description' => $request->description,
                    'tokenType' => 'JWT',
                    'groups' => [],
                    'attributes' => null,
                    'subscriptionScopes' => [],
                ];

                $response = Http::withOptions(['verify' => false])
                ->withHeaders([
                    'Authorization' => 'Bearer '.$request->session()->get('token'),
                ])
                ->withBody(json_encode($payloads),'application/json')
                ->post($this->url. '/applications');

                $data =json_decode($response->getBody()->getContents());   

                if ($response->status() == '409') {
                    Alert::toast('Application alredy exists with name '.$request->appname, 'warning');
                    // Alert::warning('Warning', 'Application alredy exist with name '.$request->appname);
                    return redirect()->back();
                } else {
                    Alert::toast('Successfully made the application, wait for the admin to be approved', 'success');
                    // Alert::success('Success', 'Successfully made the application, wait for the admin to be approved');
                    return redirect(route('application.page'));
                }
                
                

            } catch (\Exception $e) {
                dd($e);
            }
        }
    }

    public function edit_application(Request $request, $id){
        if (session('token') == null) {
            session()->forget('token');
            return redirect(route('login.page'));
        }
        
        $options = getUrl($this->url .'/throttling-policies/application');
        $application = getUrl($this->url .'/applications/'. $id);
        
        return view('application.edit_app', compact('application','options'));
    }

    public function update_application(Request $request, $id){

        $validator = Validator::make($request->all(), [
            'shared'            => 'required',
            'description'       => 'max:512',
        ]);

        if ($validator->fails()) {
            Alert::toast('Fill in the fields according to the conditions', 'warning');
            // Alert::warning('Warning', 'Isi kolom sesuai dengan ketentuan');
            return redirect()->back()->withErrors($validator)->withInput();
        }else{

            try {
                $payloads = [
                    'name' => $request->appname,
                    'throttlingPolicy' => $request->shared,
                    'description' => $request->description,
                    'tokenType' => 'JWT',
                    'groups' => [],
                    'attributes' => null,
                    'subscriptionScopes' => [],
                ];
                
                $response = Http::withOptions(['verify' => false])
                ->withHeaders([
                    'Authorization' => 'Bearer '.$request->session()->get('token'),
                ])
                ->withBody(json_encode($payloads),'application/json')
                ->put($this->url.'/applications/'. $id);
        
                $data =json_decode($response->getBody()->getContents());
                
                Alert::toast('Successfully updated application data', 'success');
                // Alert::success('Success', 'Berhasil memperbaharui data');
                return redirect(route('application.page'));

            } catch (\Exception $e) {
                dd($e);
            }

        }
    }

    public function delete_application(Request $request, $id){
        try {

            $response = Http::withOptions(['verify' => false])
            ->withHeaders([
                'Authorization' => 'Bearer '.$request->session()->get('token'),
            ])
            ->delete($this->url . '/applications/'. $id);
    
            $data =json_decode($response->getBody()->getContents());
    
            if($response->status() == 200)
            {
                Alert::toast('Successfully removed the app', 'success');
                // Alert::success('Success', 'Berhasil menghapus aplikasi');
                return back()->with('success', 'Successful Delete Application!');
            } 

            Alert::toast('Failed to remove the app', 'danger');
            // Alert::danger('Danger', 'Gagal menghapus aplikasi');
            return back()->with('error', 'Failed Delete Application');
        } catch (\Exception $e) {
            dd($e);
        }
    }
    
}
