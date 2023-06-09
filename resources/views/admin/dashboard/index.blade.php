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
                @include('admin.dashboard.table.quota_subscription')   

                {{-- <div class="col-12">
                    <div class="card card-shadow-app rounded-4">
                        <div class="card-body row justify-content-center">
                            <div>
                                <canvas id="lineChart1"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card card-shadow-app rounded-4">
                        <div class="card-body row justify-content-center">
                            <div style="width:100%;height:400px;">
                                <canvas id="lineChart2"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card card-shadow-app rounded-4" style="height: 430px;">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="data-table-dashboard-fault-overtime"
                                style="width:100%">
                                <thead class="table-orange">
                                    <tr>
                                        <th>Time</th>
                                        <th>Application</th>
                                        <th>API</th>
                                        <th>Count</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>10-aug-2023</td>
                                        <td>DefaultApplication</td>
                                        <td>Pizzahack</td>
                                        <td>6</td>
                                    </tr>
                                </tbody>
                            </table>
                            </div>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
</div>

@push('script')
    <script>
        
        // $(document).ready(function () {
        //     $('#data-table-dashboard-quota-subscription').DataTable({
        //         responsive: true,
        //         lengthMenu: [
        //             [5, 25, 50, -1],
        //             [10, 25, 50, 'All'],
        //         ],
        //     });

        //     $('#data-table-dashboard-fault-overtime').DataTable({
        //         responsive: true,
        //         lengthMenu: [
        //             [5, 25, 50, -1],
        //             [10, 25, 50, 'All'],
        //         ],
        //     });
        // });

        // var ctx4 = document.getElementById('lineChart1').getContext('2d');
        // var chart = new Chart(ctx4, {
        //     type: 'line',
        //     data: {
        //         labels: ['1-mei-2023', '1-june-2023', '1-July-2023', '1-Aug-2023', '1-Sep-2023', '1-Okt-2023', '1-Nov-2023', '1-Dec-2023'],
        //         datasets: [{
        //             label: 'PizzaShack',
        //             data: [25, 50, 60],
        //             backgroundColor: 'rgba(75, 192, 192, 0.2)',
        //             borderColor: 'rgba(75, 192, 192, 1)',
        //             borderWidth: 3
        //         }, {
        //             label: 'Calculator',
        //             data: [35, 20, 65],
        //             backgroundColor: 'rgba(192, 75, 192, 0.2)',
        //             borderColor: 'rgba(192, 75, 192, 1)',
        //             borderWidth: 3
        //         }, {
        //             label: 'Jsonplacholder',
        //             data: [20, 40, 70, 100, 90],
        //             backgroundColor: 'rgba(100, 75, 0, 0.2)',
        //             borderColor: 'rgba(100, 75, 0, 1)',
        //             borderWidth: 3
        //         }]
        //     },
        //     options: {
        //         responsive: true,
        //         plugins: {
        //             legend: {
        //                 position: 'top',
        //             },
        //             title: {
        //                 display: true,
        //                 text: 'TOP 10 API USAGE DURING PAST 30 DAYS'
        //             }
        //         }
        //     }
        // });

        // var ctx5 = document.getElementById('lineChart2').getContext('2d');
        // var chart = new Chart(ctx5, {
        //     type: 'line',
        //     data: {
        //         labels: ['1-mei-2023', '1-june-2023', '1-July-2023', '1-Aug-2023', '1-Sep-2023'],
        //         datasets: [{
        //             label: 'PizzaShack',
        //             data: [25, 50, 60],
        //             backgroundColor: 'rgba(75, 192, 192, 0.2)',
        //             borderColor: 'rgba(75, 192, 192, 1)',
        //             borderWidth: 3
        //         }, {
        //             label: 'Calculator',
        //             data: [35, 20, 65],
        //             backgroundColor: 'rgba(192, 75, 192, 0.2)',
        //             borderColor: 'rgba(192, 75, 192, 1)',
        //             borderWidth: 3
        //         }, {
        //             label: 'Jsonplacholder',
        //             data: [20, 40, 70, 100, 90],
        //             backgroundColor: 'rgba(100, 75, 0, 0.2)',
        //             borderColor: 'rgba(100, 75, 0, 1)',
        //             borderWidth: 3
        //         }]
        //     },
        //     options: {
        //         responsive: true,
        //         plugins: {
        //             legend: {
        //                 position: 'top',
        //             },
        //             title: {
        //                 display: true,
        //                 text: 'API Fault Overtime'
        //             }
        //         }
        //     }
        // });

    </script>
@endpush
@endsection
