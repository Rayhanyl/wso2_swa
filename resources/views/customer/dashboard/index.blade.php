@extends('app')
@section('content')

<div class="container">
    <div class="row my-5">
        <div class="col-12">
            <div class="row">
                <div class="col-12 col-lg-6">
                    <h1>Dashboard</h1>
                </div>
            </div>
        </div>
        <div class="col-12 mt-5">
            <div class="row">
                <div class="col-12 col-lg-3">
                    <div class="card card-shadow-app rounded-4">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-4 d-flex align-items-center justify-content-center">
                                    <img width="65" height="65"
                                        src="{{ asset ('assets/images/icon/tota_dashboard.png') }}" alt="">
                                </div>
                                <div class="col-8 text-center">
                                    <div class="fw-bold" style="font-size: 14px;">
                                        Subscription API
                                    </div>
                                    <div class="fw-bold text-center" style="font-size: 24px;">
                                        {{ $data_report->totalSubscriptionAPI }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-3">
                    <div class="card card-shadow-app rounded-4">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-4 d-flex align-items-center justify-content-center">
                                    <img width="65" height="65"
                                        src="{{ asset ('assets/images/icon/warning_dashboard.png') }}" alt="">
                                </div>
                                <div class="col-8 text-center">
                                    <div class="fw-bold" style="font-size: 14px;">
                                        Invoice Unpaid
                                    </div>
                                    <div class="fw-bold text-center" style="font-size: 24px;">
                                        {{ $data_report->totalUnpaid }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-3">
                    <div class="card card-shadow-app rounded-4">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-4 d-flex align-items-center justify-content-center">
                                    <img width="65" height="65"
                                        src="{{ asset ('assets/images/icon/customer_dashboard.png') }}" alt="">
                                </div>
                                <div class="col-8 text-center">
                                    <div class="fw-bold" style="font-size: 14px;">
                                        Application
                                    </div>
                                    <div class="fw-bold text-center" style="font-size: 24px;">
                                        {{ $data_report->totalApplication }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-3">
                    <div class="card card-shadow-app rounded-4">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-4 d-flex align-items-center justify-content-center">
                                    <img width="65" height="65"
                                        src="{{ asset ('assets/images/icon/api_dashboard.png') }}" alt="">
                                </div>
                                <div class="col-8 text-center">
                                    <div class="fw-bold" style="font-size: 14px;">
                                        Response Fault
                                    </div>
                                    <div class="fw-bold text-center" style="font-size: 24px;">
                                        {{ $data_report->totalResponseFault }}                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 my-5" id="data-chart-customer">
            <div class="row g-5">
                <div class="col-12 col-lg-4">
                    <div class="col-12">
                        <div id="doughnut-api-usage">
                        </div>
                        <div class="text-center" id="loader-doughnut-api-usage">
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-4">
                    <div id="doughnut-application-usage">
                    </div>
                    <div id="loader-doughnut-application-usage">
                    </div>
                </div>
                <div class="col-12 col-lg-4">
                    <div id="doughnut-response-count">
                    </div>
                    <div id="loader-doughnut-response-count">
                    </div>
                </div>
                <div class="col-12">      
                    <div id="table-quota-subscription">
                    </div>
                    <div id="loader-table-quota-subscription">
                    </div>
                </div>
                <div class="col-12">
                    <div class="card card-shadow-app rounded-4">
                        <div class="card-body row justify-content-center">
                            <div class="my-2">
                                <label class="my-2 fw-bold" for="period_top_10"><i class='bx bxs-calendar'></i> Period</label>
                                <select class="form-control text-capitalize" name="period_top_10" id="period_top_10">
                                    @foreach ($periode as $idx => $item)
                                        <option class="text-capitalize" value="{{ $idx }}">{{ $item }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div id="bar-api-top-10-usage">
                            </div>
                            <div id="loader-bar-api-top-10-usage">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card card-shadow-app rounded-4">
                        <div class="card-body">
                            <div class="row p-2">
                                <div class="my-2">
                                    <label class="my-2 fw-bold" for="period_fault_overtime"><i class='bx bxs-calendar'></i> Period</label>
                                    <select class="form-control text-capitalize" name="period_fault_overtime" id="period_fault_overtime">
                                        @foreach ($periode as $idx => $item)
                                        <option class="text-capitalize" value="{{ $idx }}">{{ $item }}</option>
                                    @endforeach
                                    </select>
                                </div>
                                <div id="loader-bar-fault-overtime">
                                </div>
                                <div class="col-12" id="bar-fault-overtime">
                                </div>
                                <hr class="my-5">
                                <div class="col-12" id="loader-table-fault-overtime">
                                </div>
                                <div class="col-12" id="table-fault-overtime">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>   
            </div>
        </div>
    </div>
</div>

@push('script')
    <script>

        $(document).ready(function () {
            getApiUsageChart();
            getApplicationUsageChart();
            getResponseCountChart();
            getQuotaSubscriptionTable();
            getTopApiUsageChart($('#period_top_10').val());
            getFaultOvertimeChart($('#period_fault_overtime').val());
            getFaultOvertimeTable($('#period_fault_overtime').val());
        });

        function getApiUsageChart(params) {
            $.ajax({
                type: "GET",
                url: "{{ route('customer.doughtnut_chart_api_usage') }}",
                dataType: 'html',
                data: {
                },
                beforeSend: function() {
                    $('#doughnut-api-usage').html('');
                    $('#loader-doughnut-api-usage').html('<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>');
                },
                success: function(data) {
                    $('#doughnut-api-usage').html(data);
                    $('#loader-doughnut-api-usage').html('');
                },
                complete: function() {
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    var pesan = xhr.status + " " + thrownError + "\n" + xhr.responseText;
                    $('#doughnut-api-usage').html(pesan);
                },
            });
        }

        function getApplicationUsageChart(params) {
            $.ajax({
                type: "GET",
                url: "{{ route('customer.doughtnut.chart.application.usage') }}",
                dataType: 'html',
                data: {
                },
                beforeSend: function() {
                    $('#doughnut-application-usage').html('');
                    $('#loader-doughnut-application-usage').html('<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>');
                },
                success: function(data) {
                    $('#doughnut-application-usage').html(data);
                    $('#loader-doughnut-application-usage').html('');
                },
                complete: function() {
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    var pesan = xhr.status + " " + thrownError + "\n" + xhr.responseText;
                    $('#doughnut-application-usage').html(pesan);
                },
            });
        }

        function getResponseCountChart(params) {
            $.ajax({
                type: "GET",
                url: "{{ route('customer.doughtnut.chart.response.count') }}",
                dataType: 'html',
                data: {
                },
                beforeSend: function() {
                    $('#doughnut-response-count').html('');
                    $('#loader-doughnut-response-count').html('<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>');
                },
                success: function(data) {
                    $('#doughnut-response-count').html(data);
                    $('#loader-doughnut-response-count').html('');
                },
                complete: function() {
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    var pesan = xhr.status + " " + thrownError + "\n" + xhr.responseText;
                    $('#doughnut-response-count').html(pesan);
                },
            });
        }

        function getQuotaSubscriptionTable(params) {
            $.ajax({
                type: "GET",
                url: "{{ route('customer.table.quota.subscription') }}",
                dataType: 'html',
                data: {
                },
                beforeSend: function() {
                    $('#table-quota-subscription').html('');
                    $('#loader-table-quota-subscription').html('<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>');
                },
                success: function(data) {
                    $('#table-quota-subscription').html(data);
                    $('#loader-table-quota-subscription').html('');
                },
                complete: function() {
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    var pesan = xhr.status + " " + thrownError + "\n" + xhr.responseText;
                    $('#table-quota-subscription').html(pesan);
                },
            });
        }

        function getTopApiUsageChart(params) {
            let periodTop = params;
            $.ajax({
                type: "GET",
                url: "{{ route('customer.bar.chart.top.usage') }}",
                dataType: 'html',
                data: {
                    periodTop,
                },
                beforeSend: function() {
                    $('#bar-api-top-10-usage').html('');
                    $('#loader-bar-api-top-10-usage').html('<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>');
                },
                success: function(data) {
                    $('#bar-api-top-10-usage').html(data);
                    $('#loader-bar-api-top-10-usage').html('');
                },
                complete: function() {
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    var pesan = xhr.status + " " + thrownError + "\n" + xhr.responseText;
                    $('#bar-api-top-10-usage').html(pesan);
                },
            });
        }

        function getFaultOvertimeChart(params) {
            let periodFault = params;
            $.ajax({
                type: "GET",
                url: "{{ route('customer.bar.chart.fault.overtime') }}",
                dataType: 'html',
                data: {
                    periodFault,
                },
                beforeSend: function() {
                    $('#bar-fault-overtime').html('');
                    $('#loader-bar-fault-overtime').html('<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>');
                },
                success: function(data) {
                    $('#bar-fault-overtime').html(data);
                    $('#loader-bar-fault-overtime').html('');
                },
                complete: function() {
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    var pesan = xhr.status + " " + thrownError + "\n" + xhr.responseText;
                    $('#bar-fault-overtime').html(pesan);
                },
            });
        }

        function getFaultOvertimeTable(params) {
            let periodFault = params;
            $.ajax({
                type: "GET",
                url: "{{ route('customer.table.fault.overtime') }}",
                dataType: 'html',
                data: {
                    periodFault,
                },
                beforeSend: function() {
                    $('#table-fault-overtime').html('');
                    $('#loader-table-fault-overtime').html('<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>');
                },
                success: function(data) {
                    $('#table-fault-overtime').html(data);
                    $('#loader-table-fault-overtime').html('');
                },
                complete: function() {
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    var pesan = xhr.status + " " + thrownError + "\n" + xhr.responseText;
                    $('#table-fault-overtime').html(pesan);
                },
            });
        }
        
        $(document).on('change', '#period_top_10', function(e) {
            e.preventDefault();
            getTopApiUsageChart($(this).val());
        });

        $(document).on('change', '#period_fault_overtime', function(e) {
            e.preventDefault();
            getFaultOvertimeChart($(this).val());
            getFaultOvertimeTable($(this).val());
        });


    </script>
@endpush  

@endsection
