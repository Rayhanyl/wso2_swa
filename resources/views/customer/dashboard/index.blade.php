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
                @include('customer.dashboard.doughnut.api_usage')   
                @include('customer.dashboard.doughnut.response_count')   
                @include('customer.dashboard.doughnut.application_usage')   
                @include('customer.dashboard.table.quota_subscription')   
                @include('customer.dashboard.bar.api_usage')
                @include('customer.dashboard.bar.api_fault_overtime')
                @include('customer.dashboard.table.api_fault_overtime')
            </div>
        </div>
    </div>
</div>
@endsection
