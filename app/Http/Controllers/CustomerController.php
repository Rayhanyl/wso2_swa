<?php

namespace App\Http\Controllers;

use stdClass;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpParser\Node\Stmt\Return_;
use Illuminate\Support\Facades\Http;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;
use Svg\Tag\Rect;

class CustomerController extends Controller
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

        $years = getUrlReports($this->url_report . '/report/years?username='.session('username') );
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

            if ($app_id == 'All' && $api_id == 'All') {
         
                $montlysummary = getUrlReports($this->url_report . '/report/monthly-summary?username='.$username.'&year='.$year.'&month='.$month);
            
            }elseif ($api_id == 'All'){    
                $montlysummary = getUrlReports($this->url_report . '/report/monthly-summary?applicationId='.$app_id.'&year='.$year.'&month='.$month.'&username='.$username);
            } else {
                $montlysummary = getUrlReports($this->url_report . '/report/monthly-summary?applicationId='.$app_id.'&apiId='.$api_id.'&year='.$year.'&month='.$month.'&username='.$username);
                
            }
            if ($montlysummary->status == 'success' ) {
            
                $total = $montlysummary->data->totalApis;
                $count = $montlysummary->data->requestCount;
                $data  = $montlysummary->data->details->content;
    
            }
        }

        return view('customer.reportapi.index',compact('application','total','count','data','years','year','api_id','app_id','month'));
    }

    public function customer_result_api_summary_report(Request $request){

        $api = getUrl($this->url .'/subscriptions?applicationId='. $request->id_app);
        return response()->json(['status' => 'success', 'data' => $api]);
    }

    public function customer_monthly_report_summary_pdf(Request $request){

            if ($request->app == 'All' && $request->api == 'All') {
         
                $montlysummary = getUrlReports($this->url_report . '/report/monthly-summary?username='.session('username').'&year='.$request->year.'&month='.$request->month);
            
            }elseif ($request->api == 'All'){    
                $montlysummary = getUrlReports($this->url_report . '/report/monthly-summary?applicationId='.$request->app.'&year='.$request->year.'&month='.$request->month.'&username='.session('username'));
            } else {
                $montlysummary = getUrlReports($this->url_report . '/report/monthly-summary?applicationId='.$request->app.'&apiId='.$request->api.'&year='.$request->year.'&month='.$request->month.'&username='.session('username'));
                
            }

            if ($montlysummary->status == 'success' ) {

                $datas = $montlysummary->data->details->content;
                if (count($datas) >= 1){
                    $data['api']  = $datas[0]->apiName;
                    $data['app']  = $datas[0]->applicationName;
                    $data['org']  = $datas[0]->organization;
                }

                $data['year'] = $request->year;
                $data['month'] = $request->month;
                $data['username'] = session('username');
                $data['total'] = $montlysummary->data->totalApis;
                $data['count'] = $montlysummary->data->requestCount;
                $data['data']  = $montlysummary->data->details->content;
    
            }

        $pdf = PDF::loadView('customer.reportapi.table_index',$data,['orientation' => 'portrait']);
        $pdf->setPaper('A4', 'portrait');
        return $pdf->download('MONTHLY_REPORT_SUMMARY.pdf');
    }
    
    public function customer_detail_logs_report(Request $request, $app, $api, $year, $month){

        $app_id = $app;
        $api_id = $api;
        $username = session('username');
        $detail = getUrlReports($this->url_report . '/report/monthly-summary/details?username='.$username.'&applicationId='.$app_id.'&apiId='.$api_id);
        $data  = $detail->data->details->content;

        if (count($data) >= 1){
            $api  = $data[0]->apiName;
            $app  = $data[0]->applicationName;
        }

        return view('customer.reportapi.detailreport', compact('data','app','api','api_id','app_id','year','month'));
    }

    public function customer_detail_logs_report_pdf(Request $request){
        $app = $request->app;
        $api = $request->api;
        $username = session('username');
        $detail = getUrlReports($this->url_report . '/report/monthly-summary/details?username='.$username.'&applicationId='.$app.'&apiId='.$api);
        $datas  = $detail->data->details->content;

        if (count($datas) >= 1){
            $data['api']  = $datas[0]->apiName;
            $data['app']  = $datas[0]->applicationName;
            $data['org']  = $datas[0]->organization;
        }

        $data['count'] = $detail->data->requestCount;
        $data['ok'] = $detail->data->requestOK;
        $data['nok'] = $detail->data->requestNOK;
        $data['year'] = $request->year;
        $data['month'] = $request->month;
        $data['username'] = $username;
        $data['data'] = $datas;
        $pdf = PDF::loadView('customer.reportapi.table_detail',$data,['orientation' => 'portrait']);
        $pdf->setPaper('A4', 'portrait');
        return $pdf->download('MONTHLY_REPORT_SUMMARY_DETAIL.pdf');
    }

    public function customer_api_resource_usage_summary_page(Request $request){

        
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

        return view('customer.usageresource.index',compact('api','api_id','total','count','data','month','years','year','resources'));
    }

    public function customer_api_resource_usage_summary_pdf(Request $request, $year,$month,$resources,$api_id){
        

        $data['year'] = $year;
        $data['month'] = $month;
        $data['resources'] = $resources;
        $data['api_id'] = $api_id;
        $username = session('username');
        $data['username'] = session('username');
        if ($year == null && $month == null) {

            $data['total'] = 0;
            $data['count'] = 0;
            $data['data'] = [];
        
        } else {     
            
            if ( $api_id == 'All' && $resources == 'All' ) {
                $resourcesummary = getUrlReports($this->url_report . '/report/resource-summary?year='.$year.'&month='.$month.'&username='.$username);
            } elseif ($resources == 'All') {
                $resourcesummary = getUrlReports($this->url_report . '/report/resource-summary?apiId='.$api_id.'&year='.$year.'&month='.$month.'&username='.$username);
            } elseif ($api_id == 'All'){
                $resourcesummary = getUrlReports($this->url_report . '/report/resource-summary?resource='.$resources.'&year='.$year.'&month='.$month.'&username='.$username);
            } else {
                $resourcesummary = getUrlReports($this->url_report . '/report/resource-summary?apiId='.$api_id.'&resource='.$resources.'&year='.$year.'&month='.$month.'&username='.$username);
            }

            if ($resourcesummary->status == 'success' ) {
                $data['total'] = $resourcesummary->data->totalApis;
                $data['count'] = $resourcesummary->data->requestCount;
                $data['data']  = $resourcesummary->data->details->content;
            }
        }

        $pdf = PDF::loadView('customer.usageresource.table_index',$data,['orientation' => 'portrait']);
        $pdf->setPaper('A4', 'portrait');
        return $pdf->download('REPORT_API_RESOURCE_SUMMARY.pdf');

    }

    public function customer_result_resource_summary_usage(Request $request){
        
        $resources = getUrlReports($this->url_report . '/report/resources?username='.session('username').'&apiId='.$request->api_id );
        return response()->json(['status' => 'success', 'data' => $resources]);
    }

    public function customer_result_month_summary_usage(Request $request){

        $years = getUrlReports($this->url_report . '/report/months?year='.$request->year.'&username='.session('username') );
        return response()->json(['status' => 'success', 'data' => $years]);
    }

    public function customer_detail_logs_usage(Request $request){

        $resources = getUrlReports($this->url_report . '/report/resource-summary/details?username='.session('username').'&resource='.$request->resource.'&apiId='.$request->api_id );
        $data  = $resources->data->content;
        $resources = $request->resource;
        $year = $request->year;
        $month = $request->month;
        $api_id = $request->api_id;
        
        if(count($data) >= 1){
            $api_name = $data[0]->apiName;
        }else{
             $api_name = [];
        }

        return view('customer.usageresource.detailusage',compact('data','resources','api_name','year','month','api_id'));
    }

    public function customer_detail_logs_usage_pdf(Request $request){

        $resources = getUrlReports($this->url_report . '/report/resource-summary/details?resource='.$request->resources.'&apiId='.$request->api_id.'&username='.session('username') );
        $datas = $resources->data->content;;
        $data['data']  = $datas;
        $data['resources'] = $request->resources;
        $data['year'] = $request->year;
        $data['month'] = $request->month;
        $data['username'] = session('username');        
        if(count($datas) >= 1){
            $data['api_name'] = $datas[0]->apiName;
        }

        $pdf = PDF::loadView('customer.usageresource.table_detail',$data,['orientation' => 'portrait']);
        $pdf->setPaper('A4', 'portrait');
        return $pdf->download('REPORT_API_RESOURCE_SUMMARY_DETAIL.pdf');

    }

    public function customer_dashboard_page(){

        $top = 10;
        $color =[
            'rgb(255, 99, 132,1)',
            'rgb(54, 162, 235,1)',
            'rgb(255, 205, 86,1)',
            'rgb(150, 149, 237,1)',
            'rgb(46, 139, 87,1)',
            'rgb(255, 165, 0,1)',
            'rgb(218, 112, 214,1)',
            'rgb(0, 128, 128,1)',
            'rgb(255, 192, 203,1)',
            'rgb(70, 130, 180,1)',
        ];

        $bordercolor =[
            'rgb(255, 99, 132, 0.2)',
            'rgb(54, 162, 235, 0.2)',
            'rgb(255, 205, 86, 0.2)',
            'rgb(150, 149, 237, 0.2)',
            'rgb(46, 139, 87, 0.2)',
            'rgb(255, 165, 0, 0.2)',
            'rgb(218, 112, 214, 0.2)',
            'rgb(0, 128, 128, 0.2)',
            'rgb(255, 192, 203, 0.2)',
            'rgb(70, 130, 180, 0.2)',
        ];

        $username = session('username');
        $total_report = getUrlReports($this->url_report . '/dashboard/total-report?username='.$username );
        $data_report = $total_report->data;

        $api_usage = getUrlReports($this->url_report . '/dashboard/percentage-report?byApi=true&top='.$top.'&username='.$username );
        if ($api_usage->data->byApi == []) {
            $apiname = ['No Data Available'];
            $usage_count = ['1'];
        } else {
            $apiname = collect($api_usage->data->byApi)->pluck('apiName')->all();
            $usage_count = collect($api_usage->data->byApi)->pluck('rowCount')->all();
        }
    
        $response_code = getUrlReports($this->url_report . '/dashboard/percentage-report?byResponseCode=true&top='.$top.'&username='.$username );
        if ($api_usage->data->byApi == []) {
            $response_name = ['No Data Available'];
            $response_count = ['1'];
        } else {
            $response_name = collect($response_code->data->byResponseCode)->pluck('proxyResponseCode')->all();
            $response_count = collect($response_code->data->byResponseCode)->pluck('rowCount')->all();
        }

        $response_code = getUrlReports($this->url_report . '/dashboard/percentage-report?byApplication=true&top='.$top.'&username='.$username );
        if ($api_usage->data->byApi == []) {
            $application_name = ['No Data Available'];
            $application_count = ['1'];
        } else {
            $application_name = collect($response_code->data->byApplication)->pluck('applicationName')->all();
            $application_count = collect($response_code->data->byApplication)->pluck('rowCount')->all();
        }

        $quota_subs = getUrlReports($this->url_report . '/report/subscriptions/remaining?size=99999&username='.$username );
        foreach ($quota_subs->data->content as $item) {
            if ($item->remaining > 0) {
                $item->percentage = $item->remaining / $item->quota * 100;
            } else {
                $item->percentage = 100;
            }
        }     
        

        $top_api_usage = getUrlReports($this->url_report . '/dashboard/api-usage?filter=month&top=10&username='.$username );


        return view('customer.dashboard.index',compact('data_report','apiname','usage_count','response_name','response_count','application_name','application_count','color','quota_subs','bordercolor'));
    }

    public function customer_payment_page(){

        return view('customer.transaction.payment.index');
    }

    public function customer_payment_history_page(){

        return view('customer.transaction.payment.payment_history');
    }
    
}
