<?php

namespace App\Http\Controllers;

use stdClass;
use Illuminate\Http\Request;
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
        
        return view('admin.reportapi.index',compact('years'));
    }

    public function admin_api_resource_usage_summary_page(Request $request){

        $years = getUrlReports($this->url_report . '/report/years' );
        $apis = getUrl($this->url . '/apis');

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

        return view('admin.usageresource.index',compact('years','year','apis','api_id','total','count','data'));
    }

    public function admin_detail_logs_usage(Request $request){

        $resources = getUrlReports($this->url_report . '/report/resource-summary/details?resource='.$request->resource.'&apiId='.$request->api_id );
        $data  = $resources->data->content;
        $resources = $request->resource;
        
        if(count($data) >= 1){
            $api_name = $data[0]->apiName;
        }

        return view('admin.usageresource.detailusage',compact('data','resources','api_name'));
    }

    public function admin_result_month_summary_usage(Request $request){

        $years = getUrlReports($this->url_report . '/report/months?year='.$request->year );
        return response()->json(['status' => 'success', 'data' => $years]);
    }

    public function admin_result_resource_summary_usage(Request $request){

        $resources = getUrlReports($this->url_report . '/report/resources?apiId='.$request->api_id );
        return response()->json(['status' => 'success', 'data' => $resources]);
    }

    public function admin_invoice_page(){

        $invoices = getUrlBillings($this->url_billing .'/invoices' );
        return view('admin.transaction.invoice.index',compact('invoices'));
    }

    public function admin_payment_page(){

        return view('admin.transaction.payment.index');
    }


}
