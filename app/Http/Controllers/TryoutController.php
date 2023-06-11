<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class TryoutController extends Controller
{

    public function __construct(){
        $this->url = getUrlApi();
    }

    private function getUrlToken (){
        $token = session('idtoken');
        $tokenParts = explode(".", $token);  
        $tokenHeader = base64_decode($tokenParts[0]);
        $tokenPayload = base64_decode($tokenParts[1]);
        $jwtHeader = json_decode($tokenHeader);
        $jwtPayload = json_decode($tokenPayload);

        $iss = $jwtPayload->iss;
        $url = explode('/',$iss);

        return $url[0].'//'.$url[2];
    }

    public function tryout_page(Request $request,$id){
        
        if (session('token') == null) {
            session()->forget('token');
            return redirect(route('login.page'));
        }

        $application = getUrl($this->url .'/applications/'. $id);
        
        if ($application  == null) {
            session()->forget('token');
            return redirect(route('login.page'));
        }

        $subscription = getUrl($this->url .'/subscriptions?applicationId='. $id);
        $apptoken = getUrl($this->url .'/applications/'.$id.'/oauth-keys');
        $production = collect($apptoken->list)->where('keyType', 'PRODUCTION')->first();
        $sandbox = collect($apptoken->list)->where('keyType', 'SANDBOX')->first();
        return view('tryout.index', compact('application','subscription','sandbox','production'));
    }

    public function downloadformatopenapi(Request $request){

        $swagger = getUrl($this->url .'/apis/'.$request->id_api.'/swagger');

        if ($swagger !== [] ) {

            if (isset ($swagger->swagger)) {
                $swagger->securityDefinitions->default->authorizationUrl = "https://apim.belajarwso2.com/oauth2/authorize";
            }else{
                $swagger->components->securitySchemes->default->flows->implicit->authorizationUrl = "https://apim.belajarwso2.com/oauth2/authorize";
            }   
        }

        $jsonString = json_encode($swagger);
        $data = str_replace("\\/", "/", $jsonString);
        $file = storage_path('app/example.json');
        file_put_contents($file, $data);
        return response()->download($file, 'swagger.json', ['Content-Type' => 'application/json']);
    }

    public function jsontryout(Request $request){

        $swagger = getUrl($this->url .'/apis/'.$request->id_api.'/swagger');

        if ($swagger !== [] ) {

            if (isset ($swagger->swagger)) {
                $swagger->securityDefinitions->default->authorizationUrl = "https://apim.belajarwso2.com/oauth2/authorize";
            }else{
                $swagger->components->securitySchemes->default->flows->implicit->authorizationUrl = "https://apim.belajarwso2.com/oauth2/authorize";
            }   
        }

        return $swagger;
    }

    public function sandbox_form(Request $request){
        if($request->ajax()){

            $url = $this->getUrlToken();
            $application = getUrl($this->url .'/applications/'. $request->id_app);

            if ($application == null){
            
                $request->session()->forget('token');
                return redirect(route('login.page'));
            }

            $alldata = getUrl($this->url .'/applications/'.$request->id_app.'/oauth-keys');
            $data = collect($alldata->list)->where('keyType', 'SANDBOX')->first();

            if ($data != null) {
                $base64 = base64_encode($data->consumerKey.$data->consumerSecret);
            }else{
                $base64 = '';
            }

            $grant = getUrl($this->url .'/settings');
            $granttype = [
                "refresh_token" => 'Refresh Token',
                "urn:ietf:params:oauth:grant-type:saml2-bearer" => 'SAML2',
                "implicit" => 'implicit',
                "password" => 'Password',
                "client_credentials" => 'Client Credentials',
                "iwa:ntlm" => 'IWA-NTLM',
                "authorization_code" => 'Code',
                "urn:ietf:params:oauth:grant-type:token-exchange" => 'Token Exchange',
                "urn:ietf:params:oauth:grant-type:jwt-bearer" => 'JWT'
            ];


            return view('tryout.modal.generate_sandbox', compact('application','grant', 'granttype','url','data','base64'));
        }
        return abort(404);
    }

    public function production_form(Request $request){
        if($request->ajax()){

            $url = $this->getUrlToken();
            $application = getUrl($this->url .'/applications/'. $request->id_app);

            if ($application == null){
            
                $request->session()->forget('token');
                return redirect(route('login.page'));
            }

            $alldata = getUrl($this->url .'/applications/'.$request->id_app.'/oauth-keys');
            $data = collect($alldata->list)->where('keyType', 'PRODUCTION')->first();

            if ($data != null) {
                $base64 = base64_encode($data->consumerKey.$data->consumerSecret);
            }else{
                $base64 = '';
            }

            $grant = getUrl($this->url .'/settings');
            $granttype = [
                "refresh_token" => 'Refresh Token',
                "urn:ietf:params:oauth:grant-type:saml2-bearer" => 'SAML2',
                "implicit" => 'implicit',
                "password" => 'Password',
                "client_credentials" => 'Client Credentials',
                "iwa:ntlm" => 'IWA-NTLM',
                "authorization_code" => 'Code',
                "urn:ietf:params:oauth:grant-type:token-exchange" => 'Token Exchange',
                "urn:ietf:params:oauth:grant-type:jwt-bearer" => 'JWT'
            ];


            return view('tryout.modal.generate_production', compact('application','grant', 'granttype','url','data','base64'));
        }
        return abort(404);
    }

}
