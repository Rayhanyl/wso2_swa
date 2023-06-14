<?php

namespace App\Http\Controllers;

use stdClass;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpParser\Node\Stmt\Return_;
use Illuminate\Support\Facades\Http;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Stmt\TryCatch;

use function GuzzleHttp\Promise\all;

class AdminController extends Controller
{

    public function __construct(){   
        $this->url_report = getUrlReport();
        $this->url_billing = getUrlBilling();
        $this->url = getUrlApi();
    }

    public function error_page(){
        return view('error');
    }

    public function admin_monthly_report_summary_page(Request $request){

        $years = getUrlReports($this->url_report . '/report/years' );
        $customers = getUrlReports($this->url_report . '/report/v2/customers' );

        $year = $request->year;
        $month = $request->month;
        $customer = $request->customer;
        $api_name = $request->api_name;

        if ($year == null && $month == null) {

            $total = 0;
            $count = 0;
            $customercount =0;
            $data = [];
        
        } else {     
            
            if ( $api_name == 'All' && $customer == 'All' ) {
                $resourcesummary = getUrlReports($this->url_report . '/report/monthly-summary?year='.$year.'&month='.$month);
            }  elseif ($api_name == 'All'){
                $resourcesummary = getUrlReports($this->url_report . '/report/monthly-summary?organization='.$customer.'&year='.$year.'&month='.$month);
            } else {
                $resourcesummary = getUrlReports($this->url_report . '/report/monthly-summary?apiId='.$api_name.'&organization='.$customer.'&year='.$year.'&month='.$month);
            }

            if ($resourcesummary->status == 'success' ) {
                $total = $resourcesummary->data->totalApis;
                $count = $resourcesummary->data->requestCount;
                $customercount = $resourcesummary->data->totalCustomers;
                $data  = $resourcesummary->data->details->content;
            }
        }
        
        return view('admin.reportapi.index',compact('years','year','month','api_name','customers','customer','total','count','data','customercount'));
    }

    public function admin_detail_logs_report(Request $request, $app, $api, $month ,$year){

        $app_id = $app;
        $api_id = $api;
        $detail = getUrlReports($this->url_report . '/report/monthly-summary/details?applicationId='.$app_id.'&apiId='.$api_id.'&month='.$month);
        $data  = $detail->data->details->content;
        $request_count = $detail->data->requestCount;
        $request_ok = $detail->data->requestOK;
        $request_nok = $detail->data->requestNOK;

        if (count($data) >= 1){
            $api  = $data[0]->apiName;
            $app  = $data[0]->applicationName;
            $organization  = $data[0]->organization;
        }

        return view('admin.reportapi.detailreport', compact('data','app','api','request_count','request_ok','request_nok','organization','app_id','api_id','month','year'));
    }

    public function admin_monthly_report_summary_pdf(Request $request, $year,$month,$customer,$api_name){

        $data['year'] = $year;
        $data['month']  = Carbon::createFromDate(null, $month, 1)->format('F');
        $data['customer'] = $customer;
        $data['api_name'] = $api_name;

        if ($year == null && $month == null) {

            $data['total'] = 0;
            $data['count'] = 0;
            $data['customercount'] =0;
            $data['data'] = [];
        
        } else {     
            
            if ( $api_name == 'All' && $customer == 'All' ) {
                $resourcesummary = getUrlReports($this->url_report . '/report/monthly-summary?year='.$year.'&month='.$month);
            }  elseif ($api_name == 'All'){
                $resourcesummary = getUrlReports($this->url_report . '/report/monthly-summary?organization='.$customer.'&year='.$year.'&month='.$month);
            } else {
                $resourcesummary = getUrlReports($this->url_report . '/report/monthly-summary?apiId='.$api_name.'&organization='.$customer.'&year='.$year.'&month='.$month);
            }

            if ($resourcesummary->status == 'success' ) {
                $data['total'] = $resourcesummary->data->totalApis;
                $data['count'] = $resourcesummary->data->requestCount;
                $data['customercount'] = $resourcesummary->data->totalCustomers;
                $data['data']  = $resourcesummary->data->details->content;
            }
        }

        $pdf = PDF::loadView('admin.reportapi.table_index',$data,['orientation' => 'portrait']);
        $pdf->setPaper('A4', 'portrait');
        return $pdf->download('REPORT_MONTHLY_API_USAGE_API.pdf');
        // return view('admin.reportapi.table_index');
    }

    public function admin_detail_logs_report_pdf(Request $request, $app_id, $api_id, $month , $year){

        $detail = getUrlReports($this->url_report . '/report/monthly-summary/details?applicationId='.$app_id.'&apiId='.$api_id.'&month='.$month);
        $datas  = $detail->data->details->content;
        $data['request_count'] = $detail->data->requestCount;
        $data['request_ok'] = $detail->data->requestOK;
        $data['request_nok'] = $detail->data->requestNOK;

        if (count($datas) >= 1){
            $data['api']  = $datas[0]->apiName;
            $data['app']  = $datas[0]->applicationName;
            $data['organization']  = $datas[0]->organization;
        }
        
        $data['detail'] = $datas;
        $data['year'] = $year;
        $data['month']  = Carbon::createFromDate(null, $month, 1)->format('F');

        $pdf = PDF::loadView('admin.reportapi.table_detail',$data,['orientation' => 'portrait']);
        $pdf->setPaper('A4', 'portrait');
        return $pdf->download('REPORT_MONTHLY_API_USAGE_API_DETAIL.pdf');
        // return view('admin.reportapi.table_detail');
    }

    public function admin_api_resource_usage_summary_page(Request $request){

        $years = getUrlReports($this->url_report . '/report/years' );
        $apis = getUrl($this->url . '/apis');
        
        if($apis  == null){
            session()->forget('token');
            return redirect(route('login.page'));
        }

        $api_id = $request->api;
        $resources = $request->resources;
        $year = $request->year;
        $month = $request->month;

        if ($year == null && $month == null) {

            $total = 0;
            $count = 0;
            $data = [];
        
        } else {     
            
            try {
             
                if ( $api_id == 'All' && $resources == 'All' ) {
                    $resourcesummary = getUrlReports($this->url_report . '/report/resource-summary?year='.$year.'&month='.$month);
                } elseif ($resources == 'All') {
                    $resourcesummary = getUrlReports($this->url_report . '/report/resource-summary?apiId='.$api_id.'&year='.$year.'&month='.$month);
                } elseif ($api_id == 'All'){
                    $resourcesummary = getUrlReports($this->url_report . '/report/resource-summary?resource='.$resources.'&year='.$year.'&month='.$month);
                } else {
                    $resourcesummary = getUrlReports($this->url_report . '/report/resource-summary?apiId='.$api_id.'&resource='.$resources.'&year='.$year.'&month='.$month);
                }
    
                if (empty($resourcesummary) || $resourcesummary->status == 'success') {
                    $total = $resourcesummary->data->totalApis;
                    $count = $resourcesummary->data->requestCount;
                    $data  = $resourcesummary->data->details->content;
                }else{
                    dd('Data kosong');
                }
                
            } catch (\Throwable $e) {
                dd($e);
            }
        }

        return view('admin.usageresource.index',compact('years','year','apis','api_id','total','count','data','month','resources'));
    }

    private function encodeCurlyBraces($url){
        $encodedUrl = str_replace(['{', '}'], ['%7B', '%7D'], $url);
        return $encodedUrl;
    }

    public function admin_detail_logs_usage(Request $request){
        $path = $this->encodeCurlyBraces($request->resource);
        $resources = getUrlReports($this->url_report . '/report/resource-summary/details?resource='.$path.'&apiId='.$request->api_id );
        $data  = $resources->data->content;
        $resources = $request->resource;
        $year = $request->year;
        $month = $request->month;
        $api_id = $request->api_id;
        
        if(count($data) >= 1){
            $api_name = $data[0]->apiName;
        }

        return view('admin.usageresource.detailusage',compact('data','resources','api_name','year','month','api_id'));
    }

    public function admin_api_resource_usage_summary_pdf(Request $request, $year,$month,$resources,$api_id){
        
        $data['year'] = $year;
        $data['month']  = Carbon::createFromDate(null, $month, 1)->format('F');
        $data['resources'] = $resources;

        if ($year == null && $month == null) {

            $data['total'] = 0;
            $data['count'] = 0;
            $data['data'] = [];
        
        } else {     
            
            if ( $api_id == 'All' && $resources == 'All' ) {
                $resourcesummary = getUrlReports($this->url_report . '/report/resource-summary?year='.$year.'&month='.$month);
            } elseif ($resources == 'All') {
                $resourcesummary = getUrlReports($this->url_report . '/report/resource-summary?apiId='.$api_id.'&year='.$year.'&month='.$month);
            } elseif ($api_id == 'All'){
                $resourcesummary = getUrlReports($this->url_report . '/report/resource-summary?resource='.$resources.'&year='.$year.'&month='.$month);
            } else {
                $resourcesummary = getUrlReports($this->url_report . '/report/resource-summary?apiId='.$api_id.'&resource='.$resources.'&year='.$year.'&month='.$month);
            }

            if ($resourcesummary->status == 'success' ) {
                $datas = $resourcesummary->data->details->content;
                if (count($datas) >= 1) {
                    $data['api_id'] = $datas[0]->apiName; 
                }
                $data['total'] = $resourcesummary->data->totalApis;
                $data['count'] = $resourcesummary->data->requestCount;
                $data['data']  = $resourcesummary->data->details->content;
            }
        }

        $pdf = PDF::loadView('admin.usageresource.table_index',$data,['orientation' => 'portrait']);
        $pdf->setPaper('A4', 'portrait');
        return $pdf->download('REPORT_API_RESOURCE_SUMMARY.pdf');

    }

    public function admin_detail_logs_usage_pdf(Request $request){
        $path = $this->encodeCurlyBraces($request->resources);
        $resources = getUrlReports($this->url_report . '/report/resource-summary/details?resource='.$path.'&apiId='.$request->api_id );
        $datas = $resources->data->content;;
        $data['data']  = $datas;
        $data['resources'] = $request->resources;
        $data['year'] = $request->year;
        $month = $request->month;
        $data['month']  = Carbon::createFromDate(null, $month, 1)->format('F');
        
        if(count($datas) >= 1){
            $data['api_name'] = $datas[0]->apiName;
        }

        $pdf = PDF::loadView('admin.usageresource.table_detail',$data,['orientation' => 'portrait']);
        $pdf->setPaper('A4', 'portrait');
        return $pdf->download('REPORT_API_RESOURCE_SUMMARY_DETAIL.pdf');

    }

    public function admin_result_month_summary_usage(Request $request){

        $years = getUrlReports($this->url_report . '/report/months?year='.$request->year );
        return response()->json(['status' => 'success', 'data' => $years]);
    }

    public function admin_result_resource_summary_usage(Request $request){

        $resources = getUrlReports($this->url_report . '/report/resources?apiId='.$request->api_id );
        return response()->json(['status' => 'success', 'data' => $resources]);
    }

    public function admin_api_name_report_summary(Request $request){

        $api_name = getUrlReports($this->url_report . '/report/apis?organization='.$request->organization);
        return response()->json(['status' => 'success', 'data' => $api_name]);
    }

    public function admin_backend_api_usage_page(Request $request){


        $years = getUrlReports($this->url_report . '/report/years' );
        $apis = getUrlReports($this->url_report . '/report/apis' );

        $year = $request->year;
        $month = $request->month;
        $api_name = $request->api_name;
        
        if ($year == null && $month == null) {
            
            $data = [];
        
        } else {
            if ($api_name == 'All' ) {
                $backendusage = getUrlReports($this->url_report . '/report/backend-api?year='.$year.'&month='.$month );
            } else {
                $backendusage = getUrlReports($this->url_report . '/report/backend-api?year='.$year.'&month='.$month.'&apiId='.$api_name );
            }

            if ($backendusage->status == 'success' ) {
                $data  = $backendusage->data->content;
            }
        }
        
        return view('admin.backendapiusage.index',compact('years','year','month','apis','api_name','data'));
    }

    public function admin_detail_backend_api_usage_page(Request $request, $api){
        $api_name = $request->api_name;
        $year = $request->year;
        $month = $request->month;
        $owner = $request->owner;
        $detailapi = getUrlReports($this->url_report . '/report/backend-api/details?apiId='.$api );
        return view('admin.backendapiusage.detail',compact('detailapi','api_name','year','month','owner','api'));
    }

    public function admin_backend_api_usage_pdf(Request $request){

        $year = $request->year;
        $month = $request->month;
        $api_name = $request->api_name;


        $data['year'] = $request->year;
        $data['month'] = $request->month;
        $data['api_name'] = $request->api_name;
        
        if ($year == null && $month == null) {
            
            $data['data'] = [];
        
        } else {
            if ($api_name == 'All' ) {
                $backendusage = getUrlReports($this->url_report . '/report/backend-api?year='.$year.'&month='.$month );
            } else {
                $backendusage = getUrlReports($this->url_report . '/report/backend-api?year='.$year.'&month='.$month.'&apiId='.$api_name );
            }

            if ($backendusage->status == 'success' ) {
                $data['data']  = $backendusage->data->content;
            }
        }

        $pdf = PDF::loadView('admin.backendapiusage.table_index',$data,['orientation' => 'portrait']);
        $pdf->setPaper('A4', 'portrait');
        return $pdf->download('REPORT_API_RESOURCE_SUMMARY.pdf');


    }

    public function admin_detail_backend_api_usage_pdf(Request $request){

        $data['api_name'] = $request->api_name;
        $data['year'] = $request->year;
        $month = $request->month;
        $data['month']  = Carbon::createFromDate(null, $month, 1)->format('F');
        $data['owner'] = $request->owner;
        $api = $request->api;

        $detailapi = getUrlReports($this->url_report . '/report/backend-api/details?apiId='.$api );

        $data['data'] = $detailapi->data->content;


        $pdf = PDF::loadView('admin.backendapiusage.table_detail',$data,['orientation' => 'portrait']);
        $pdf->setPaper('A4', 'portrait');
        return $pdf->download('REPORT_API_RESOURCE_SUMMARY_DETAIL.pdf');

    }

    public function admin_error_summary_page(Request $request){
        
        $apis = getUrlReports($this->url_report . '/report/apis' );

        $api_name = $request->api_name;
        $view_type = $request->view_type;

        if ($api_name == null && $view_type == null) {
            
            $data = [];
            
        } else {

            if ($api_name == 'All') {
                $errorsummary = getUrlReports($this->url_report . '/report/error-summary?asPercent='.$view_type );
            }else{
                $errorsummary = getUrlReports($this->url_report . '/report/error-summary?asPercent='.$view_type.'&apiId='.$api_name );
            }

            if ($errorsummary->status == 'success' ) {
                $data  = $errorsummary->data->content;
            }
            

        }
        
        return view('admin.errorsummary.index',compact('apis','api_name','view_type','data'));
    }

    public function admin_error_summary_pdf(Request $request){

        $currentDateTime = Carbon::now();
        $data['datenow'] = $currentDateTime->format('F d, Y H:i:s');       
        $view_type = $request->view_type;
        
        if ($view_type == 'true') {
            $data['view_type'] = 'Percent';
        } else {
            $data['view_type'] = 'Count';
        }

        $api_name = $request->api_name;        
        $data['api_name'] = $request->api_name;

        if ($api_name == null && $view_type == null) {
            
            $data = [];
            
        } else {

            if ($api_name == 'All') {
                $errorsummary = getUrlReports($this->url_report . '/report/error-summary?asPercent='.$view_type );
            }else{
                $errorsummary = getUrlReports($this->url_report . '/report/error-summary?asPercent='.$view_type.'&apiId='.$api_name );
            }

            if ($errorsummary->status == 'success' ) {
                $datas  = $errorsummary->data->content;
                $data['data'] = $datas;
            }
    
        }

        $pdf = PDF::loadView('admin.errorsummary.table_index',$data,['orientation' => 'portrait']);
        $pdf->setPaper('A4', 'portrait');
        return $pdf->download('REPORT_ERROR_SUMMARY.pdf');
        // return view('admin.errorsummary.table_index');
    }

    public function admin_invoice_page(){

        $invoices = getUrlBillings($this->url_billing .'/invoices' );
        return view('admin.transaction.invoice.index',compact('invoices'));
    }

    public function admin_create_invoice_page(){
        return view('admin.transaction.invoice.create_invoice');
    }

    public function admin_payment_page(){

        return view('admin.transaction.payment.index');
    }

    public function admin_dashboard_page(Request $request){

        $periode = [
            'year' => 'Recent Year',
            'month' => 'This Month',
            'week' => 'This Week',
            'today'=> 'Today',
        ];
        $total_report = getUrlReports($this->url_report . '/dashboard/total-report' );
        $data_report = $total_report->data;
        return view('admin.dashboard.index',compact('data_report','total_report','periode'));
    }

    public function admin_doughnut_chart_api_usage(Request $request){
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

        $api_usage = getUrlReports($this->url_report . '/dashboard/percentage-report?byApi=true&top='.$top );
        if ($api_usage->data->byApi == []) {
            $apiname = ['No Data Available'];
            $usage_count = ['1'];
        } else {
            $apiname = collect($api_usage->data->byApi)->pluck('apiName')->all();
            $usage_count = collect($api_usage->data->byApi)->pluck('rowCount')->all();
        }
        return view('admin.dashboard.doughnut.api_usage',compact('apiname','usage_count','color'));
    }

    public function admin_doughnut_chart_response_count(Request $request){
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
        $response_code = getUrlReports($this->url_report . '/dashboard/percentage-report?byResponseCode=true&top='.$top );
        if ($response_code->data->byResponseCode == []) {
            $response_name = ['No Data Available'];
            $response_count = ['1'];
        } else {
            $response_name = collect($response_code->data->byResponseCode)->pluck('proxyResponseCode')->all();
            $response_count = collect($response_code->data->byResponseCode)->pluck('rowCount')->all();
        }

        return view('admin.dashboard.doughnut.response_count',compact('response_name','response_count','color'));
    }

    public function admin_doughnut_chart_application_usage(Request $request){
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
        $application = getUrlReports($this->url_report . '/dashboard/percentage-report?byApplication=true&top='.$top );
        if ($application->data->byApplication == []) {
            $application_name = ['No Data Available'];
            $application_count = ['1'];
        } else {
            $application_name = collect($application->data->byApplication)->pluck('applicationName')->all();
            $application_count = collect($application->data->byApplication)->pluck('rowCount')->all();
        }
        return view('admin.dashboard.doughnut.application_usage',compact('application_name','application_count','color'));
    }

    public function admin_table_quota_subscription(Request $request){
         
        $quota_subs = getUrlReports($this->url_report . '/report/subscriptions/remaining?size=99999' );
        foreach ($quota_subs->data->content as $item) {
            if ($item->remaining > 0) {
                $item->percentage = $item->remaining / $item->quota * 100;
            } else {
                $item->percentage = 100;
            }
        }    
        return view('admin.dashboard.table.quota_subscription',compact('quota_subs'));
    }

    public function admin_bar_chart_top_usage(Request $request){
        
        $time = $request->periodTop;
        if (empty($time)) {
            $top_api_usage = getUrlReports($this->url_report . '/dashboard/api-usage?filter=year&top=10' );
        }else{
            $top_api_usage = getUrlReports($this->url_report . '/dashboard/api-usage?filter='.$time.'&top=10' );
        }

        $color = [
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
        
        $bordercolor = [
            'rgb(255, 99, 132, 0.5)',
            'rgb(54, 162, 235, 0.5)',
            'rgb(255, 205, 86, 0.5)',
            'rgb(150, 149, 237, 0.5)',
            'rgb(46, 139, 87, 0.5)',
            'rgb(255, 165, 0, 0.5)',
            'rgb(218, 112, 214, 0.5)',
            'rgb(0, 128, 128, 0.5)',
            'rgb(255, 192, 203, 0.5)',
            'rgb(70, 130, 180, 0.5)',
        ];
        
        if (empty($top_api_usage->data)) {
            $x_data_api_usage = ['No Data'];
            $count_data = [1];
            $datasets_api_usage = [
                [
                    'label' => 'No Data',
                    'data' => $count_data,
                    'backgroundColor' => [$color[0]],
                    'borderColor' => [$bordercolor[0]],
                    'borderWidth' => 3,
                ]
            ];
        } else {
            $top_api_names = collect($top_api_usage->data)->pluck('apiName')->all();
            $x_data_api_usage = collect($top_api_usage->data[0]->data)->pluck('x')->all();
        
            $datasets_api_usage = collect($top_api_usage->data)->map(function ($item, $index) use ($top_api_names, $color, $bordercolor) {
                $count_data = collect($item->data)->pluck('totalUsage')->all();
                return [
                    'label' => $top_api_names[$index],
                    'data' => $count_data,
                    'backgroundColor' => [$color[$index]],
                    'borderColor' => [$bordercolor[$index]],
                    'borderWidth' => 3,
                ];
            })->all();
        }

        return view('admin.dashboard.bar.api_usage',compact('x_data_api_usage','datasets_api_usage'));
    }

    public function admin_bar_chart_fault_overtime(Request $request) {
        $color = [
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
        
        $bordercolor = [
            'rgb(255, 99, 132, 0.5)',
            'rgb(54, 162, 235, 0.5)',
            'rgb(255, 205, 86, 0.5)',
            'rgb(150, 149, 237, 0.5)',
            'rgb(46, 139, 87, 0.5)',
            'rgb(255, 165, 0, 0.5)',
            'rgb(218, 112, 214, 0.5)',
            'rgb(0, 128, 128, 0.5)',
            'rgb(255, 192, 203, 0.5)',
            'rgb(70, 130, 180, 0.5)',
        ];
    
        $time = $request->periodFault;
        if (empty($time)) {
            $fault_overtime_chart = getUrlReports($this->url_report . '/dashboard/api-fault?filter=year');
        } else {
            $fault_overtime_chart = getUrlReports($this->url_report . '/dashboard/api-fault?filter='. $time);
        }
    
        if (empty($fault_overtime_chart->data)) {
            $x_data_fault_overtime = ['No Data'];
            $count_data = [1];
            $datasets_fault_overtime = [
                [
                    'label' => 'No Data',
                    'data' => $count_data,
                    'backgroundColor' => [$color[0]],
                    'borderColor' => [$bordercolor[0]],
                    'borderWidth' => 3,
                ]
            ];
        } else {
            $top_api_names = collect($fault_overtime_chart->data)->pluck('apiName')->all();
            $x_data_fault_overtime = collect($fault_overtime_chart->data[0]->data)->pluck('x')->all();
            $datasets_fault_overtime = collect($fault_overtime_chart->data)->map(function ($item, $index) use ($top_api_names, $color, $bordercolor) {
                $count_data = collect($item->data)->pluck('totalFault')->all();
                return [
                    'label' => $top_api_names[$index],
                    'data' => $count_data,
                    'backgroundColor' => [$color[$index]],
                    'borderColor' => [$bordercolor[$index]],
                    'borderWidth' => 3,
                ];
            })->all();
        }
    
        return view('admin.dashboard.bar.api_fault_overtime', compact('x_data_fault_overtime', 'datasets_fault_overtime'));
    }

    public function admin_table_fault_overtime(Request $request){

        $time = $request->periodFault;
        if (empty($time)) {
            $fault_table = getUrlReports($this->url_report . '/dashboard/api-fault/details?filter=year' );
        }else{
            $fault_table = getUrlReports($this->url_report . '/dashboard/api-fault/details?filter='.$time );
        }
 
        return view('admin.dashboard.table.api_fault_overtime',compact('fault_table'));
    }   
}
