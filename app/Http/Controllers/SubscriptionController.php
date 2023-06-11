<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class SubscriptionController extends Controller
{

    public function __construct(){
        $this->url = getUrlApi();
    }

    public function subscription_page(Request $request,$id){

        if (session('token') == null) {
            session()->forget('token');
            return redirect(route('login.page'));
        }

        $application = getUrl($this->url .'/applications/'. $id);

        if($application  == null){
            session()->forget('token');
            return redirect(route('login.page'));
        }

        $subscription = getUrl($this->url .'/subscriptions?applicationId='. $id);
        $approved = collect($subscription->list)->where('status','UNBLOCKED')->all();
        $approved_count = count($approved);
        $rejected = collect($subscription->list)->where('status','REJECTED')->all();
        $rejected_count = count($rejected);
        $created = collect($subscription->list)->where('status','ON_HOLD')->all();
        $created_count = count($created);

        return view('subscription.index', compact('application','subscription','approved_count','rejected_count','created_count'));
    }

    // public function create_subscription_page(Request $request, $id){        
    //     $application = getUrl($this->url .'/applications/'. $id);

    //     if ($application->applicationId == null) {
    //         session()->forget('token');
    //         return redirect(route('login.page'));
    //     }

    //     $apilist = getUrl($this->url . '/apis'); 
    //     $publishapi = collect($apilist->list)->where('lifeCycleStatus', 'PUBLISHED')->all();
    //     $subscription = getUrl($this->url . '/subscriptions?applicationId='. $id);
    //     $filltersubscription = collect($subscription->list)->pluck('apiId')->all();
                
    //     $notsubscription = [];
    //     foreach ($publishapi as $key => $value) {
    //         if(!in_array($value->id, $filltersubscription)){
    //             $notsubscription[] = $value;
    //         }
    //     }

    //     return view('subscription.create_subscription', compact('application','notsubscription'));
    // }

    public function add_subscription(Request $request){
        if($request->ajax()){

            $application = getUrl($this->url .'/applications/'. $request->id_app);

            if ($application->applicationId == null) {
                session()->forget('token');
                return redirect(route('login.page'));
            }
    
            $apilist = getUrl($this->url . '/apis'); 
            $publishapi = collect($apilist->list)->where('lifeCycleStatus', 'PUBLISHED')->all();
            $subscription = getUrl($this->url . '/subscriptions?applicationId='. $request->id_app);
            $filltersubscription = collect($subscription->list)->pluck('apiId')->all();
                    
            $notsubscription = [];
            foreach ($publishapi as $key => $value) {
                if(!in_array($value->id, $filltersubscription)){
                    $notsubscription[] = $value;
                }
            }
    
            return view('subscription.modal.add_subs', compact('application','notsubscription'));
        }
        return abort(404);
    }

    public function store_subscription(Request $request){
        $validator = Validator::make($request->all(), [
            'applicationid'      => 'required',
            'apiid'              => 'required',
            'status'             => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'failed']);
        }else{
            
            try {

                $payloads = [
                    'applicationId' => $request->applicationid,
                    'apiId' => $request->apiid,
                    'throttlingPolicy' => $request->status,
                    'requestedThrottlingPolicy' => $request->status,
                ];

                $response = Http::withOptions(['verify' => false])
                ->withHeaders([
                    'Authorization' => 'Bearer '.$request->session()->get('token'),
                ])
                ->withBody(json_encode($payloads),'application/json')
                ->post($this->url. '/subscriptions');

                $data = json_decode($response->getBody()->getContents());

                return response()->json(['status' => 'success', 'data' => $data]);

            } catch (\Exception $e) {
                dd($e);
            }
        }
    }

    public function edit_subscription(Request $request){
        if($request->ajax()){

            $subs = getUrl($this->url .'/subscriptions/'. $request->id_subs);
            return view('subscription.modal.edit_subs', compact('subs'));
        }
        return abort(404);
    }

    public function update_subscription(Request $request){
        try {

            $payloads = [
                'applicationId' => $request->appid,
                'apiId' => $request->apiid,
                'throttlingPolicy' => $request->throttling,
                'requestedThrottlingPolicy' => $request->throttling,
                'status' => $request->status,
            ];

            $response = Http::withOptions(['verify' => false])
            ->withHeaders([
                'Authorization' => 'Bearer '.$request->session()->get('token'),
            ])
            ->withBody(json_encode($payloads),'application/json')
            ->put($this->url. '/subscriptions/'. $request->subsid);

            $data =json_decode($response->getBody()->getContents());
            
            Alert::toast('Successfully updated subscribe API', 'success');
            // Alert::success('Success', 'Berhasil memperbaharui subscribe API');
            return redirect()->route('subscription.page', $request->appid);
            
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function delete_subscription(Request $request, $id){
        try {

            $response = Http::withOptions(['verify' => false])
            ->withHeaders([
                'Authorization' => 'Bearer '.$request->session()->get('token'),
            ])
            ->delete($this->url . '/subscriptions/'. $id);
    
            $data =json_decode($response->getBody()->getContents());
    
            if($response->status() == 200)
            {   
                Alert::success('Successfully deleted subscription', 'success');
                // Alert::success('Success', 'Berhasil menghapus subscription');
                return back()->with('success', 'Successful Delete Subscription!');
            } 

            Alert::toast('Failed to delete subscription', 'danger');
            // Alert::danger('Danger', 'Gagal menghapus subscription');
            return back()->with('error', 'Failed Delete Subscription');
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function loadimgapi(Request $request){

        $response = Http::withOptions(['verify' => false])
        ->withHeaders([
            'Authorization' => 'Bearer '.session()->get('token'),
            'Accept' => '*/*',
        ])
        ->get($this->url .'/apis/'.$request->id.'/thumbnail');

        $data = $response->getBody()->getContents();
        $base64 = base64_encode($data);
        $mime = "image/jpeg";
        $img = ('data:' . $mime . ';base64,' . $base64);
                
        return "<img class='img-thumbnail rounded mx-auto d-block' width='50' height='50' src=$img alt='ok' >";
    }

}
