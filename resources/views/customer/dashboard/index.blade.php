@extends('app')
@section('content')

<div class="container">
    <div class="row my-5">
        <div class="col-12">
            <div class="row">
                <div class="col-12 col-lg-6">
                    <h1>Dashboard</h1>
                </div>
                <div class="col-12 col-lg-6">
                    <form class="row" action="">
                        <div class="col-6">
                            <input type="date" class="form-control" name="" id="">
                        </div>
                        <div class="col-6">
                            <input type="date" class="form-control" name="" id="">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-12 mt-5">
            <div class="row">
                <div class="col-12 col-lg-3">
                    <div class="card card-shadow-app rounded-4">
                        <div class="card-body">
                            <h5>Coming soon!</h5>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-3">
                    <div class="card card-shadow-app rounded-4">
                        <div class="card-body">
                            <h5>Coming soon!</h5>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-3">
                    <div class="card card-shadow-app rounded-4">
                        <div class="card-body">
                            <h5>Coming soon!</h5>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-3">
                    <div class="card card-shadow-app rounded-4">
                        <div class="card-body">
                            <h5>Coming soon!</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 my-5" id="data-chart-customer">   
            <div class="row g-5">
                <div class="col-6">
                    <div class="card card-shadow-app rounded-4">
                        <div class="card-body row justify-content-center">
                            <div style="width:400px;">
                                <canvas id="myChart1"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card card-shadow-app rounded-4">
                        <div class="card-body row justify-content-center">
                            <div style="width:400px;">
                                <canvas id="myChart2"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card card-shadow-app rounded-4">
                        <div class="card-body row justify-content-center">
                            <div style="width:400px;">
                                <canvas id="myChart3"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card card-shadow-app rounded-4">
                        <div class="card-body">
                            <table class="table table-striped" id="data-table-dashboard-quota-subscription" style="width:100%">
                                <thead class="table-orange">
                                    <tr>
                                        <th>Subscription</th>
                                        <th>Type</th>
                                        <th>Quota</th>
                                        <th>Remaining</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Pizzahack</td>
                                        <td>Period Monthly</td>
                                        <td>30 days</td>
                                        <td><div class="progress">
                                            <div class="progress-bar" role="progressbar" aria-label="Example with label" style="width: 30%;" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">30</div>
                                          </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card card-shadow-app rounded-4">
                        <div class="card-body row justify-content-center">
                            <div style="width:400px;">

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card card-shadow-app rounded-4">
                        <div class="card-body">
                            <h1>Coming soon!</h1>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card card-shadow-app rounded-4">
                        <div class="card-body">
                            <table class="table table-striped" id="data-table-dashboard-fault-overtime" style="width:100%">
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
            </div>
        </div>
    </div>
</div>

@push('script')
<script>
    $(document).ready(function () {
        $('#data-table-dashboard-quota-subscription').DataTable({
            responsive: true,
            lengthMenu: [
                [5, 25, 50, -1],
                [10, 25, 50, 'All'],
            ],
        });
    });
    
    $(document).ready(function () {
        $('#data-table-dashboard-fault-overtime').DataTable({
            responsive: true,
            lengthMenu: [
                [5, 25, 50, -1],
                [10, 25, 50, 'All'],
            ],
        });
    });


    const ctx1 = document.getElementById('myChart1').getContext('2d');
    const ctx2 = document.getElementById('myChart2').getContext('2d');
    const ctx3 = document.getElementById('myChart3').getContext('2d');

    ctx1.canvas.width = 50;
    ctx1.canvas.height = 50;
    var data = {
        labels: [
            'Red',
            'Blue',
            'Yellow'
        ],
        datasets: [{
            label: 'My First Dataset',
            data: [300, 50, 100],
            backgroundColor: [
                'rgb(255, 99, 132)',
                'rgb(54, 162, 235)',
                'rgb(255, 205, 86)'
            ],  
            hoverOffset: 4
        }]
    };

    new Chart(ctx1, {
        type: 'doughnut',
        data: data,
        responsive: true,
    });

    ctx2.canvas.width = 50;
    ctx2.canvas.height = 50;
    var data = {
        labels: [
            'Red',
            'Blue',
            'Yellow'
        ],
        datasets: [{
            label: 'My First Dataset',
            data: [300, 50, 100],
            backgroundColor: [
                'rgb(255, 99, 132)',
                'rgb(54, 162, 235)',
                'rgb(255, 205, 86)'
            ],  
            hoverOffset: 4
        }]
    };

    new Chart(ctx2, {
        type: 'doughnut',
        data: data,
        responsive: true,
    });

    ctx3.canvas.width = 50;
    ctx3.canvas.height = 50;
    var data = {
        labels: [
            'Red',
            'Blue',
            'Yellow'
        ],
        datasets: [{
            label: 'My First Dataset',
            data: [300, 50, 100],
            backgroundColor: [
                'rgb(255, 99, 132)',
                'rgb(54, 162, 235)',
                'rgb(255, 205, 86)'
            ],  
            hoverOffset: 4
        }]
    };

    new Chart(ctx3, {
        type: 'doughnut',
        data: data,
        responsive: true,
    });



</script>
@endpush

  
@endsection
