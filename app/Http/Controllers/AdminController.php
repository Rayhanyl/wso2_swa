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


use function GuzzleHttp\Promise\all;

class AdminController extends Controller
{

    public function __construct(){   
        $this->url_report = getUrlReport();
        $this->url_billing = getUrlBilling();
        $this->url = getUrlApi();
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
        $data['month'] = $month;
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
        $data['month'] = $month;

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
                $total = $resourcesummary->data->totalApis;
                $count = $resourcesummary->data->requestCount;
                $data  = $resourcesummary->data->details->content;
            }
        }

        return view('admin.usageresource.index',compact('years','year','apis','api_id','total','count','data','month','resources'));
    }

    public function admin_detail_logs_usage(Request $request){

        $resources = getUrlReports($this->url_report . '/report/resource-summary/details?resource='.$request->resource.'&apiId='.$request->api_id );
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
        $data['month'] = $month;
        $data['resources'] = $resources;
        $data['api_id'] = $api_id;

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
        
        $resources = getUrlReports($this->url_report . '/report/resource-summary/details?resource='.$request->resources.'&apiId='.$request->api_id );
        $datas = $resources->data->content;;
        $data['data']  = $datas;
        $data['resources'] = $request->resources;
        $data['year'] = $request->year;
        $data['month'] = $request->month;
        
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
        $data['month'] = $request->month;
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

        $top = 10;
        $color =[
            'rgb(255, 99, 132)',
            'rgb(54, 162, 235)',
            'rgb(255, 205, 86)',
            'rgb(150, 149, 237)',
            'rgb(46, 139, 87)',
            'rgb(255, 165, 0)',
            'rgb(218, 112, 214)',
            'rgb(0, 128, 128)',
            'rgb(255, 192, 203)',
            'rgb(70, 130, 180)',
        ];

        $total_report = getUrlReports($this->url_report . '/dashboard/total-report' );
        $data_report = $total_report->data;

        $api_usage = getUrlReports($this->url_report . '/dashboard/percentage-report?byApi=true&top='.$top );
        $apiname = collect($api_usage->data->byApi)->pluck('apiName')->all();
        $usage_count = collect($api_usage->data->byApi)->pluck('rowCount')->all();

        $response_code = getUrlReports($this->url_report . '/dashboard/percentage-report?byResponseCode=true&top='.$top );
        $response_name = collect($response_code->data->byResponseCode)->pluck('proxyResponseCode')->all();
        $response_count = collect($response_code->data->byResponseCode)->pluck('rowCount')->all();

        $response_code = getUrlReports($this->url_report . '/dashboard/percentage-report?byApplication=true&top='.$top );
        $application_name = collect($response_code->data->byApplication)->pluck('applicationName')->all();
        $application_count = collect($response_code->data->byApplication)->pluck('rowCount')->all();

        $quota_subs = getUrlReports($this->url_report . '/report/subscriptions/remaining' );
        
        return view('admin.dashboard.index',compact('data_report','apiname','usage_count','response_name','response_count','application_name','application_count','color','quota_subs'));
    }

}
