@extends('app')
@section('content')

<div class="container">
    <div class="row my-5">
        <div class="col-12">
            <div class="row">
                <div class="col-12 col-lg-6">
                    <h1>Admin Dashboard</h1>
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
                                    <img width="65" height="50"
                                        src="{{ asset ('assets/images/application/application-icon.png') }}" alt="">
                                </div>
                                <div class="col-8 text-center">
                                    <div class="fw-bold" style="font-size: 14px;">
                                        Subscription API
                                    </div>
                                    <div class="fw-bold text-center" style="font-size: 24px;">
                                        {{ $data_report->totalSubscriber }}
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
                                    <img width="50" height="50"
                                        src="{{ asset ('assets/images/application/icon-rejected.png') }}" alt="">
                                </div>
                                <div class="col-8 text-center">
                                    <div class="fw-bold" style="font-size: 14px;">
                                        APIs
                                    </div>
                                    <div class="fw-bold text-center" style="font-size: 24px;">
                                        {{ $data_report->totalApi }}
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
                                    <img width="50" height="50"
                                        src="{{ asset ('assets/images/application/icon-create.png') }}" alt="">
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
                                    <img width="50" height="50"
                                        src="{{ asset ('assets/images/application/icon-approved.png') }}" alt="">
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
            </div>
        </div>
        <div class="col-12 my-5" id="data-chart-customer">
            <div class="row g-5">
                @include('admin.dashboard.doughnut.api_usage')   
                @include('admin.dashboard.doughnut.response_count')   
                @include('admin.dashboard.doughnut.application_usage')   
                <div class="col-12" id="table-quota-subscription">      
                </div>   
                <div class="col-12" id="bar-api-top-10-usage">
                </div>
                <div class="col-12">
                    <div class="card card-shadow-app rounded-4">
                        <div class="card-body">
                            <div class="row p-2">
                                <div class="col-12" id="bar-fault-overtime">
                                </div>
                                <hr class="my-5">
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
        getTopApiUsage();
        getFaultOvertimeChart();
        getFaultOvertimeTable();
        getQuotaSubscriptionTable();
    });

    function getTopApiUsage(params) {
        $.ajax({
            type: "GET",
            url: "{{ route('admin.bar.chart.top.usage') }}",
            dataType: 'html',
            data: {
            },
            beforeSend: function() {
                $('#bar-api-top-10-usage').html('');
            },
            success: function(data) {
                $('#bar-api-top-10-usage').html(data);
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
        $.ajax({
            type: "GET",
            url: "{{ route('admin.bar.chart.fault.overtime') }}",
            dataType: 'html',
            data: {
            },
            beforeSend: function() {
                $('#bar-fault-overtime').html('');
            },
            success: function(data) {
                $('#bar-fault-overtime').html(data);
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
        $.ajax({
            type: "GET",
            url: "{{ route('admin.table.fault.overtime') }}",
            dataType: 'html',
            data: {
            },
            beforeSend: function() {
                $('#table-fault-overtime').html('');
            },
            success: function(data) {
                $('#table-fault-overtime').html(data);
            },
            complete: function() {
            },
            error: function(xhr, ajaxOptions, thrownError) {
                var pesan = xhr.status + " " + thrownError + "\n" + xhr.responseText;
                $('#table-fault-overtime').html(pesan);
            },
        });
    }

    function getQuotaSubscriptionTable(params) {
        $.ajax({
            type: "GET",
            url: "{{ route('admin.table.quota.subscription') }}",
            dataType: 'html',
            data: {
            },
            beforeSend: function() {
                $('#table-quota-subscription').html('');
            },
            success: function(data) {
                $('#table-quota-subscription').html(data);
            },
            complete: function() {
            },
            error: function(xhr, ajaxOptions, thrownError) {
                var pesan = xhr.status + " " + thrownError + "\n" + xhr.responseText;
                $('#table-quota-subscription').html(pesan);
            },
        });
    }
    </script>
@endpush    

@endsection