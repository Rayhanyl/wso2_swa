<?php

namespace App\Http\Controllers;

use stdClass;
use Svg\Tag\Rect;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpParser\Node\Stmt\Return_;
use Illuminate\Support\Facades\Http;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;
use GuzzleHttp\Exception\RequestException;



class CustomerController extends Controller
{

    public function __construct(){   
        $this->url_billing = getUrlBilling();
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
                $month = $request->month;
                $data['month']  = Carbon::createFromDate(null, $month, 1)->format('F');
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
        $month = $request->month;
        $data['month']  = Carbon::createFromDate(null, $month, 1)->format('F');
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
        $data['month']  = Carbon::createFromDate(null, $month, 1)->format('F');
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

    private function encodeCurlyBraces($url){
        $encodedUrl = str_replace(['{', '}', '/'], ['%7B', '%7D', '%2F'], $url);
        return $encodedUrl;
    }
    
    public function customer_detail_logs_usage(Request $request){
        
        $resources = $this->encodeCurlyBraces($request->resource);
        $username = session('username');
        $resources = getUrlReports($this->url_report . '/report/resource-summary/details?username='.$username.'&resource='.$resources.'&apiId='.$request->api_id );
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
        $resources = $this->encodeCurlyBraces($request->resources);
        $username = session('username');    
        $resources = getUrlReports($this->url_report . '/report/resource-summary/details?username='.$username.'&resource='.$resources.'&apiId='.$request->api_id );
        $datas = $resources->data->content;
        $data['data']  = $datas;
        $month = $request->month;
        $data['month']  = Carbon::createFromDate(null, $month, 1)->format('F');
        $data['resources'] = $request->resources;
        $data['year'] = $request->year;
        $data['username'] = session('username');    
        if(count($datas) >= 1){
            $data['api_name'] = $datas[0]->apiName;
        }

        $pdf = PDF::loadView('customer.usageresource.table_detail',$data,['orientation' => 'portrait']);
        $pdf->setPaper('A4', 'portrait');
        return $pdf->download('REPORT_API_RESOURCE_SUMMARY_DETAIL.pdf');
    }

    public function customer_dashboard_page(Request $request){

        $periode = [
            'year' => 'Recent Year',
            'month' => 'This Month',
            'week' => 'This Week',
            'today'=> 'Today',
        ];
        $total_report = getUrlReports($this->url_report . '/dashboard/total-report?username='.session('username') );
        $data_report = $total_report->data;
        return view('customer.dashboard.index',compact('data_report','periode'));
    }

    public function customer_doughnut_chart_api_usage(Request $request){
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

        $api_usage = getUrlReports($this->url_report . '/dashboard/percentage-report?byApi=true&username='.session('username').'&top='.$top );
        if ($api_usage->data->byApi == []) {
            $apiname = ['No Data Available'];
            $usage_count = ['1'];
        } else {
            $apiname = collect($api_usage->data->byApi)->pluck('apiName')->all();
            $usage_count = collect($api_usage->data->byApi)->pluck('rowCount')->all();
        }
        return view('customer.dashboard.doughnut.api_usage',compact('apiname','usage_count','color'));
    }

    public function customer_doughnut_chart_application_usage(Request $request){
        $top = 10;
        $username = session('username');
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
        $application = getUrlReports($this->url_report . '/dashboard/percentage-report?byApplication=true&username='.$username.'&top='.$top );
        if ($application->data->byApplication == []) {
            $application_name = ['No Data Available'];
            $application_count = ['1'];
        } else {
            $application_name = collect($application->data->byApplication)->pluck('applicationName')->all();
            $application_count = collect($application->data->byApplication)->pluck('rowCount')->all();
        }
        return view('customer.dashboard.doughnut.application_usage',compact('application_name','application_count','color'));
    }

    public function customer_doughnut_chart_response_count(Request $request){
        $top = 10;  
        $username = session('username');
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
        $response_code = getUrlReports($this->url_report . '/dashboard/percentage-report?username='.$username.'&byResponseCode=true&top=10');
        if ($response_code->data->byResponseCode == []) {
            $response_name = ['No Data Available'];
            $response_count = ['1'];
        } else {
            $response_name = collect($response_code->data->byResponseCode)->pluck('proxyResponseCode')->all();
            $response_count = collect($response_code->data->byResponseCode)->pluck('rowCount')->all();
        }

        return view('customer.dashboard.doughnut.response_count',compact('response_name','response_count','color'));
    }

    public function customer_table_quota_subscription(Request $request){
         
        $username = session('username');
        $quota_subs = getUrlReports($this->url_report . '/report/subscriptions/remaining?page=0&size=99999&username='.$username );
        foreach ($quota_subs->data->content as $item) {
            if ($item->remaining > 0) {
                $item->percentage = $item->remaining / $item->quota * 100;
            } else {
                $item->percentage = 100;
            }
        }    
        return view('customer.dashboard.table.quota_subscription',compact('quota_subs'));
    }

    public function customer_bar_chart_top_usage(Request $request){
        
        $username = session('username');    
        $time = $request->periodTop;
        if (empty($time)) {
            $top_api_usage = getUrlReports($this->url_report . '/dashboard/api-usage?filter=year&top=10&username='.$username );
        }else{
            $top_api_usage = getUrlReports($this->url_report . '/dashboard/api-usage?filter='.$time.'&top=10&username='.$username );
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
            $count_data = [0];
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

        return view('customer.dashboard.bar.api_usage',compact('x_data_api_usage','datasets_api_usage'));
    }

    public function customer_bar_chart_fault_overtime(Request $request) {
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
    
        $username = session('username');
        $time = $request->periodFault;
        if (empty($time)) {
            $fault_overtime_chart = getUrlReports($this->url_report . '/dashboard/api-fault?username='.$username.'&filter=year');
        } else {
            $fault_overtime_chart = getUrlReports($this->url_report . '/dashboard/api-fault?username='.$username.'&filter='.$time);
        }
    
        if (empty($fault_overtime_chart->data)) {
            $x_data_fault_overtime = ['No Data'];
            $count_data = [0];
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
    
        return view('customer.dashboard.bar.api_fault_overtime', compact('x_data_fault_overtime', 'datasets_fault_overtime'));
    }

    public function customer_table_fault_overtime(Request $request){

        $username = session('username');
        $time = $request->periodFault;
        if (empty($time)) {
            $fault_table = getUrlReports($this->url_report . '/dashboard/api-fault/details?username='.$username.'&filter=year' );
        }else{
            $fault_table = getUrlReports($this->url_report . '/dashboard/api-fault/details?username='.$username.'&filter='.$time );
        }
 
        return view('customer.dashboard.table.api_fault_overtime',compact('fault_table'));
    }   

    public function customer_payment_page(Request $request){
        $invoiceID = $this->encodeCurlyBraces($request->invoiceId);
        $payment = getUrlBillings($this->url_billing .'/invoices/detail?invoiceId='.$invoiceID );
        return view('customer.transaction.payment.index',compact('payment'));
    }

    public function customer_create_payment(Request $request){
        // dd($request->all());
        $notify = $request->notify;
        $notify = str_replace(['[',']'],'', $notify);
        $notify = explode(',', $notify);
        $email = isset($notify[0]) ? $notify[0] : null;
        $wa = isset($notify[1]) ? $notify[1] : null;
        if (empty($email)) {
            $list = [$wa];
        } elseif (empty($wa)) {
            $list = [$email];
        } else {
            $list = [$email,$wa];
        }

        $validator = Validator::make($request->all(), [
            'attachement_payment_slip' => 'required|file|mimes:jpeg,png,pdf|max:2048',
        ]);

        if ($validator->fails()) {
            Alert::warning('Failed', $validator);
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            try {

                $client = new Client();
                $attachment = $request->file('attachement_payment_slip');
                $multipart = [
                    [
                        'name' => 'invoiceId',
                        'contents' => $request->invoice_id
                    ],
                    [
                        'name' => 'notes',
                        'contents' => $request->berita_acara
                    ],
                    [
                        'name' => 'attachment',
                        'contents' => fopen($attachment->getPathname(), 'r'),
                        'filename' => $attachment->getClientOriginalName()
                    ],
                ];

                foreach ($list as $item) {
                    $multipart[] = [
                        'name' => 'notifyList[]',
                        'contents' => $item
                    ];
                }

                $response = $client->request('POST', $this->url_billing . '/payments', [
                    'multipart' => $multipart,
                ]);

                $data = json_decode($response->getBody()->getContents());
                Alert::toast('Thank you for paying', 'success');
                return redirect(route('customer.payment.history.page'));
            } catch (RequestException $e) {
                dd($e->getMessage());
            }
        }
    }
    
    public function customer_payment_history_page(){

        return view('customer.transaction.payment.payment_history');
    }

    public function customer_history_waiting(Request $request){

        $username = session('username');
        $waiting = getUrlBillings($this->url_billing .'/payments?username='.$username.'&status=1' );
        return view('customer.transaction.payment.history.waiting',compact('waiting'));
    }

    public function customer_history_accepted(Request $request){

        $username = session('username');
        $accepted = getUrlBillings($this->url_billing .'/payments?username='.$username.'&status=2' );
        return view('customer.transaction.payment.history.accepted', compact('accepted'));
    }

    public function customer_history_rejected(Request $request){

        $username = session('username');
        $rejected = getUrlBillings($this->url_billing .'/payments?username='.$username.'&status=3' );
        return view('customer.transaction.payment.history.rejected', compact('rejected'));
    }

    public function customer_invoice_page(Request $request){
        $username = session('username');
        $invoices = getUrlBillings($this->url_billing .'/invoices?username='.$username );
        return view('customer.transaction.invoice.index',compact('invoices'));
    }
    
}
