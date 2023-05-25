<?php

namespace App\Http\Controllers;

use stdClass;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\Return_;
use Illuminate\Support\Facades\Http;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;


class UsageapiController extends Controller
{

    public function __construct(){   
        $this->url_report = getUrlReport();
        $this->url = getUrlApi();
    }

    public function customer_monthly_report_summary_page(Request $request){

        $application = getUrl($this->url .'/applications');

        if($application  == null){
            session()->forget('token');
            return redirect(route('login.page'));
        }
        
        $app_id = $request->application;
        $api_id = $request->api_name;
        $year = $request->year;
        $month = $request->month;
        $username = session('username');

        if ($year == null && $month == null) {

            $total = 0;
            $count = 0;
            $data = [];
        
        } else {

            if ($app_id == null || $app_id == 'All') {
         
                $montlysummary = getUrlReports($this->url_report . '/report/monthly-summary?username='.$username.'&year='.$year.'&month='.$month);
            
            } else {
    
                $montlysummary = getUrlReports($this->url_report . '/report/monthly-summary?applicationId='.$app_id.'&apiId='.$api_id.'&year='.$year.'&month='.$month.'&username='.$username);
            
            }
            if ($montlysummary->status == 'success' ) {
            
                $total = $montlysummary->data->totalApis;
                $count = $montlysummary->data->requestCount;
                $data  = $montlysummary->data->details->content;
    
            }
        }

        return view('customer.reportapi.index',compact('application','total','count','data'));
    }

    public function customer_result_api_summary_report(Request $request){

        $api = getUrl($this->url .'/subscriptions?applicationId='. $request->id_app);
        return response()->json(['status' => 'success', 'data' => $api]);
    }
    
    public function customer_detail_logs_report(Request $request, $app, $api){

        $app_id = $app;
        $api_id = $api;
        $username = session('username');
        $detail = getUrlReports($this->url_report . '/report/monthly-summary/details?username='.$username.'&applicationId='.$app_id.'&apiId='.$api_id);
        $data  = $detail->data->content;

        if (count($data) >= 1){
            $api  = $data[0]->apiName;
            $app  = $data[0]->applicationName;
        }

        return view('customer.reportapi.detailreport', compact('data','app','api'));
    }

    public function customer_api_resource_usage_summary_page(Request $request){

        $months = [
            1 => 'January',
            2 => 'February',
            3 => 'March',
            4 => 'April',
            5 => 'Mei',
            6 => 'June',
            7 => 'July',
            8 => 'August',
            9 => 'September',
            10 => 'October',
            11 => 'November',
            12 => 'December',
        ];
        
        $api = getUrlReports($this->url_report . '/report/apis?username='.session('username') );
        $years = getUrlReports($this->url_report . '/report/years?username='.session('username') );

        $api_id = $request->api;
        $resources = $request->resources;
        $year = $request->year;
        $month = $request->month;
        $username = session('username');
        
        
        if ($year == null && $month == null) {

            $total = 0;
            $count = 0;
            $data = [];
        
        } else {     
            
            if ( $api_id == 'All' && $resources == 'All' ) {
                $resourcesummary = getUrlReports($this->url_report . '/report/resource-summary?username='.$username.'&year='.$year.'&month='.$month);
            } elseif ($resources == 'All') {
                $resourcesummary = getUrlReports($this->url_report . '/report/resource-summary?apiId='.$api_id.'&year='.$year.'&month='.$month.'&username='.$username);
            } elseif ($api_id == 'All'){
                $resourcesummary = getUrlReports($this->url_report . '/report/resource-summary?resource='.$resources.'&year='.$year.'&month='.$month.'&username='.$username);
            } else {
                $resourcesummary = getUrlReports($this->url_report . '/report/resource-summary?apiId='.$api_id.'&resource='.$resources.'&year='.$year.'&month='.$month.'&username='.$username);
            }

            if ($resourcesummary->status == 'success' ) {
                $total = $resourcesummary->data->totalApis;
                $count = $resourcesummary->data->requestCount;
                $data  = $resourcesummary->data->details->content;
            }
        }

        return view('customer.usageresource.index',compact('api','api_id','total','count','data','months','month','years','year'));
    }
    public function customer_result_resource_summary_usage(Request $request){
        
        $resources = getUrlReports($this->url_report . '/report/resources?username='.session('username').'&apiId='.$request->api_id );
        return response()->json(['status' => 'success', 'data' => $resources]);
    }

    public function customer_detail_logs_usage(Request $request,$resources,$api){

        
        return view('customer.usageresource.detailusage');
    }
}
